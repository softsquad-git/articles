<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\CommentRequest;
use App\Http\Resources\Comments\CommentResource;
use App\Repositories\Comments\CommentRepository;
use App\Services\Comments\CommentService;
use Illuminate\Http\Request;
use \Exception;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use \Illuminate\Http\JsonResponse;

class CommentController extends Controller
{

    /**
     * @var CommentRepository
     */
    private $commentsRepository;

    /**
     * @var CommentService
     */
    private $commentsService;

    /**
     * @param CommentRepository $commentRepository
     * @param CommentService $commentService
     */
    public function __construct(CommentRepository $commentRepository, CommentService $commentService)
    {
        $this->commentsRepository = $commentRepository;
        $this->commentsService = $commentService;
    }

    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        try {
            $params = [
                'resource_id' => $request->input('resource_id'),
                'resource_type' => $request->input('resource_type')
            ];
            return CommentResource::collection($this->commentsRepository->getComments($params));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function store(CommentRequest $request)
    {
        try {
            $this->commentsService->store($request->all());
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param CommentRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(CommentRequest $request, $id)
    {
        try {
            $this->commentsService->update($request->all(), $id);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function remove($id)
    {
        try {
            $this->commentsService->remove($id);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
