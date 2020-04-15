<?php

namespace App\Http\Controllers\Front\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Articles\RatingArticleRequest;
use App\Repositories\Front\Articles\RatingArticleRepository;
use App\Services\Front\Articles\RatingArticleService;

class RatingArticleController extends Controller
{
    /**
     * @var $service
     * @var $repository
     */
    private $service;
    private $repository;

    public function __construct(RatingArticleService $service, RatingArticleRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function store(RatingArticleRequest $request)
    {
        $item = $this->service->store($request->all());
        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }

    public function get()
    {
        return RatingArticleRepository::getAverageRatings(1);
    }
}
