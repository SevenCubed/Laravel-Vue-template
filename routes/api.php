<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthenticationController;
use Illuminate\Auth\Middleware\Authenticate;

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
// DON'T FORGET TO *USE* THE CONTROLLERS ABOVE, OR YOU GET 500 ERRORS
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Authentication
Route::post('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::post('activeUser', [AuthenticationController::class, 'activeUser'])->name('activeUser');

//Users
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

//Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{product}',[ProductController::class, 'show'])->name('products.show');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
