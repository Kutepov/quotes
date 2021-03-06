<?php

use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\User;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/register', [User::class, 'register']);
Route::post('/user/login', [User::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('quotes', QuoteController::class);
});

Route::get('/quotes', [QuoteController::class, 'index']);
Route::post('/quotes/share', [QuoteController::class, 'share']);
