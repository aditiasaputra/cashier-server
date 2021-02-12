<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClaimGiftController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function ($router) {
    // Auth routes
    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/register', [AuthController::class, 'register']);
    $router->post('/logout', [AuthController::class, 'logout']);
    $router->post('/refresh', [AuthController::class, 'refresh']);
    $router->get('/profile', [AuthController::class, 'profile']);
});

// User routes
Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);

// Product routes
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'destroy']);

// Category routes
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::post('categories', [CategoryController::class, 'store']);
Route::put('categories/{id}', [CategoryController::class, 'update']);
Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

// Transaction routes
Route::get('transactions', [TransactionController::class, 'index']);
Route::get('transactions/{id}', [TransactionController::class, 'show']);
Route::post('transactions', [TransactionController::class, 'store']);
Route::put('transactions/{id}', [TransactionController::class, 'update']);
Route::delete('transactions/{id}', [TransactionController::class, 'destroy']);

// Gift routes
Route::get('gifts', [GiftController::class, 'index']);
Route::get('gifts/{id}', [GiftController::class, 'show']);
Route::post('gifts', [GiftController::class, 'store']);
Route::put('gifts/{id}', [GiftController::class, 'update']);
Route::delete('gifts/{id}', [GiftController::class, 'destroy']);

// Claim Gift routes
Route::get('claim-gifts', [ClaimGiftController::class, 'index']);
Route::get('claim-gifts/{id}', [ClaimGiftController::class, 'show']);
Route::post('claim-gifts', [ClaimGiftController::class, 'store']);
Route::put('claim-gifts/{id}', [ClaimGiftController::class, 'update']);
Route::delete('claim-gifts/{id}', [ClaimGiftController::class, 'destroy']);

// History routes
