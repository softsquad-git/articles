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

    public function getLatestThreeArticles()
    {
        return Article::orderBy('id', 'DESC')
            ->limit(3)
            ->get();
    }

    public function getLatestNews()
    {
        $articles = Article::orderBy('id', 'DESC')
            ->limit(10)
            ->get();
        return $articles->random(4);
    }

    public function getPopularNews()
    {
        return Article::orderBy('views', 'DESC')
            ->limit(3)
            ->get();
    }

    public function getCategories(){
        return Category::where('status', 1)
            ->get();
    }

    public function getAuthorNews()
    {
        return Article::where('status', Status::ARTICLE_AUTHOR)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function getSelectedPhotos()
    {
        return Photos::orderBy('id', 'DESC')
            ->limit(18)
            ->get();
    }

}
