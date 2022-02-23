<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('user.login');
    })->name('login');
    Route::post('/login', [UserController::class, 'login']);

    Route::get('/register', function () {
        return view('user.register');
    })->name('register');
    Route::post('/register', [UserController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});
