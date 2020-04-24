<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Articles\ArticleResource;
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

    public function getLatestFourArticles(){
        return ArticleResource::collection($this->homeRepository->getLatestFourArticles());
    }
}
