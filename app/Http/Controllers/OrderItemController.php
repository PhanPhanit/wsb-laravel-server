<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function createOrderItem(Request $request)
    {
        $rules = [
            'image' => 'required',
            'quantity' => 'required',
            'product' => 'required'
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
        $isProductExist = Product::find($request->input('product'));
        if(!$isProductExist){
            return response([
                'message' => 'No product with id: ' . $request->input('product')
            ], 404);
        }
        $isAlreadyAdd = OrderItem::where([
            ['product', '=', $request->input('product')],
            ['user', '=', $request->user()->id]
        ])->first();

        if($isAlreadyAdd){
            $isAlreadyAdd->quantity += 1;
            $isAlreadyAdd->save();
            return response([
                'orderItem' => OrderItem::where('id', $isAlreadyAdd->id)->with('product:id,name,price,discount,author')->first()
            ], 200);
        }
        $createOrderItem = OrderItem::create([
            'image' => $request->input('image'),
            'quantity' => $request->input('quantity'),
            'product' => $request->input('product'),
            'user' => $request->user()->id
        ]);

        return response([
            'orderItem' => OrderItem::where('id', $createOrderItem->id)->with('product:id,name,price,discount,author')->first()
        ], 201);
    }
    public function getOrderItem(Request $request)
    {
        $query = OrderItem::where('user', '=', $request->user()->id)
            ->with('product:id,name,price,discount,author');

        if($request->filled('id')){
            $query = $query->where('id', '=', $request->input('id'));
        }
        if($request->filled('product')){
            $query = $query->where('product', '=', $request->input('product'));
        }
        if($request->input('populate')=='user'){
            $query = $query->with('user:id,name,email,googleId,facebookId,role,isActive');
        }

        if($request->filled('sort')){
            $sortText = $request->input('sort');
            $sort = $sortText[0]=="-"?"DESC":"ASC";
            $field = $sortText[0]=="-"?substr($sortText, 1):$sortText;
            $query = $query->orderBy($field, $sort);
        }
        $orderItem = $query->get();
        return response()->json([
            'orderItem' => $orderItem,
            'count' => count($orderItem)
        ], 200);
    }
    public function getSingleOrderItem(Request $request, $orderItemId)
    {
        $orderItem = OrderItem::where([
            ['id', '=', $orderItemId],
            ['user', '=', $request->user()->id]
        ])->with('product:id,name,price,discount,author')->first();
        if(!$orderItem){
            return response([
                'message' => 'No order item'
            ], 404);
        }
        return response([
            'orderItem' => $orderItem
        ], 200);
    }
    public function updateOrderItem(Request $request, $orderItemId)
    {
        $rules = [
            'quantity' => 'required',
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
        $orderItem = OrderItem::where([
            ['id', '=', $orderItemId],
            ['user', '=', $request->user()->id]
        ])->with('product:id,name,price,discount,author')->first();
        if(!$orderItem){
            return response([
                'message' => 'No order item with id: '.$orderItemId.' and user id: ' . $request->user()->id
            ], 404);
        }

        $orderItem->update([
            'quantity' => $request->input('quantity')
        ]);

        return response([
            'orderItem' => $orderItem
        ], 200);
    }
    public function deleteOrderItem(Request $request, $orderItemId)
    {
        $orderItem = OrderItem::where([
            ['id', '=', $orderItemId],
            ['user', '=', $request->user()->id]
        ])->first();
        if(!$orderItem){
            return response([
                'message' => 'No order item with id: '.$orderItemId.' and user id: ' . $request->user()->id
            ], 404);
        }
        $orderItem->delete();
        return response([
            'message' => 'Order item has been deleted.'
        ], 200);
    }
    public function deleteManyOrderItem(Request $request)
    {
        $orderItem = OrderItem::where('user', '=', $request->user()->id)->delete();
        return response([
            'message' => 'All order item have been deleted.'
        ], 200);
    }
}
