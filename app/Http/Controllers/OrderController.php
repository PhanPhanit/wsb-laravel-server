<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderItemSuccess;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $rules = [
            'delivery' => 'required',
            'paymentIntent' => 'required',
            'phoneNumber' => 'required',
            'city' => 'required',
            'address' => 'required',
            'orderDate' => 'required',
            'orderItem' => 'required|array|min:1'
        ];
        $validated = \Validator::make($request->all(), $rules);
        if($validated->fails())
        {
            $errorArray = $validated->errors()->get('*');
            $errorMessage = "The ";
            foreach(array_keys($errorArray) as $keyError){
                $errorMessage .= $keyError." field ";
            }
            $errorMessage .= "required";
            return response()->json([
                "message" => $errorMessage
            ], 400);
        }

        $items = [];
        $subtotal = 0;
        $orderItem = $request->input('orderItem');
        foreach($orderItem as $item){
            $productExist = Product::find($item['product']);
            if(!$productExist){
                return response([
                    'message' => 'No product with id: ' . $item['product']
                ], 404);
            }
            $singleItem = [
                'name' => $productExist->name,
                'image' => $item['image'],
                'price' => $productExist->price,
                'discount' => $productExist->discount,
                'quantity' => $item['quantity'],
                'product' => $productExist->id
            ];
            $items[] = $singleItem;
            $subtotal += ($productExist->price - $productExist->discount) * $item['quantity'];
        }
        $total = $subtotal + $request->input('delivery');

        $order = Order::create([
            'delivery' => $request->input('delivery'),
            'subtotal' => $subtotal,
            'total' => $total,
            'user' => $request->user()->id,
            'paymentIntent' => $request->input('paymentIntent'),
            'phoneNumber' => $request->input('phoneNumber'),
            'city' => $request->input('city'),
            'address' => $request->input('address'),
            'orderDate' => $request->input('orderDate')
        ]);
        $order->orderItem()->createMany($items);
        // Change array key from order_item to orderItem
        $orderWithItem = Order::where('id', $order->id)->with('orderItem', 'user')->first();
        $orderWithItem = $orderWithItem->toArray();
        $orderWithItem['orderItem'] = $orderWithItem['order_item'];
        unset($orderWithItem['order_item']);
        return response([
            'order' => $orderWithItem
        ], 201);

        return $orderWithItem;
    }
    public function getAllOrder(Request $request)
    {
        $query = Order::with('orderItem', 'user');
        if($request->filled('search')){
            $search = $request->input('search');
            $query = $query->where('id', is_numeric($search)?$search:null)
                ->orWhere('paymentIntent', 'like', '%'.$search.'%')
                ->orWhere('phoneNumber', 'like', '%'.$search.'%')
                ->orWhere('city', 'like', '%'.$search.'%')
                ->orWhere('address', 'like', '%'.$search.'%')
                ->orWhere('status', '=', $search)
                ->orWhere('user', '=', $search);
        }
        if($request->filled('id')){
            $query = $query->where('id', '=', $request->input('id'));
        }
        if($request->filled('status')){
            $query = $query->where('status', '=', $request->input('status'));
        }
        if($request->filled('user')){
            $query = $query->where('user', '=', $request->input('user'));
        }
        if($request->has('sort')){
            $sortText = $request->input('sort');
            $sort = $sortText[0]=="-"?"DESC":"ASC";
            $field = $sortText[0]=="-"?substr($sortText, 1):$sortText;
            $query = $query->orderBy($field, $sort);
        }

        $totalOrder = $query->count();
        $page = $request->input('page')?(int) $request->input('page') : 1;
        $limit = $request->input('limit')?(int) $request->input('limit') : 10;
        $skip = ($page-1) * $limit;
        $totalPage = ceil($totalOrder / $limit);
        $order = $query->skip($skip)->take($limit)->get();
        // Change array key from order_item to orderItem
        $order = array_map(function($item){
            $item['orderItem'] = $item['order_item'];
            unset($item['order_item']);
            return $item;
        }, $order->toArray());


        return response()->json([
            "order" => $order,
            "count" => count($order),
            "currentPage" => $page,
            "totalPage" => $totalPage,
            "totalOrder" => $totalOrder
        ], 200);
    }
    public function getSingleOrder(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)->with('orderItem', 'user')->first();
        if(!$order){
            return response([
                'message' => 'No order with id: ' . $orderId
            ], 404);
        }
        if($request->user()->role=='user'){
            if($request->user()->id != $order->user){
                return response([
                    'message' => 'Not authorized to access this route'
                ], 401);
            }
        }
        $order = $order->toArray();
        $order['orderItem'] = $order['order_item'];
        unset($order['order_item']);

        return response([
            'order' => $order
        ], 200);
    }
    public function getCurrentUserOrder(Request $request)
    {
        $query = Order::where('user', $request->user()->id)
            ->with('orderItem', 'user')
            ->orderBy('created_at', 'DESC');

        $totalOrder = $query->count();
        $page = $request->input('page')?(int) $request->input('page') : 1;
        $limit = $request->input('limit')?(int) $request->input('limit') : 10;
        $skip = ($page-1) * $limit;
        $totalPage = ceil($totalOrder / $limit);
        $order = $query->skip($skip)->take($limit)->get();
        
        // Change array key from order_item to orderItem
        $order = array_map(function($item){
            $item['orderItem'] = $item['order_item'];
            unset($item['order_item']);
            return $item;
        }, $order->toArray());

        return response()->json([
            "order" => $order,
            "count" => count($order),
            "currentPage" => $page,
            "totalPage" => $totalPage,
            "totalOrder" => $totalOrder
        ], 200);
    }
    public function updateOrder(Request $request, $orderId)
    {

        if(!$request->filled('status')){
            return response([
                'message' => 'The status field required.'
            ], 400);
        }

        $order = Order::where('id', $orderId)
            ->with('orderItem', 'user')->first();

        if(!$order){
            return response([
                'message' => 'No order with id: ' . $orderId
            ], 404);
        }

        $order->status = $request->input('status');
        $order->save();

        $order = $order->toArray();
        $order['orderItem'] = $order['order_item'];
        unset($order['order_item']);

        
        return response([
            'order' => $order
        ], 200);
    }
    public function getTotalOrder(Request $request)
    {
        $query = new Order;
        if($request->filled('status')){
            $query = $query->where('status', '=', $request->input('status'));
        }
        if($request->filled('user')){
            $query = $query->where('user', '=', $request->input('user'));
        }
        $totalOrder = $query->count();
        return response([
            'totalOrder' => $totalOrder
        ], 200);
    }
    public function getTotalPrice(Request $request)
    {
        $query = new Order;
        if($request->filled('status')){
            $query = $query->where('status', '=', $request->input('status'));
        }
        if($request->filled('user')){
            $query = $query->where('user', '=', $request->input('user'));
        }
        $totalPrice = $query->sum('total');
        $totalPrice = (float) $totalPrice;
        return response([
            'totalPrice' => $totalPrice
        ], 200);
    }
}
