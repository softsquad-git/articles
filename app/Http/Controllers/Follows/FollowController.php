<?php

namespace App\Http\Controllers\Follows;

use App\Http\Controllers\Controller;
use App\Http\Requests\Follows\FollowRequest;
use App\Repositories\Follows\FollowRepository;
use App\Services\Follows\FollowService;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * @var $service
     * @var $repository
     */
    private $service;
    private $repository;

    public function __construct(FollowService $service, FollowRepository $repository)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function follow(FollowRequest $request)
    {
        $resource_id = $request->resource_id;
        $resource_type = $request->resource_type;
        $data = $request->all();
        $follow = $this->repository->follow($resource_id, $resource_type);
        $item = $this->service->follow($data, $follow);

        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }

    public function getFollow(Request $request)
    {
        $resource_id = $request->input('resource_id');
        $resource_type = $request->input('resource_type');
        if (empty($resource_id) || empty($resource_type)){
            return response()->json([
                'success' => 0
            ]);
        }
        $follow = $this->repository->follow($resource_id, $resource_type);
        return response()->json([
            'follow' => $follow ? true : false
        ]);
    }
}
