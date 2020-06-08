<?php


namespace App\Repositories\ADMIN\Articles;

use \Exception;
use App\Models\Articles\Article;

class ArticleRepository
{
    /**
     * @param array $params
     * @return mixed
     */
    public function getArticles(array $params)
    {
        $title = $params['title'];
        $category = $params['category'];
        $status = $params['status'];
        $location = $params['location'];
        $articles = Article::orderBy('id', 'DESC');
        if (!empty($title))
            $articles->where('title', 'like', '%' . $title . '%');
        if (!empty($category))
            $articles->where('category_id', $category);
        if (!empty($status))
            $articles->where('status', $status);
        if (!empty($location))
            $articles->where('location', $location);
        return $articles->paginate(20);
    }

    /**
     * @param int $articleId
     * @return mixed
     * @throws Exception
     */
    public function findArticle(int $articleId)
    {
        $article = Article::find($articleId);
        if (empty($article))
            throw new Exception('Nie ma takiego artykułu');
        return $article;
    }
}
