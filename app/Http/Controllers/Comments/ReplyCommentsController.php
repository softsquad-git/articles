<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\ReplyCommentRequest;
use App\Http\Resources\Comments\AnswersCommentResource;
use App\Repositories\Comments\CommentRepository;
use App\Repositories\Comments\ReplyCommentRepository;
use App\Services\Comments\ReplyCommentService;

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
     * ReplyCommentsController constructor.
     * @param ReplyCommentRepository $replyCommentRepository
     * @param ReplyCommentService $replyCommentService
     * @param CommentRepository $commentRepository
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function items(int $id)
    {
        try {
            return AnswersCommentResource::collection($this->replyCommentRepository->getAnswersComment($id));
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param ReplyCommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ReplyCommentRequest $request)
    {
        try {
            $this->replyCommentService->store($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e){
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param ReplyCommentRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ReplyCommentRequest $request, int $id)
    {
        try {
            $this->replyCommentService->update($request->all(), $id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e){
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        try {
            $this->replyCommentService->remove($id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
