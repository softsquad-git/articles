<?php

namespace App\Services\Front\Articles;

use App\Repositories\Front\Articles\ArticleRepository;

class ArticleService
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * ArticleService constructor.
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function view(int $id)
    {
        $item = $this->articleRepository->findArticle($id);
        if (empty($item))
            throw new \Exception(sprintf('Article not found'));
        $_views = $item->views;
        $item->update([
            'views' => $_views + 1
        ]);
        return $item;
    }

}
