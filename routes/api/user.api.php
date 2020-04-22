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
            Route::post('upload-images/{id}', 'User\Articles\ArticleController@uploadImages');
            Route::post('remove-image/{id}', 'User\Articles\ArticleController@removeImage');
            Route::post('archive/{id}', 'User\Articles\ArticleController@archive');
            Route::post('categories', 'Categories\CategoryController@all');
            Route::post('upload-file-editor', 'User\Articles\ArticleController@uploadFileEditor');
        });
        Route::group(['prefix' => 'settings'], function () {
            Route::post('basic-data', 'User\Settings\SettingController@updateBasicData');
            Route::post('try-update-email', 'User\Settings\SettingController@tryUpdateEmailUser');
            Route::post('update-email', 'User\Settings\SettingController@updateEmailUser');
            Route::post('check-tmp-email', 'User\Settings\SettingController@checkTmpEmail');
            Route::post('avatar', 'User\Settings\SettingController@updateAvatar');
        });
        Route::group(['prefix' => 'album-photos'], function () {
            Route::post('', 'User\Photos\AlbumPhotosController@items');
            Route::post('store', 'User\Photos\AlbumPhotosController@store');
            Route::post('update/{id}', 'User\Photos\AlbumPhotosController@update');
            Route::post('remove/{id}', 'User\Photos\AlbumPhotosController@remove');
        });
        Route::group(['prefix' => 'photos'], function () {
            Route::post('get/{album_id}', 'User\Photos\PhotoController@items');
            Route::post('store', 'User\Photos\PhotoController@store');
            Route::post('remove/{id}', 'User\Photos\PhotoController@remove');
        });
        Route::group(['prefix' => 'friends'], function (){
            Route::post('', 'User\Friends\FriendController@friends');
            Route::post('add', 'User\Friends\FriendController@store');
        });
    });
});
