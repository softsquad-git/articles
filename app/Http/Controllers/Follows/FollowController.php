<?php

namespace App\Http\Controllers\Follows;

use App\Http\Controllers\Controller;
use App\Http\Requests\Follows\FollowRequest;
use App\Http\Resources\Follows\FollowResource;
use App\Repositories\Follows\FollowRepository;
use App\Services\Follows\FollowService;
use Illuminate\Http\Request;
use \Exception;
use \Illuminate\Http\JsonResponse;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
     * @return JsonResponse
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
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getFollow(Request $request)
    {
        $resource_id = $request->input('resource_id');
        $resource_type = $request->input('resource_type');
        if (empty($resource_id) || empty($resource_type)) {
            return response()->json(['success' => 0]);
        }
        $follow = $this->followRepository->follow($resource_id, $resource_type);
        return response()->json(['follow' => $follow ? true : false]);
    }

    /**
     * @param string $resource_type
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getFollows(string $resource_type)
    {
        try {
            $items = $this->followRepository->getFollows($resource_type);
            return FollowResource::collection($items);
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getWatchingYou()
    {
        try {
            $items = $this->followRepository->getWatchingYou();
            return FollowResource::collection($items);
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function unFollow(int $id)
    {
        try {
            $this->followService->remove($id);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
