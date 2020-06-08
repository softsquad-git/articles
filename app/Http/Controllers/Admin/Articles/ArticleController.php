<?php

namespace App\Http\Controllers\Admin\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\Articles\ArticleResource;
use App\Repositories\ADMIN\Articles\ArticleRepository;
use App\Services\ADMIN\articles\ArticleService;
use Illuminate\Http\Request;
use \Exception;

class ArticleController extends Controller
{
    /**
     * @var ArticleRepository
     */
    private $_A_ArticleRepository;

    /**
     * @var ArticleService
     */
    private $_A_ArticleService;

    public function __construct(ArticleService $articleService, ArticleRepository $articleRepository)
    {
        $this->_A_ArticleRepository = $articleRepository;
        $this->_A_ArticleService = $articleService;
    }

    public function getArticles(Request $request)
    {
        $params = [
            'title' => $request->input('title'),
            'status' => $request->input('status'),
            'category' => $request->input('category'),
            'location' => $request->input('location')
        ];
        try {
            return ArticleResource::collection($this->_A_ArticleRepository->getArticles($params));
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function findArticle(int $articleId)
    {
        try {
            return new ArticleResource($this->_A_ArticleRepository->findArticle($articleId));
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function changeStatus(string $status, int $articleId)
    {
        try {
            $this->_A_ArticleService->changeStatus($status, $articleId);
            return response()->json([
                'success' => 1
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
