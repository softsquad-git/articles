<?php


namespace App\Repositories\Front\Articles;


use App\Helpers\Status;
use App\Models\Articles\Article;

class ArticleRepository
{

    public function items(array $search)
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

    public function find($id)
    {
        return Article::find($id);
    }

}
