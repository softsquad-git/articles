<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\CommentRequest;
use App\Http\Resources\Comments\CommentResource;
use App\Repositories\Comments\CommentRepository;
use App\Services\Comments\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * @var $repository
     * @var $service
     */
    private $repository;
    private $service;

    public function __construct(CommentRepository $repository, CommentService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function items(Request $request)
    {
        $resource_id = $request->input('resource_id');
        $resource_type = $request->input('resource_type');
        if (empty($resource_id) || empty($resource_type)){
            return response()->json([
                'success' => 0
            ]);
        }

        $params = [
            'resource_id' => $resource_id,
            'resource_type' => $resource_type
        ];
        $items = $this->repository->items($params);

        return CommentResource::collection($items);
    }

    public function store(CommentRequest $request)
    {
        $item = $this->service->store($request->all());

        return response()->json([
            'item' => $item,
            'success' => 1
        ]);
    }

    public function update(CommentRequest $request, $id)
    {
        $item = $this->repository->find($id);
        if (empty($item)) {
            return response()->json([
                'success' => 0
            ]);
        }
        $item = $this->service->update($request->all(), $item);

        return response()->json([
            'item' => $item,
            'success' => 1
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
