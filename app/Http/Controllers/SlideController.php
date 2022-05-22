<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Models\Product;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    public function createSlide(Request $request)
    {
        $rules = [
            'title' => 'required',
            'subtitle' => 'required',
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

        $product = Product::find($request->input('product'));
        if(!$product){
            return response([
                'message' => 'No product with id: ' . $request->input('product')
            ], 404);
        }
        $isSlideExist = Slide::where('product', '=', $request->input('product'))->first();
        if($isSlideExist){
            return response([
                'message' => 'Product already exist'
            ], 400);
        }
        $createSlide = Slide::create([
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'product' => $request->input('product'),
            'user' => $request->user()->id
        ]);
        $slide = Slide::where('id', '=', $createSlide->id)->with('product:id,image')->first();
        return response([
            'slide' => $slide
        ], 201);
    }
    public function getAllSlide(Request $request)
    {
        $query = Slide::where('isShow', '=', true)->with('product:id,image');
        if($request->has('title')){
            $query = $query->where('title', 'Like', '%'.$request->input('title').'%');
        }
        if($request->has('id')){
            $query = $query->where('id', '=', $request->input('id'));
        }
        if($request->has('product')){
            $query = $query->where('product', '=', $request->input('product'));
        }
        if($request->input('populate')=="user"){
            $query = $query->with('user:id,name,email,googleId,facebookId,role,isActive');
        }
        if($request->has('sort')){
            $sortText = $request->input('sort');
            $sort = $sortText[0]=="-"?"DESC":"ASC";
            $field = $sortText[0]=="-"?substr($sortText, 1):$sortText;
            $query = $query->orderBy($field, $sort);
        }

        $totalSlide = $query->count();
        $page = $request->input('page')?(int) $request->input('page') : 1;
        $limit = $request->input('limit')?(int) $request->input('limit') : 10;
        $skip = ($page-1) * $limit;
        $totalPage = ceil($totalSlide / $limit);
        $slide = $query->skip($skip)->take($limit)->get();

        return response()->json([
            "slide" => $slide,
            "count" => count($slide),
            "currentPage" => $page,
            "totalPage" => $totalPage,
            "totalSlide" => $totalSlide
        ], 200);
    }
    public function adminGetAllSlide(Request $request)
    {
        $query = Slide::with('product:id,image');
        if($request->filled('isShow')){
            $query = $query->where('isShow', '=', $request->boolean('isShow'));
        }
        if($request->has('title')){
            $query = $query->where('title', 'Like', '%'.$request->input('title').'%');
        }
        if($request->has('id')){
            $query = $query->where('id', '=', $request->input('id'));
        }
        if($request->has('product')){
            $query = $query->where('product', '=', $request->input('product'));
        }
        if($request->input('populate')=="user"){
            $query = $query->with('user:id,name,email,googleId,facebookId,role,isActive');
        }
        if($request->has('sort')){
            $sortText = $request->input('sort');
            $sort = $sortText[0]=="-"?"DESC":"ASC";
            $field = $sortText[0]=="-"?substr($sortText, 1):$sortText;
            $query = $query->orderBy($field, $sort);
        }

        $totalSlide = $query->count();
        $page = $request->input('page')?(int) $request->input('page') : 1;
        $limit = $request->input('limit')?(int) $request->input('limit') : 10;
        $skip = ($page-1) * $limit;
        $totalPage = ceil($totalSlide / $limit);
        $slide = $query->skip($skip)->take($limit)->get();

        return response()->json([
            "slide" => $slide,
            "count" => count($slide),
            "currentPage" => $page,
            "totalPage" => $totalPage,
            "totalSlide" => $totalSlide
        ], 200);
    }
    public function getSingleSlide($slideId)
    {
        $slide = Slide::where('id', $slideId)->with('product:id,image')->first();
        if(!$slide){
            return response([
                'message' => 'No slide with id: ' . $slideId
            ], 404);
        }
        return response([
            'message' => $slide
        ], 200);
    }
    public function updateSlide(Request $request, $slideId)
    {
        $input = $request->only([
            'title',
            'subtitle',
            'isShow',
            'product'
        ]);


        $slide = Slide::find($slideId);
        if(!$slide){
            return response([
                'message' => 'No slide with id: ' . $slideId
            ], 404);
        }
        if($request->filled('product')){
            if($slide->product !== $request->input('product')){
                $productSlideExist = Slide::where('product', $request->input('product'))->first();
                if($productSlideExist){
                    return response([
                        'message' => 'Product already exist'
                    ], 400);
                }else{
                    if(!Product::find($request->input('product'))){
                        return response([
                            'message' => 'No product with id: ' . $request->input('product')
                        ], 404);
                    }
                }
            }
        }

        if(!Slide::where('id', $slideId)->update($input)){
            return response([
                'message' => 'No product with id: ' . $productId
            ], 204);
        }
        return response([
            'slide' => Slide::where('id', $slideId)->with('product:id,image')->first()
        ], 200);
    }
    public function deleteSlide($slideId)
    {
        $slide = Slide::find($slideId);
        if(!$slide){
            return response([
                'message' => 'No slide with id: ' . $slideId
            ], 404);
        }
        $slide->delete();
        return response([
            'message' => 'Success! slide has been removed.'
        ], 200);
    }
}
