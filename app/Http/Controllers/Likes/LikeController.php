<?php

namespace App\Http\Controllers\Likes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Likes\LikeRequest;
use App\Repositories\Likes\LikeRepository;
use App\Services\Likes\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * @var $repository
     * @var $service
     */
    private $repository;
    private $service;

    public function __construct(LikeRepository $repository, LikeService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function like(LikeRequest $request)
    {
        $resource_id = $request->resource_id;
        $resource_type = $request->resource_type;
        $data = $request->all();
        $like = $this->repository->like($resource_id, $resource_type);
        $item = $this->service->like($data, $like);

        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }

    public function getLike(Request $request)
    {
        $resource_id = $request->input('resource_id');
        $resource_type = $request->input('resource_type');
        if (empty($resource_id) || empty($resource_type)){
            return response()->json([
                'success' => 0
            ]);
        }
        $like = $this->repository->like($resource_id, $resource_type);
        if (empty($like)){
            return response()->json([
                'msg' => null
            ]);
        }
        return response()->json([
            'like' => $like->like
        ]);
    }
}
