<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function createReview(Request $request)
    {
        $rules = [
            'rating' => 'required|numeric|between:0.5,5',
            'comment' => 'required',
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

        $alreadySubmited = Review::where([
            ['product', '=', $request->input('product')],
            ['user', '=', $request->user()->id]
        ])->first();

        // if($alreadySubmited){
        //     return response([
        //         'message' => 'Already submitted review for this product'
        //     ], 400);
        // }

        $review = Review::create([
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'user' => $request->user()->id,
            'product' => $request->input('product')
        ]);

        // $updateProduct = DB::table('reviews')
        //     ->select(DB::raw('count(*) as numOfReviews, round(avg(rating),1) as averageRating'))
        //     ->where('product', '=', $request->input('product'))
        //     ->first();

        $updateProduct = DB::table('reviews')
            ->select(DB::raw('count(*) as num_of_reviews'), DB::raw('round(avg(rating),1) as average_rating'))
            ->where('product', '=', $request->input('product'))
            ->first();
        
        $productNumOfReview = Review::where('product', '=', $request->input('product'))->count();
        $productAverageRating = Review::where('product', '=', $request->input('product'))->avg('rating');
        return response([
            "productNumOfReview" => $productNumOfReview,
            "productAverageRating" => $productAverageRating,
            "updateProduct" => $updateProduct->num_of_reviews,
            "test" => $updateProduct->average_rating
        ], 200);

        // $product->numOfReviews = $updateProduct->numOfReviews;
        // $product->averageRating = $updateProduct->averageRating;
        // $product->save();
        return response([
            'review' => Review::find($review->id)
        ], 201);
    }
    public function getAllReviews(Request $request)
    {
        $query = new Review;
        if($request->filled('comment')){
            $query = $query->where('comment', 'Like', '%'.$request->input('comment').'%');
        }
        if($request->filled('id')){
            $query = $query->where('id', '=', $request->input('id'));
        }
        if($request->filled('product')){
            $query = $query->where('product', '=', $request->input('product'));
        }
        if($request->has('populate')){
            $populateArray = explode(",", $request->input('populate'));
            foreach($populateArray as $populate){
                if($populate=="user"){
                    $query = $query->with('user:id,name,email,googleId,facebookId,role,isActive');
                }
                if($populate=="product"){
                    $query = $query->with('product');
                }
            }
        }
        if($request->has('sort')){
            $sortText = $request->input('sort');
            $sort = $sortText[0]=="-"?"DESC":"ASC";
            $field = $sortText[0]=="-"?substr($sortText, 1):$sortText;
            $query = $query->orderBy($field, $sort);
        }

        $totalReview = $query->count();
        $page = $request->input('page')?(int) $request->input('page') : 1;
        $limit = $request->input('limit')?(int) $request->input('limit') : 10;
        $skip = ($page-1) * $limit;
        $totalPage = ceil($totalReview / $limit);
        $review = $query->skip($skip)->take($limit)->get();

        return response()->json([
            "review" => $review,
            "count" => count($review),
            "currentPage" => $page,
            "totalPage" => $totalPage,
            "totalReview" => $totalReview
        ], 200);
    }
    public function getSingleReview($reviewId)
    {
        $review = Review::find($reviewId);
        if(!$review){
            return response([
                'message' => 'No review with id: ' . $reviewId
            ], 404);
        }
        return response([
            'review' => $review
        ], 200);
    }
    public function starPercent($productId)
    {
        $product = Product::find($productId);
        if(!$product){
            return response([
                'message' => 'No product with id: ' . $productId
            ], 404);
        }
        //$totalReview = Review::where('product', '=', $productId)->count();

        $reviewStar = DB::table('reviews')
            ->select(DB::raw('count(*) as count, rating as star'))
            ->where('product', '=', $productId)
            ->groupBy('rating')
            ->get()->toArray();

        
        $totalReview = array_reduce($reviewStar, function($total, $item){
            $total += $item->count;
            return $total;
        }, 0);

        $percentStar = array_map(function($item) use ($totalReview){

            $percent = ($item->count / $totalReview) * 100;
            $percent = round($percent, 2);
            return [
                'star' => (float) $item->star,
                'count' => $item->count,
                'percent' => $percent
            ];
        }, $reviewStar);

        return response([
            'percentStar' => $percentStar,
            'totalReview' => $totalReview
        ], 200);
    }
    public function updateReview(Request $request, $reviewId)
    {
        $input = $request->only([
            'rating',
            'comment',
        ]);

        $review = Review::find($reviewId);
        if(!$review){
            return response([
                'message' => 'No review with id: ' . $reviewId
            ], 404);
        }

        if($request->user()->role==="user"){
            if($review->user!=$request->user()->id){
                return response()->json([
                    "message" => "Not authorized to access this route"
                ], 401);
            }
        }

        if(!Review::where('id', $reviewId)->update($input)){
            return response([
                'message' => 'The review update with id '. $reviewId .' failed.'
            ], 204);
        }
        $updateReview = Review::where('id', $reviewId)->first();
        $updateProduct = DB::table('reviews')
            ->select(DB::raw('round(avg(rating),1) as averageRating'))
            ->where('product', '=', $updateReview->product)
            ->first();
        $product = Product::find($updateReview->product);
        $product->averageRating = $updateProduct->averageRating;
        $product->save();
        return response([
            'review' => $updateReview
        ], 200);
    }
    public function deleteReview(Request $request, $reviewId)
    {
        $review = Review::find($reviewId);
        if(!$review){
            return response([
                'message' => 'No review with id: ' . $reviewId
            ], 404);
        }

        if($request->user()->role==="user"){
            if($review->user!=$request->user()->id){
                return response()->json([
                    "message" => "Not authorized to access this route"
                ], 401);
            }
        }
        $review->delete();
        
        $product = Product::find($review->product);
        $updateProduct = DB::table('reviews')
            ->select(DB::raw('count(*) as numOfReviews, round(avg(rating),1) as averageRating'))
            ->where('product', '=', $review->product)
            ->first();

        $product->numOfReviews = $updateProduct->numOfReviews;
        $product->averageRating = $updateProduct->averageRating;
        $product->save();

        return response([
            'message' => 'Success! Review has been removed.'
        ], 200);

    }
}
