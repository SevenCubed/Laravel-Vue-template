<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AuthController;
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
//This one's apparently a example
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return dd($request);
});
//Authentication
Route::post('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('loginold', [AuthenticationController::class, 'login'])->name('login');
Route::post('logoutold', [AuthenticationController::class, 'logout'])->name('logout');
Route::post('activeUser', [AuthenticationController::class, 'activeUser'])->name('activeUser');

//Users
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::post('/users/ads', [UserController::class, 'ads'])->name('users.ads');

//Categories
Route::get('/categories', [ProductController::class, 'categories'])->name('products.index');

//Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{product}',[ProductController::class, 'show'])->name('products.show');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

//JWT
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

