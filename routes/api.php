<?php

use Illuminate\Http\Request;

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

Route::get('test', 'TestController@index');
Route::post('user/login', 'LoginController@login')->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('user/info', 'UserController@getUserInfo'); //获取用户信息
});
