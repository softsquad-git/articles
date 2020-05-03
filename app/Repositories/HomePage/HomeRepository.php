<?php

namespace App\Repositories\HomePage;

use App\Helpers\Status;
use App\Models\Articles\Article;
use App\Models\Categories\Category;
use App\Models\Users\Photos\Photos;
use App\Repositories\Categories\CategoryRepository;

class HomeRepository
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getLatestFourArticles()
    {
        return Article::orderBy('id', 'DESC')
            ->limit(4)
            ->get();
    }

    public function getCategories()
    {
        return Category::orderBy('id', 'DESC')
            ->limit(5)
            ->get();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function getArticleFromCategory(int $id)
    {
        if ($id == 0) {
            return Article::orderBy('id', 'DESC')
                ->limit(13)
                ->get();
        }

        $category = $this->categoryRepository->findCategory($id);
        if (empty($category))
            throw new \Exception(sprintf('Category not found'));

        return $category->articles()
            ->orderBy('id', 'DESC')
            ->limit(13)
            ->get();

    }

    public function getArticlesAuthorService()
    {
        return Article::orderBy('id', 'DESC')
            ->where('status', Status::ARTICLE_AUTHOR)
            ->limit(20)
            ->get();
    }

    public function getFeaturedArticles()
    {
        return Article::orderBy('id', 'DESC')
            ->where('status', Status::FEATURED)
            ->limit(5)
            ->get();
    }

    public function getLatestPhotos()
    {
        return Photos::orderBy('id', 'DESC')
            ->limit(16)
            ->get();
    }

}
