<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//进入后台info页面
Route::get('admin/info',function(){
    return view('admin.info');
} );

//测试数据库连接
Route::get('/test', 'IndexController@index');

//进入后台登陆页面
Route::any('admin/login', 'Admin\LoginController@login');


Route::group(['middleware' => ['admin.login'],'prefix' => 'admin','namespace'=> 'Admin'], function(){
    //进入后台首页
    Route::get('index', 'LoginController@index');
    //推出后台
    Route::get('quit', 'LoginController@quit');
    //修改密码
    Route::any('pass', 'LoginController@pass');
});




//生成验证码
Route::get('admin/code', 'Admin\LoginController@code');

//获取验证码
Route::get('admin/getcode', 'Admin\LoginController@getcode');

//字符串加密
Route::get('admin/crypt', 'Admin\LoginController@crypt');

Route::get('excel/export','ExcelController@export');
Route::get('excel/import','ExcelController@import');


