<?php

use Illuminate\Http\Request;

Route::namespace('Api')->prefix('v1')->middleware('cors')->group(function () {
    Route::middleware('user.guard')->group(function () {
        //用户注册
        Route::post('/users', 'UsersController@store')->name('users.store');
        //用户登录
        Route::post('/login', 'UsersController@login')->name('users.login');

        Route::middleware('token.refresh')->group(function () {
            //当前用户信息
            Route::get('/users/info', 'UsersController@info')->name('users.info');
            //用户列表
            Route::get('/users', 'UsersController@index')->name('users.index');
            //用户信息
            Route::get('/users/{user}', 'UsersController@show')->name('users.show');
            //用户退出
            Route::get('/logout', 'UsersController@logout')->name('users.logout');
        });
    });

    Route::middleware('admin.guard')->group(function () {
        //管理员注册
        Route::post('/admins', 'AdminsController@store')->name('admins.store');
        //管理员登录
        Route::post('/admins/login', 'AdminsController@login')->name('admins.login');
        Route::middleware('token.refresh')->group(function () {
            //当前管理员信息
            Route::get('/admins/info', 'AdminsController@info')->name('admins.info');
            //管理员列表
            Route::get('/admins', 'AdminsController@index')->name('admins.index');
            //管理员信息
            Route::get('/admins/{admin}', 'AdminsController@show')->name('admins.show');
            //管理员退出
            Route::get('/admins/logout', 'AdminsController@logout')->name('admins.logout');
        });
    });
});
