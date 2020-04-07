<?php

namespace App\Services\User\Articles;

use App\Models\Articles\Article;

class ArticleService
{

    public function store(array $data): Article
    {
        $item = Article::create($data);

        return $item;
    }

    public function update(array $data, Article $item): Article
    {
        $item->update($data);

        return $item;
    }

    public function remove(Article $item)
    {
        $item->delete();

        return true;
    }

}
