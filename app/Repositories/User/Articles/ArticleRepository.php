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
        $category = $search['category'];

        $items = Article::orderBy('id', $search['ordering'] ?? 'DESC')
            ->where('user_id', Auth::id());

        if (!empty($status))
            $items->where('status', $status);
        if (!empty($category))
            $items->where('category_id', $category);

        return $items
            ->paginate(10);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function find(int $id)
    {
        $item = Article::find($id);
        if (empty($item))
            throw new \Exception(sprintf('Article not found'));
        return $item;
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
