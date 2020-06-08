<?php
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::post('index', 'Admin\AdminController@index');
    Route::group(['prefix' => 'users'], function () {
        Route::post('get', 'Admin\Users\UserController@getUsers');
        Route::post('change-activate/{value}/{userId}', 'Admin\Users\UserController@changeActivated');
        Route::post('change-lock/{value}/{userId}', 'Admin\Users\UserController@changeLocked');
        Route::post('find/{userId}', 'Admin\Users\UserController@findUser');
    });
    Route::group(['prefix' => 'articles'], function () {
       Route::post('get', 'Admin\Articles\ArticleController@getArticles');
       Route::post('change-status/{status}/{articleId}', 'Admin\Articles\ArticleController@changeStatus');
       Route::post('find/{articleId}', 'Admin\Articles\ArticleController@findArticle');
    });
});
