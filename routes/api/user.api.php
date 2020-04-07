<?php

Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
    Route::post('', 'LoggedController@user');
    Route::group(['middleware' => 'activated'], function () {
       Route::group(['prefix' => 'articles'], function () {
          Route::post('', 'User\Articles\ArticleController@items');
          Route::post('item/{id}', 'User\Articles\ArticleController@item');
          Route::post('store', 'User\Articles\ArticleController@store');
          Route::post('update/{id}', 'User\Articles\ArticleController@update');
          Route::post('remove/{id}', 'User\Articles\ArticleController@remove');
       });
    });
});
