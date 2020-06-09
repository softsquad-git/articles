<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Articles\ArticleResource;
use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\User\Photos\PhotosResource;
use App\Repositories\HomePage\HomeRepository;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use \Illuminate\Http\JsonResponse;

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
     * @return AnonymousResourceCollection
     */
    public function getLatestThreeArticles()
    {
        return ArticleResource::collection($this->homeRepository->getLatestThreeArticles());
    }

    public function getLatestNews()
    {
        try {
            return ArticleResource::collection($this->homeRepository->getLatestNews());
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function getPopularNews()
    {
        try {
            return ArticleResource::collection($this->homeRepository->getPopularNews());
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function getCategories()
    {
        try {
            return CategoryResource::collection($this->homeRepository->getCategories());
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function getAuthorNews()
    {
        try {
            return ArticleResource::collection($this->homeRepository->getAuthorNews());
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function getSelectedPhotos()
    {
        try {
            return PhotosResource::collection($this->homeRepository->getSelectedPhotos());
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
