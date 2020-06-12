<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\ReplyCommentRequest;
use App\Http\Resources\Comments\AnswersCommentResource;
use App\Repositories\Comments\ReplyCommentRepository;
use App\Services\Comments\ReplyCommentService;
use \Illuminate\Http\JsonResponse;
use \Exception;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReplyCommentsController extends Controller
{
    /**
     * @var ReplyCommentRepository
     */
    private $replyCommentRepository;

    /**
     * @var ReplyCommentService
     */
    private $replyCommentService;

    /**
     * @param ReplyCommentRepository $replyCommentRepository
     * @param ReplyCommentService $replyCommentService
     */
    public function __construct(
        ReplyCommentRepository $replyCommentRepository,
        ReplyCommentService $replyCommentService
    )
    {
        $this->replyCommentRepository = $replyCommentRepository;
        $this->replyCommentService = $replyCommentService;
    }

    /**
     * @param int $id
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function items(int $id)
    {
        try {
            return AnswersCommentResource::collection($this->replyCommentRepository->getAnswersComment($id));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param ReplyCommentRequest $request
     * @return JsonResponse
     */
    public function store(ReplyCommentRequest $request)
    {
        try {
            $this->replyCommentService->store($request->all());
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param ReplyCommentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ReplyCommentRequest $request, int $id)
    {
        try {
            $this->replyCommentService->update($request->all(), $id);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function remove(int $id)
    {
        try {
            $this->replyCommentService->remove($id);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
