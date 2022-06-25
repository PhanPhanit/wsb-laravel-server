<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'genre' => 'required',
            'language' => 'required',
            'country' => 'required',
            'published' => 'required',
            'description' => 'required',
            'image' => 'required',
            'category' => 'required'
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

        $category = Category::find($request->input('category'));
        if(!$category){
            return response([
                'message' => 'No category with id: ' . $request->input('category')
            ], 404);
        }

        $product = Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount'),
            'author' => $request->input('author'),
            'publisher' => $request->input('publisher'),
            'genre' => $request->input('genre'),
            'language' => $request->input('language'),
            'country' => $request->input('country'),
            'published' => $request->input('published'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
            'user' => $request->user()->id,
            'category' => $request->input('category')
        ]);

        return response([
            'product' => Product::find($product->id)
        ], 201);
    }
    public function getAllProducts(Request $request)
    {
        $query = Product::where('isShow', '=', true);
        if($request->filled('search')){
            $search = $request->input('search');
            $query = $query->where('id', $search)
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('author', 'like', '%'.$search.'%')
                ->orWhere('publisher', 'like', '%'.$search.'%')
                ->orWhere('genre', 'like', '%'.$search.'%')
                ->orWhere('country', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
        }
        if($request->has('name')){
            $query = $query->where('name', 'Like', '%'.$request->input('name').'%');
        }
        if($request->has('id')){
            $query = $query->where('id', '=', $request->input('id'));
        }
        if($request->has('category')){
            $query = $query->where('category', '=', $request->input('category'));
        }
        if($request->has('populate')){
            $populateArray = explode(",", $request->input('populate'));
            foreach($populateArray as $populate){
                if($populate=="user"){
                    $query = $query->with('user:id,name,email,googleId,facebookId,role,isActive');
                }
                if($populate=="category"){
                    $query = $query->with('category:id,name,image,isShow');
                }
            }
        }
        if($request->has('sort')){
            $sortText = $request->input('sort');
            $sort = $sortText[0]=="-"?"DESC":"ASC";
            $field = $sortText[0]=="-"?substr($sortText, 1):$sortText;
            $query = $query->orderBy($field, $sort);
        }

        // $totalProduct = $query->count();
        return "Hello";
        $page = $request->input('page')?(int) $request->input('page') : 1;
        $limit = $request->input('limit')?(int) $request->input('limit') : 10;
        $skip = ($page-1) * $limit;
        $totalPage = ceil($totalProduct / $limit);
        $product = $query->skip($skip)->take($limit)->get();

        return response()->json([
            "product" => $product,
            "count" => count($product),
            "currentPage" => $page,
            "totalPage" => $totalPage,
            "totalProduct" => $totalProduct
        ], 200);
    }
    public function adminGetAllProducts(Request $request)
    {
        $query = new Product;
        if($request->filled('search')){
            $search = $request->input('search');
            $query = $query->where('id', $search)
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('author', 'like', '%'.$search.'%')
                ->orWhere('publisher', 'like', '%'.$search.'%')
                ->orWhere('genre', 'like', '%'.$search.'%')
                ->orWhere('country', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
            if($request->input('search')=='true' || $request->input('search')=='false'){
                $query = $query->orWhere('isShow', $request->boolean('search'));
            }
        }
        if($request->has('isShow')){
            $isShow = $request->input('isShow')=="true"?true:false;
            $query = $query->where('isShow', '=', $isShow);
        }
        if($request->has('name')){
            $query = $query->where('name', 'Like', '%'.$request->input('name').'%');
        }
        if($request->has('id')){
            $query = $query->where('id', '=', $request->input('id'));
        }
        if($request->has('category')){
            $query = $query->where('category', '=', $request->input('category'));
        }
        if($request->has('populate')){
            $populateArray = explode(",", $request->input('populate'));
            foreach($populateArray as $populate){
                if($populate=="user"){
                    $query = $query->with('user:id,name,email,googleId,facebookId,role,isActive');
                }
                if($populate=="category"){
                    $query = $query->with('category:id,name,image,isShow');
                }
            }
        }
        if($request->has('sort')){
            $sortText = $request->input('sort');
            $sort = $sortText[0]=="-"?"DESC":"ASC";
            $field = $sortText[0]=="-"?substr($sortText, 1):$sortText;
            $query = $query->orderBy($field, $sort);
        }

        $totalProduct = $query->count();
        $page = $request->input('page')?(int) $request->input('page') : 1;
        $limit = $request->input('limit')?(int) $request->input('limit') : 10;
        $skip = ($page-1) * $limit;
        $totalPage = ceil($totalProduct / $limit);
        $product = $query->skip($skip)->take($limit)->get();

        return response()->json([
            "product" => $product,
            "count" => count($product),
            "currentPage" => $page,
            "totalPage" => $totalPage,
            "totalProduct" => $totalProduct
        ], 200);
    }
    public function getSingleProduct($productId)
    {
        $product = Product::where([
            ['isShow', '=', true],
            ['id', '=', $productId]
        ])->first();
        if(!$product){
            return response([
                'message' => 'No product with id: ' . $productId
            ], 404);
        }
        return response([
            'product' => $product
        ], 200);
    }
    public function adminGetSingleProduct($productId)
    {
        $product = Product::find($productId);
        if(!$product){
            return response([
                'message' => 'No product with id: ' . $productId
            ], 404);
        }

        return response([
            'product' => $product
        ], 200);
    }
    public function updateProduct(Request $request, $productId)
    {
        $input = $request->only([
            'name',
            'price',
            'discount',
            'author',
            'publisher',
            'genre',
            'language',
            'country',
            'published',
            'description',
            'image',
            'averageRating',
            'numOfReviews',
            'category',
            'sold',
            'views',
            'isShow'
        ]);
        $product = Product::where('id', $productId);
        if(!$product->first()){
            return response([
                'message' => 'No product with id: ' . $productId
            ], 404);
        }
        if(!$product->update($input)){
            return response([
                'message' => 'No product with id: ' . $productId
            ], 204);
        }
        return response([
            'product' => $product->first()
        ], 200);
    }
    public function increaseViewProduct($productId)
    {
        $product = Product::find($productId);
        if(!$product){
            return response([
                'message' => 'No product with id: ' . $productId
            ], 404);
        }
        $product->views = $product->views + 1;
        $product->save();
        return response([
            'message' => 'Increase view successfully.'
        ], 200);
    }
    public function deleteProduct($productId)
    {
        $product = Product::find($productId);
        if(!$product){
            return response([
                'message' => 'No product with id: ' . $productId
            ], 404);
        }
        $product->delete();
        return response([
            'message' => 'Success! Product has been removed.'
        ], 200);
    }
}
