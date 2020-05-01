<?php

namespace App\Http\Controllers\Home;

use App\Helpers\GenerateColors;
use App\Http\Controllers\Controller;
use App\Http\Resources\Articles\ArticleResource;
use App\Http\Resources\Categories\CategoryResource;
use App\Repositories\Front\Articles\ArticleRepository;
use App\Repositories\HomePage\HomeRepository;

class HomePageController extends Controller
{
    /**
     * @var HomeRepository
     */
    private $homeRepository;


    public function __construct(HomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    public function getLatestFourArticles()
    {
        return ArticleResource::collection($this->homeRepository->getLatestFourArticles());
    }

    public function getCategories()
    {
        return CategoryResource::collection($this->homeRepository->getCategories());
    }

    public function getArticleFromCategory($id)
    {
        return ArticleResource::collection($this->homeRepository->getArticleFromCategory($id));
    }

    public function getArticlesAuthorService()
    {
        return ArticleResource::collection($this->homeRepository->getArticlesAuthorService());
    }
}
