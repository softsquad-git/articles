<?php

namespace App\Repositories\User\Articles;

use App\Models\Articles\Article;
use App\Models\Articles\ImagesArticle;
use Illuminate\Support\Facades\Auth;

class ArticleRepository
{

    public function items(array $search)
    {
        $status = $search['status'];

        $items = Article::orderBy('id', 'DESC')
            ->where('user_id', Auth::id());

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

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function getImages(int $id)
    {
        $article = $this->find($id);
        if (empty($article))
            throw new \Exception(sprintf('Article not found'));
        return $article->images;
    }

}
