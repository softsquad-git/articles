<?php
Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\AuthController@logout');
    Route::post('refresh', 'Auth\AuthController@refreshToken');
    Route::post('', 'LoggedController@user');
    Route::group(['middleware' => 'activated'], function () {
        Route::group(['prefix' => 'articles'], function () {
            Route::post('', 'User\Articles\ArticleController@items');
            Route::post('item/{id}', 'User\Articles\ArticleController@item');
            Route::post('store', 'User\Articles\ArticleController@store');
            Route::post('update/{id}', 'User\Articles\ArticleController@update');
            Route::post('remove/{id}', 'User\Articles\ArticleController@remove');
            Route::post('get-images/{id}', 'User\Articles\ArticleController@getImages');
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
        Route::group(['prefix' => 'follows'], function () {
            Route::post('get/{resource_type}', 'Follows\FollowController@getFollows');
            Route::post('watching-you', 'Follows\FollowController@getWatchingYou');
            Route::post('remove/{id}', 'Follows\FollowController@unFollow');
        });
        Route::group(['prefix' => 'friends'], function () {
            Route::post('', 'User\Friends\FriendController@friends');
            Route::post('add', 'User\Friends\FriendController@store');
            Route::post('sent', 'User\Friends\FriendController@sentInvitations');
            Route::post('waiting', 'User\Friends\FriendController@waitingInvitations');
            Route::post('remove/{id}', 'User\Friends\FriendController@remove');
            Route::post('accept/{id}', 'User\Friends\FriendController@acceptInvitation');
        });
        Route::group(['prefix' => 'groups'], function () {
            Route::post('', 'User\Groups\GroupController@getGroups');
            Route::post('store', 'User\Groups\GroupController@store');
            Route::post('update/{id}', 'User\Groups\GroupController@update');
            Route::post('remove/{id}', 'User\Groups\GroupController@remove');
            Route::post('preview/{id}', 'User\Groups\GroupController@preview');
            Route::post('images/{id}', 'User\Groups\GroupController@getAllImages');
            Route::group(['prefix' => 'users'], function () {
               Route::post('get/{id}', 'User\Groups\UsersGroupController@getUsersGroup');
               Route::post('store', 'User\Groups\UsersGroupController@store');
               Route::post('update/{id}', 'User\Groups\UsersGroupController@update');
               Route::post('remove/{id}', 'User\Groups\UsersGroupController@remove');
            });
            Route::group(['prefix' => 'posts'], function () {
                Route::post('get/{id}', 'User\Groups\PostsGroupController@getPostsGroup');
                Route::post('store', 'User\Groups\PostsGroupController@store');
                Route::post('update/{id}', 'User\Groups\PostsGroupController@update');
                Route::post('remove/{id}', 'User\Groups\PostsGroupController@remove');
                Route::post('images/{id}', 'User\Groups\PostsGroupController@getPostImages');
                Route::post('images/remove/{id}', 'User\Groups\PostsGroupController@removeImagePost');
                Route::post('images/upload/{id}', 'User\Groups\PostsGroupController@uploadImagesPost');
            });
        });
    });
});
