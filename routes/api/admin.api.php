<?php
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::post('index', 'Admin\AdminController@index');
    Route::group(['prefix' => 'users'], function () {
        Route::get('get', 'Admin\Users\UserController@getUsers');
    });
});
