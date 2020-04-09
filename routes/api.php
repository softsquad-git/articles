<?php

include 'api/auth.api.php';
include 'api/front.api.php';
include 'api/user.api.php';

Route::post('categories', 'Categories\CategoryController@items');
