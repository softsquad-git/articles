<?php

namespace App\Http\Controllers\Front\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Articles\RatingArticleRequest;
use App\Repositories\Front\Articles\RatingArticleRepository;
use App\Services\Front\Articles\RatingArticleService;
use Illuminate\Http\Request;

class RatingArticleController extends Controller
{

    private $ratingArticleService;
    private $ratingArticleRepository;

    public function __construct(
        RatingArticleService $ratingArticleService,
        RatingArticleRepository $ratingArticleRepository
    )
    {
        $this->ratingArticleRepository = $ratingArticleRepository;
        $this->ratingArticleService = $ratingArticleService;
    }

    public function store(RatingArticleRequest $request)
    {
        try {
            $this->ratingArticleService->store($request->all(), $request->article_id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
