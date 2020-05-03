<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Articles\ArticleResource;
use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\User\Photos\PhotosResource;
use App\Repositories\HomePage\HomeRepository;

class HomePageController extends Controller
{
    /**
     * @var HomeRepository
     */
    private $homeRepository;

    /**
     * HomePageController constructor.
     * @param HomeRepository $homeRepository
     */
    public function __construct(HomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getLatestFourArticles()
    {
        return ArticleResource::collection($this->homeRepository->getLatestFourArticles());
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getCategories()
    {
        return CategoryResource::collection($this->homeRepository->getCategories());
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getArticleFromCategory($id)
    {
        try {
            return ArticleResource::collection($this->homeRepository->getArticleFromCategory($id));
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getArticlesAuthorService()
    {
        return ArticleResource::collection($this->homeRepository->getArticlesAuthorService());
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getFeaturedArticles()
    {
        return ArticleResource::collection($this->homeRepository->getFeaturedArticles());
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getLatestPhotos()
    {
        return PhotosResource::collection($this->homeRepository->getLatestPhotos());
    }
}
