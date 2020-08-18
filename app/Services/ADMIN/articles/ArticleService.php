<?php


namespace App\Services\ADMIN\articles;

use \Exception;
use App\Repositories\ADMIN\Articles\ArticleRepository;

class ArticleService
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param string $status
     * @param int $articleId
     * @return mixed
     * @throws Exception
     */
    public function changeStatus(string $status, int $articleId)
    {
        $article = $this->articleRepository->findArticle($articleId);
        $article->update([
            'status' => $status
        ]);
        return $article;
    }
}
