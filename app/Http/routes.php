<?php

Route::group(['middlewareGroups' => 'web'], function () {

    Route::get('/login', 'Auth\AuthController@getLogin');
    Route::post('/login', 'Auth\AuthController@postLogin');
    Route::get('/logout', 'HomeController@logout');

    Route::post('/register', 'Auth\AuthController@postRegister');

    Route::get('/', 'HomeController@home');

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/user/{id}', 'UserController@showProfile')->name('showProfile');
        Route::get('/user/{id}/edit', 'UserController@editProfile')->name('editProfile');
        Route::post('/user/{id}/edit', 'UserController@editProfilePost')->name('editProfile');
        Route::post('/user/{id}/editpassword', 'UserController@editPasswordPost')->name('editPassword');

        Route::get('/home', 'HomeController@index');
        Route::get('/game', 'GameController@index');

        Route::group(['middleware' => 'admin'], function () {
            Route::get('/admin', 'AdminController@index')->name('admin');
        });
    });
});
