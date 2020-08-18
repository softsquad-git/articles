<?php

namespace App\Observer\Articles;

use App\Models\Articles\Article;

class ArticleObserver
{
    public function deleting(Article $article)
    {
        $article->images()->delete();
        $article->likes()->delete();
        $article->follows()->delete();
    }
}
