<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\FileUploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth route
Route::prefix('v1/auth')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);
    Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});
// User route
Route::prefix('v1/users')->group(function(){
    Route::post('/', [UsersController::class, 'createUser'])->middleware(['auth:sanctum', 'authorizePermission:admin']);
    Route::get('/showMe', [UsersController::class, 'showCurrentUser'])->middleware('auth:sanctum');
    Route::get('/count-all-user', [UsersController::class, 'countAllUser'])->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::get('/', [UsersController::class, 'getAllUser'])->middleware(['auth:sanctum', 'authorizePermission:admin']);
    Route::get('/{user}', [UsersController::class, 'getSingleUser'])->middleware('auth:sanctum');
    Route::patch('/updateUserPassword', [UsersController::class, 'updateUserPassword'])->middleware('auth:sanctum');
    Route::patch('/updateUser', [UsersController::class, 'updateUser'])->middleware('auth:sanctum');
    Route::patch('/{user}', [UsersController::class, 'adminUpdateUser'])->middleware('auth:sanctum');
    Route::delete('/{user}', [UsersController::class, 'deleteUser'])->middleware(['auth:sanctum', 'authorizePermission:admin']);
});
// Category route
Route::controller(CategoryController::class)->prefix('v1/wsb-cate')->group(function(){
    Route::post('/', 'createCategory')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::get('/', 'getAllCategory');
    Route::get('/all', 'adminGetallCategory')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::patch('/{category}', 'updateCategory')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::delete('/{category}', 'deleteCategory')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
});

// Product route
Route::controller(ProductController::class)->prefix('v1/wsb-pro')->group(function(){
    Route::post('/', 'createProduct')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::get('/', 'getAllProducts');
    Route::get('/increase-view/{product}', 'increaseViewProduct');
    Route::get('/all', 'adminGetAllProducts')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::get('/{product}/all', 'adminGetSingleProduct')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::get('/{product}', 'getSingleProduct');
    Route::patch('/{product}', 'updateProduct')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::delete('/{product}', 'deleteProduct')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
});

// Slide route
Route::controller(SlideController::class)->prefix('v1/wsb-slide')->group(function(){
    Route::post('/', 'createSlide')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::get('/', 'getAllSlide');
    Route::get('/admin', 'adminGetAllSlide')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::get('/{slide}', 'getSingleSlide')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::patch('/{slide}', 'updateSlide')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::delete('/{slide}', 'deleteSlide')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
});

// Review route
Route::controller(ReviewController::class)->prefix('v1/wsb-rev')->group(function(){
    Route::post('/', 'createReview')->middleware('auth:sanctum');
    Route::get('/', 'getAllReviews');
    Route::get('/star-percent/{product}', 'starPercent');
    Route::get('/{review}', 'getSingleReview');
    Route::patch('/{review}', 'updateReview')->middleware('auth:sanctum');
    Route::delete('/{review}', 'deleteReview')->middleware('auth:sanctum');
});

// Order item route
Route::controller(OrderItemController::class)->prefix('v1/wsb-od-item')->group(function(){
    Route::post('/', 'createOrderItem')->middleware('auth:sanctum');
    Route::get('/', 'getOrderItem')->middleware('auth:sanctum');
    Route::delete('/', 'deleteManyOrderItem')->middleware('auth:sanctum');
    Route::get('/{orderItem}', 'getSingleOrderItem')->middleware('auth:sanctum');
    Route::patch('/{orderItem}', 'updateOrderItem')->middleware('auth:sanctum');
    Route::delete('/{orderItem}', 'deleteOrderItem')->middleware('auth:sanctum');
});

// Checkout with stripe
Route::controller(CheckoutController::class)->prefix('v1/wsb-ch-out')->group(function(){
    Route::post('/create-payment-intent', 'createPaymentIntent')->middleware('auth:sanctum');
});

// File upload
Route::controller(FileUploadController::class)->prefix('v1/wsb-upload')->group(function(){
    Route::post('/upload-cloud', 'uploadImageCloud');
});

// Order route
Route::controller(OrderController::class)->prefix('v1/wsb-od')->group(function(){
    Route::post('/', 'createOrder')->middleware('auth:sanctum');
    Route::get('/', 'getAllOrder')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::get('/show-all-my-order', 'getCurrentUserOrder')->middleware('auth:sanctum');
    Route::get('/get-total-order', 'getTotalOrder')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::get('/get-total-price', 'getTotalPrice')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
    Route::get('/{order}', 'getSingleOrder')->middleware('auth:sanctum');
    Route::patch('/{order}', 'updateOrder')->middleware(['auth:sanctum', 'authorizePermission:admin,manager']);
});