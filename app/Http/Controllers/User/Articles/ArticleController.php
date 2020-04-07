<?php

namespace App\Http\Controllers\User\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Articles\ArticleRequest;
use App\Http\Resources\Articles\ArticleResource;
use App\Repositories\User\Articles\ArticleRepository;
use App\Services\User\Articles\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @var $repository
     * @var $service
     */
    private $service;
    private $repository;

    public function __construct(ArticleRepository $repository, ArticleService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function items(Request $request)
    {
        $search = [
            'status' => $request->get('status')
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

        return new ArticleResource($item);
    }

    public function store(ArticleRequest $request)
    {
        $item = $this->service->store($request->all());

        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }

    public function update(ArticleRequest $request, $id)
    {
        $item = $this->repository->find($id);
        if (empty($item)) {
            return response()->json([
                'success' => 0
            ]);
        }

        $item = $this->service->update($request->all(), $item);

        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }

    public function remove($id)
    {
        $item = $this->repository->find($id);
        if (empty($item)) {
            return response()->json([
                'success' => 0
            ]);
        }

        $this->service->remove($item);

        return response()->json([
            'success' => 1
        ]);
    }
}
