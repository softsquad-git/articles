<?php

namespace App\Http\Controllers\Front\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Articles\RatingArticleRequest;
use App\Repositories\Front\Articles\RatingArticleRepository;
use App\Services\Front\Articles\RatingArticleService;
use \Exception;
use \Illuminate\Http\JsonResponse;

class RatingArticleController extends Controller
{
    /**
     * @var RatingArticleService
     */
    private $ratingArticleService;

    /**
     * @var RatingArticleRepository
     */
    private $ratingArticleRepository;

    /**
     * @param RatingArticleService $ratingArticleService
     * @param RatingArticleRepository $ratingArticleRepository
     */
    public function __construct(
        RatingArticleService $ratingArticleService,
        RatingArticleRepository $ratingArticleRepository
    )
    {
        $this->ratingArticleRepository = $ratingArticleRepository;
        $this->ratingArticleService = $ratingArticleService;
    }

    /**
     * @param RatingArticleRequest $request
     * @return JsonResponse
     */
    public function store(RatingArticleRequest $request)
    {
        try {
            $this->ratingArticleService->store($request->all(), $request->article_id);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
