<?php

namespace App\Services\User\Articles;

use App\Models\Articles\Article;
use App\Models\Articles\ImagesArticle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleService
{

    const IMAGES_ARTICLE_PATH = 'assets/data/articles/images/';

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
        $articles = [];
        $b_path = ArticleService::IMAGES_ARTICLE_PATH;
        foreach ($images as $image) {
            $file_name = md5(time() . Str::random(32)) . '.' . $image->getClientOriginalExtension();
            $image->move($b_path, $file_name);
            $article = ImagesArticle::create([
                'user_id' => Auth::id(),
                'article_id' => $article_id,
                'src' => $file_name
            ]);

            $articles[] = $article;
        }

        return $articles;
    }

}
