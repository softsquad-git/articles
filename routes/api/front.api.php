<?php

Route::post('articles', 'Front\Articles\ArticleController@items');
Route::post('article/{id}', 'Front\Articles\ArticleController@item');
Route::group(['prefix' => 'comments'], function () {
    Route::post('', 'Comments\CommentController@items');     #list comments
    Route::group(['prefix' => 'answers'], function () {
        Route::post('{id}', 'Comments\ReplyCommentsController@items');   #list answers
    });
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('store', 'Comments\CommentController@store');
        Route::post('update/{id}', 'Comments\CommentController@update');
        Route::post('remove/{id}', 'Comments\CommentController@remove');
        Route::group(['prefix' => 'reply'], function () {
            Route::post('store', 'Comments\ReplyCommentsController@store');
            Route::post('update/{id}', 'Comments\ReplyCommentsController@update');
            Route::post('remove/{id}', 'Comments\ReplyCommentsController@remove');
        });
    });
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('like', 'Likes\LikeController@like');
    Route::post('get-like', 'Likes\LikeController@getLike');
    Route::post('follow', 'Follows\FollowController@follow');
    Route::post('get-follow', 'Follows\FollowController@getFollow');
});
Route::post('ratings', 'Front\Articles\RatingArticleController@get');
