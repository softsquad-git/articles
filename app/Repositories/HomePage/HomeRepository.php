<?php

namespace App\Repositories\HomePage;

use App\Models\Articles\Article;
use App\Models\Categories\Category;

class HomeRepository
{

    public function getLatestFourArticles(){
        return Article::orderBy('id', 'DESC')
            ->limit(4)
            ->get();
    }

    public function getCategories(){
        return Category::orderBy('id', 'DESC')
            ->limit(8)
            ->get();
    }

}
