<?php
Route::post('refresh-token', 'Auth\AuthController@refreshToken');
Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
    Route::get('check-is-activated-account', 'Auth\AuthController@isActivatedAccount');
    Route::post('remove-account', 'Users\Settings\SettingController@removeAccount');
    Route::post('activate', 'Auth\AuthController@activate');
    Route::post('activate-key-refresh', 'Auth\AuthController@refreshKeyActivate');
    Route::post('logout', 'Auth\AuthController@logout');
    Route::post('', 'LoggedController@user');
    Route::group(['middleware' => 'activated'], function () {
        Route::group(['prefix' => 'experts'], function () {
            Route::post('get-categories', 'Users\Experts\ExpertController@getCategories');
            Route::post('register', 'Users\Experts\ExpertController@registerExpert');
            Route::post('remove/{categoryId}', 'Users\Experts\ExpertController@remove');
            Route::group(['prefix' => 'opinions'], function () {
                Route::post('get', 'Users\Experts\ExpertOpinionController@getOpinions');
                Route::post('is-expert/{categoryId}', 'Users\Experts\ExpertOpinionController@isExpertInArticle');
                Route::post('store', 'Users\Experts\ExpertOpinionController@store');
                Route::post('update/{opinionId}', 'Users\Experts\ExpertOpinionController@update');
                Route::post('remove/{opinionId}', 'Users\Experts\ExpertOpinionController@remove');
            });
        });
        Route::group(['prefix' => 'chat'], function () {
            Route::post('', 'Chat\ChatController@getConversations');
            Route::post('store', 'Chat\ChatController@store');
            Route::post('update/{id}', 'Chat\ChatController@update');
            Route::post('remove/{id}', 'Chat\ChatController@remove');
            Route::post('find/{id}', 'Chat\ChatController@find');
            Route::group(['prefix' => 'messages'], function () {
                Route::post('get', 'Chat\ChatMessageController@getMessages');
                Route::post('store', 'Chat\ChatMessageController@store');
                Route::post('update/{id}', 'Chat\ChatMessageController@update');
                Route::post('remove/{id}', 'Chat\ChatMessageController@remove');
            });
        });
        Route::group(['prefix' => 'articles'], function () {
            Route::post('', 'Users\Articles\ArticleController@items');
            Route::post('item/{id}', 'Users\Articles\ArticleController@item');
            Route::post('store', 'Users\Articles\ArticleController@store');
            Route::post('update/{id}', 'Users\Articles\ArticleController@update');
            Route::post('remove/{id}', 'Users\Articles\ArticleController@remove');
            Route::post('archive/{id}', 'Users\Articles\ArticleController@archive');
            Route::post('upload-file-editor', 'Users\Articles\ArticleController@uploadFileEditor');
        });
        Route::group(['prefix' => 'settings'], function () {
            Route::post('basic-data', 'Users\Settings\SettingController@updateBasicData');
            Route::post('try-update-email', 'Users\Settings\SettingController@tryUpdateEmailUser');
            Route::post('update-email', 'Users\Settings\SettingController@updateEmailUser');
            Route::post('check-tmp-email', 'Users\Settings\SettingController@checkTmpEmail');
            Route::post('avatar', 'Users\Settings\SettingController@updateAvatar');
            Route::post('set-template-mode/{type}', 'Users\Settings\SettingController@setTemplateMode');
            Route::post('update-password', 'Users\Settings\SettingController@updatePassword');
        });
        Route::group(['prefix' => 'album-photos'], function () {
            Route::post('', 'Users\Photos\AlbumPhotosController@items');
            Route::post('store', 'Users\Photos\AlbumPhotosController@store');
            Route::post('update/{id}', 'Users\Photos\AlbumPhotosController@update');
            Route::post('remove/{id}', 'Users\Photos\AlbumPhotosController@remove');
        });
        Route::group(['prefix' => 'photos'], function () {
            Route::post('get/{album_id}', 'Users\Photos\PhotoController@items');
            Route::post('store', 'Users\Photos\PhotoController@store');
            Route::post('remove/{id}', 'Users\Photos\PhotoController@remove');
        });
        Route::group(['prefix' => 'follows'], function () {
            Route::post('get/{resource_type}', 'Follows\FollowController@getFollows');
            Route::post('watching-you', 'Follows\FollowController@getWatchingYou');
            Route::post('remove/{id}', 'Follows\FollowController@unFollow');
        });
        Route::group(['prefix' => 'friends'], function () {
            Route::post('', 'Users\Friends\FriendController@friends');
            Route::post('add', 'Users\Friends\FriendController@store');
            Route::post('sent', 'Users\Friends\FriendController@sentInvitations');
            Route::post('waiting', 'Users\Friends\FriendController@waitingInvitations');
            Route::post('remove/{id}', 'Users\Friends\FriendController@remove');
            Route::post('accept/{id}', 'Users\Friends\FriendController@acceptInvitation');
        });
        Route::group(['prefix' => 'groups'], function () {
            Route::post('', 'Users\Groups\GroupController@getGroups');
            Route::post('store', 'Users\Groups\GroupController@store');
            Route::post('update/{id}', 'Users\Groups\GroupController@update');
            Route::post('remove/{id}', 'Users\Groups\GroupController@remove');
            Route::post('preview/{id}', 'Users\Groups\GroupController@preview');
            Route::post('images/{id}', 'Users\Groups\GroupController@getAllImages');
            Route::group(['prefix' => 'users'], function () {
                Route::post('get/{id}', 'Users\Groups\UsersGroupController@getUsersGroup');
                Route::post('store', 'Users\Groups\UsersGroupController@store');
                Route::post('update/{id}', 'Users\Groups\UsersGroupController@update');
                Route::post('remove/{id}', 'Users\Groups\UsersGroupController@remove');
                Route::post('join/{groupId}', 'Users\Groups\UsersGroupController@joinUserGroup');
            });
            Route::group(['prefix' => 'posts'], function () {
                Route::post('accept/{post_id}', 'Users\Groups\PostsGroupController@acceptPost');
                Route::post('admin/{group_id}/{status}', 'Users\Groups\PostsGroupController@getPostsForAdmin');
                Route::post('get/{id}', 'Users\Groups\PostsGroupController@getPostsGroup');
                Route::post('store', 'Users\Groups\PostsGroupController@store');
                Route::post('update/{id}', 'Users\Groups\PostsGroupController@update');
                Route::post('remove/{id}', 'Users\Groups\PostsGroupController@remove');
                Route::post('images/{id}', 'Users\Groups\PostsGroupController@getPostImages');
                Route::post('images/remove/{id}', 'Users\Groups\PostsGroupController@removeImagePost');
                Route::post('images/upload/{id}', 'Users\Groups\PostsGroupController@uploadImagesPost');
            });
        });
    });
});
Route::get('/t', function () {
    event(new \App\Events\Chat\SendChatMessageEvent());
    dd('Success');
});
