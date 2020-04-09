<?php

Route::post('articles', 'Front\Articles\ArticleController@items');
Route::post('article/{id}', 'Front\Articles\ArticleController@item');
