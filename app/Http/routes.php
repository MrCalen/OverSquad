<?php

Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'HomeController@logout');

Route::post('/register', 'Auth\AuthController@postRegister');

Route::get('/', 'HomeController@home');

Route::get('/user/{id}', 'UserController@showProfile')->name('showProfile');
Route::get('/user/{id}/edit', 'UserController@editProfile')->name('editProfile');
Route::post('/user/{id}/edit', 'UserController@editProfilePost')->name('editProfile');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index');
    Route::get('/game', 'GameController@index');
});
