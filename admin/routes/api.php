<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("login",'App\Http\Controllers\AuthController@login');

Route::post('register','App\Http\Controllers\AuthController@register');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post("logout",'App\Http\Controllers\AuthController@logout');
    Route::get('users/{id}', 'App\Http\Controllers\UserController@show');
    Route::post('users','App\Http\Controllers\UserController@store');
    Route::put('users/{id}', 'App\Http\Controllers\UserController@update');
    Route::delete('users/{id}','App\Http\Controllers\UserController@destroy');
    Route::get('users', 'App\Http\Controllers\UserController@index');

    Route::get('user','App\Http\Controllers\UserController@user');
    Route::put('users/info','App\Http\Controllers\UserController@updateInfo');
    Route::put('users/password','App\Http\Controllers\UserController@updatePassword');

    Route::get('roles', 'App\Http\Controllers\RoleController@index');
    Route::get('roles/{id}', 'App\Http\Controllers\RoleController@show');
    Route::post('roles','App\Http\Controllers\RoleController@store');
    Route::put('roles/{id}', 'App\Http\Controllers\RoleController@update');
    Route::delete('roles/{id}','App\Http\Controllers\RoleController@destroy');

    // Route::get('products', 'App\Http\Controllers\ProductController@index');
    Route::apiResource('products','App\Http\Controllers\ProductController');
    Route::apiResource('orders','App\Http\Controllers\OrderController')->only('index','show');
    Route::apiResource('permissions','App\Http\Controllers\PermissionController')->only('index');
    Route::post('upload','App\Http\Controllers\ImageController@upload');
    Route::get('export','App\Http\Controllers\OrderController@export');
    Route::get('chart','App\Http\Controllers\DashboardController@chart');
});


// Route::middleware(['cors'])->group(function () {

// });

