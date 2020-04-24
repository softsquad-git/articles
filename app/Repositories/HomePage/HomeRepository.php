<?php

namespace App\Repositories\HomePage;

use App\Models\Articles\Article;

class HomeRepository
{

    public function getLatestFourArticles(){
        return Article::orderBy('id', 'DESC')
            ->limit(4)
            ->get();
    }

}
