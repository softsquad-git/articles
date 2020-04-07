<?php

namespace App\Services\User\Articles;

use App\Models\Articles\Article;
use Illuminate\Support\Facades\Auth;

class ArticleService
{

    public function store(array $data): Article
    {
        $data['user_id'] = Auth::id();
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

    public function uploadImages($article_id, $images)
    {

    }

}
