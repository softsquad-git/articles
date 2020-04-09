<?php

include 'api/auth.api.php';
include 'api/front.api.php';
include 'api/user.api.php';

Route::get('categories', 'Categories\CategoryController@items');
