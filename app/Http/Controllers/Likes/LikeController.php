<?php

namespace App\Http\Controllers\Likes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Likes\LikeRequest;
use App\Repositories\Likes\LikeRepository;
use App\Services\Likes\LikeService;
use Illuminate\Http\Request;
use \Exception;
use \Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    /**
     * @var LikeRepository
     */
    private $likeRepository;

    /**
     * @var LikeService
     */
    private $likeService;

    /**
     * @param LikeRepository $likeRepository
     * @param LikeService $likeService
     */
    public function __construct(LikeRepository $likeRepository, LikeService $likeService)
    {
        $this->likeRepository = $likeRepository;
        $this->likeService = $likeService;
    }

    /**
     * @param LikeRequest $request
     * @return JsonResponse
     */
    public function like(LikeRequest $request)
    {
        $params = [
            'resource_id' => $request->resource_id,
            'resource_type' => $request->resource_type
        ];
        try {
            $this->likeService->like($request->all(), $params);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getLike(Request $request)
    {
        $params = [
            'resource_id' => $request->input('resource_id'),
            'resource_type' => $request->input('resource_type')
        ];
        try {
            $like = $this->likeRepository->like($params);
            return response()->json(['like' => $like->like]);
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
