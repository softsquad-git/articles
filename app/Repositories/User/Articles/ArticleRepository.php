<?php

namespace App\Repositories\User\Articles;

use App\Models\Articles\Article;
use App\Models\Articles\ImagesArticle;

class ArticleRepository
{

    public function items(array $search)
    {
        $status = $search['status'];

        $items = Article::orderBy('id', 'DESC');

        if (!empty($status))
            $items->where('status', $status);

        return $items
            ->paginate(20);
    }

    public function find($id)
    {
        return Article::find($id);
    }

    public function findImage($id)
    {
        return ImagesArticle::find($id);
    }

}
