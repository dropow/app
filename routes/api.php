<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController; // ApiControllerをインポート

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// レストラン検索のルート
Route::get('/search-restaurants', [ApiController::class, 'searchRestaurants']);

// 店舗の詳細情報を取得するルート
Route::get('/get-restaurant-details/{id}', [ApiController::class, 'getRestaurantDetails']);

Route::get('/genres', [ApiController::class, 'fetchGenres']);

Route::get('/budgets', [ApiController::class, 'fetchBudgets']);