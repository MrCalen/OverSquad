<?php

Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'HomeController@logout');

Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'Auth\AuthController@postRegister');

Route::get('/', 'HomeController@home');

Route::group(['middleware' => 'api', 'prefix' => 'api'], function () {
    Route::get('/profile', 'ProfileController@apiProfile');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index');
    Route::get('/game', 'GameController@index');
});
