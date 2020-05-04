<?php

namespace App\Http\Controllers\Follows;

use App\Http\Controllers\Controller;
use App\Http\Requests\Follows\FollowRequest;
use App\Http\Resources\Follows\FollowResource;
use App\Repositories\Follows\FollowRepository;
use App\Services\Follows\FollowService;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * @var FollowService
     */
    private $followService;

    /**
     * @var FollowRepository
     */
    private $followRepository;

    /**
     * FollowController constructor.
     * @param FollowService $followService
     * @param FollowRepository $followRepository
     */
    public function __construct(FollowService $followService, FollowRepository $followRepository)
    {
        $this->followRepository = $followRepository;
        $this->followService = $followService;
    }

    /**
     * @param FollowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(FollowRequest $request)
    {
        $params = [
            'resource_id' => $request->resource_id,
            'resource_type' => $request->resource_type
        ];
        $data = $request->all();
        try {
            $this->followService->follow($data, $params);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFollow(Request $request)
    {
        $resource_id = $request->input('resource_id');
        $resource_type = $request->input('resource_type');
        if (empty($resource_id) || empty($resource_type)){
            return response()->json(['success' => 0]);
        }
        $follow = $this->followRepository->follow($resource_id, $resource_type);
        return response()->json(['follow' => $follow ? true : false]);
    }

    public function getFollows(string $resource_type)
    {
        try {
            $items = $this->followRepository->getFollows($resource_type);
            return FollowResource::collection($items);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function getWatchingYou(){
        try {
            $items = $this->followRepository->getWatchingYou();
            return FollowResource::collection($items);
        } catch (\Exception $e){
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function unFollow(int $id) {
        try {
            $this->followService->remove($id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
