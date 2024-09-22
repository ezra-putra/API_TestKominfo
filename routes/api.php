<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/get-product', [ProductController::class, 'getProduct']);
Route::get('/detail-product/{id}', [ProductController::class, 'detailProduct']);
Route::post('/create-product', [ProductController::class, 'createProduct']);
Route::put('/update-product/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/delete-product/{id}', [ProductController::class, 'deleteProduct']);

Route::get('/get-order', [OrderController::class, 'getOrder']);
Route::post('/create-order', [OrderController::class, 'createOrder']);
Route::get('/detail-order/{id}', [OrderController::class, 'detailOrder']);
Route::delete('/delete-order/{id}', [OrderController::class, 'deleteOrder']);
