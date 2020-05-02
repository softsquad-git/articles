<?php

namespace App\Repositories\Front\Articles;

use App\Helpers\Status;
use App\Models\Articles\Article;

class ArticleRepository
{

    public function getArticles(array $search)
    {
        $title = $search['title'];
        $category = $search['category'];
        $location = $search['location'];
        $items = Article::where('status', Status::ARTICLE_PUBLISHED)
            ->orderBy('id', 'DESC');
        if (!empty($title))
            $items->where('title', 'like', '%' . $title . '%');
        if (!empty($category))
            $items->where('category_id', $category);
        if (!empty($location))
            $items->where('location', $location);

        return $items
            ->paginate(20);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function findArticle(int $id)
    {
        $item = Article::find($id);
        if (empty($item))
            throw new \Exception(sprintf('Article not found'));
        return $item;
    }

}
