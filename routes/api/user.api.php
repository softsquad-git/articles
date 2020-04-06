<?php

Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
    Route::post('', 'LoggedController@user');
});
