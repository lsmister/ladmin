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

Route::middleware('checktoken', 'jsoncors')->group(function () {

    Route::post('user/logout', 'LoginController@logout')->name('logout');

    //用户管理
    Route::prefix('user')->group(function () {
        Route::get('list', 'UserController@getList'); //获取用户列表
        Route::get('rolelist', 'UserController@getRoleList'); //获取用户列表
        Route::get('info', 'UserController@getUserInfo'); //获取用户基本信息
        Route::get('impinfo', 'UserController@getUserInfoImportant'); //获取用户重要信息
        Route::put('updateGoogleStatus', 'UserController@updateGoogleStatus'); //获取用户重要信息
        Route::get('getUserRole', 'UserController@getUserRole'); //获取用户重要信息
        Route::put('update_status/{id}', 'UserController@updateStatus');
    });

    //权限管理
    Route::prefix('permission')->group(function () {
        Route::get('list', 'PermissionController@list'); //权限列表
        Route::get('menu', 'PermissionController@menu'); //权限菜单
        Route::post('add', 'PermissionController@add'); //添加权限
        Route::put('update/{id}', 'PermissionController@update'); //更新权限
        Route::delete('delete/{id}', 'PermissionController@delete'); //删除权限
        Route::put('update_status/{id}', 'PermissionController@updateStatus'); //更新权限状态
    });

    //角色管理
    Route::prefix('role')->group(function () {
        Route::get('list', 'RoleController@list'); //角色列表
        Route::get('permissions', 'RoleController@permissions'); //权限列表
        Route::post('add', 'RoleController@add'); //添加角色
        Route::put('update/{id}', 'RoleController@update'); //更新角色
        Route::delete('delete/{id}', 'RoleController@delete'); //删除角色
    });

});




