<?php

namespace App\Http\Controllers\Front\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\Articles\ArticleResource;
use App\Repositories\Front\Articles\ArticleRepository;
use App\Services\Front\Articles\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @var $repository
     * @var $service
     */
    private $repository;
    private $service;

    public function __construct(ArticleRepository $repository, ArticleService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function items(Request $request)
    {
        $search = [
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'location' => $request->input('location')
        ];
        $items = $this->repository->items($search);

        return ArticleResource::collection($items);
    }

    public function item($id)
    {
        $item = $this->repository->find($id);
        if (empty($item)) {
            return response()->json([
                'success' => 0
            ]);
        }

        $this->service->view($item);
        return new ArticleResource($item);
    }
}
