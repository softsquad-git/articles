<?php

namespace App\Services\Front\Articles;

use App\Models\Articles\Article;

class ArticleService
{

    public function view(Article $item)
    {
        $_views = $item->views;
        $item->update([
            'views' => $_views + 1
        ]);

        return $item;
    }

}
