<?php

Route::post('articles', 'Front\Articles\ArticleController@items');
Route::post('article/{id}', 'Front\Articles\ArticleController@item');
Route::post('get-images-article/{id}', 'Users\Articles\ArticleController@getImages');
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
    Route::post('groups', 'Front\Groups\GroupController@getGroups');
    Route::post('like', 'Likes\LikeController@like');
    Route::post('get-like', 'Likes\LikeController@getLike');
    Route::post('follow', 'Follows\FollowController@follow');
    Route::post('get-follow', 'Follows\FollowController@getFollow');
    Route::post('article-rating', 'Front\Articles\RatingArticleController@store');
});

Route::group(['prefix' => 'profile-page'], function (){
    Route::post('user/{id}', 'Front\Profile\ProfileController@user');
    Route::post('articles', 'Front\Profile\ProfileController@articles');
    Route::post('albums', 'Front\Profile\ProfileController@albums');
    Route::post('photos', 'Front\Profile\ProfileController@photos');
    Route::post('friends/{user_id}', 'Front\Profile\ProfileController@friends');
});
Route::post('categories-all', 'Categories\CategoryController@all');
Route::post('peoples', 'Front\Friends\FriendController@usersList');

Route::group(['prefix' => 'home'], function (){
    Route::post('latest-four-articles', 'Home\HomePageController@getLatestFourArticles');
    Route::post('categories', 'Home\HomePageController@getCategories');
    Route::post('articles-from-category/{id}', 'Home\HomePageController@getArticleFromCategory');
    Route::post('articles-author-service', 'Home\HomePageController@getArticlesAuthorService');
    Route::post('articles-featured', 'Home\HomePageController@getFeaturedArticles');
    Route::post('latest-photos', 'Home\HomePageController@getLatestPhotos');
});
