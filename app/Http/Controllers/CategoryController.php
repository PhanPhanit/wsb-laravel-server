<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCategory(Request $request)
    {
        $rules = [
            'name' => 'required',
            'image' => 'required'
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

        $category = Category::create([
            'name' => $request->input('name'),
            'image' => $request->input('image'),
            'user' => $request->user()->id,
            'isShow' => true
        ]);

        return response([
            'category' => $category
        ], 201);
    }
    public function getAllCategory(Request $request)
    {
        $query = Category::where('isShow', '=', true);
        if($request->has('name')){
            $query = $query->where('name', 'Like', '%'.$request->input('name').'%');
        }
        if($request->has('id')){
            $query = $query->where('id', '=', $request->input('id'));
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


        $totalCategory = $query->count();
        $page = $request->input('page')?(int) $request->input('page') : 1;
        $limit = $request->input('limit')?(int) $request->input('limit') : 10;
        $skip = ($page-1) * $limit;
        $totalPage = ceil($totalCategory / $limit);
        $category = $query->skip($skip)->take($limit)->get();

        return response()->json([
            "category" => $category,
            "count" => count($category),
            "currentPage" => $page,
            "totalPage" => $totalPage,
            "totalCategory" => $totalCategory
        ], 200);
    }
    public function adminGetAllCategory(Request $request)
    {
        $query = new Category;
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
        if($request->input('populate')=="user"){
            $query = $query->with('user:id,name,email,googleId,facebookId,role,isActive');
        }
        $totalCategory = $query->count();
        $page = $request->input('page')?(int) $request->input('page') : 1;
        $limit = $request->input('limit')?(int) $request->input('limit') : 10;
        $skip = ($page-1) * $limit;
        $totalPage = ceil($totalCategory / $limit);
        $category = $query->skip($skip)->take($limit)->get();

        return response()->json([
            "category" => $category,
            "count" => count($category),
            "currentPage" => $page,
            "totalPage" => $totalPage,
            "totalCategory" => $totalCategory
        ], 200);
    }
    public function updateCategory(Request $request, $categoryId)
    {
        $rules = [
            'name' => 'required',
            'image' => 'required',
            'isShow' => 'required',
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

        $category = Category::find($categoryId);
        if(!$category){
            return response([
                'message' => 'Not found category with id: '.$categoryId
            ], 404);
        }

        $category->name = $request->input('name');
        $category->image = $request->input('image');
        $category->isShow = $request->input('isShow');
        $category->save();
        
        return response([
            'category' => $category
        ], 200);
    }
    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if(!$category){
            return response([
                'message' => 'No category with id: ' . $categoryId
            ], 404);
        }
        $category->delete();
        return response([
            'message' => 'Success! Cateogry has been removed.'
        ], 200);
    }
}
