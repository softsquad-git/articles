<?php

namespace App\Http\Controllers\Front\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\Articles\ArticleResource;
use App\Http\Resources\ArticlesListResource;
use App\Http\Resources\User\Experts\OpinionsExpertsResource;
use App\Repositories\Front\Articles\ArticleRepository;
use App\Services\Front\Articles\ArticleService;
use Illuminate\Http\Request;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use \Illuminate\Http\JsonResponse;
use \Exception;

class ArticleController extends Controller
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * @param ArticleRepository $articleRepository
     * @param ArticleService $articleService
     */
    public function __construct(ArticleRepository $articleRepository, ArticleService $articleService)
    {
        $this->articleRepository = $articleRepository;
        $this->articleService = $articleService;
    }

    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        $search = [
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'location' => $request->input('location'),
            'ordering' => $request->input('ordering')
        ];
        try {
            return ArticlesListResource::collection($this->articleRepository->getArticles($search));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $id
     * @return ArticleResource|JsonResponse
     */
    public function item(int $id)
    {
        try {
            $this->articleService->view($id);
            return new ArticleResource($this->articleRepository->findArticle($id));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $articleId
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function opinionsExperts(int $articleId)
    {
        try {
            return OpinionsExpertsResource::collection($this->articleRepository->opinionsExperts($articleId));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
