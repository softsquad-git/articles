<?php

namespace App\Http\Controllers\Front\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\Articles\ArticleResource;
use App\Http\Resources\ArticlesListResource;
use App\Repositories\Front\Articles\ArticleRepository;
use App\Services\Front\Articles\ArticleService;
use Illuminate\Http\Request;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use \Illuminate\Http\JsonResponse;

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
     * ArticleController constructor.
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
     * @return AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        $search = [
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'location' => $request->input('location'),
            'ordering' => $request->input('ordering')
        ];
        return ArticlesListResource::collection($this->articleRepository->getArticles($search));
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
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
