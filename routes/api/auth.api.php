<?php

Route::group(['prefix' => 'auth'], function (){
    Route::post('login', 'Auth\AuthController@login');
    Route::post('register', 'Auth\AuthController@register');
    Route::post('forgot-password-send-key', 'Auth\ForgotPasswordController@sendKeyVerify');
    Route::post('new-password', 'Auth\ForgotPasswordController@newPassword');
});
