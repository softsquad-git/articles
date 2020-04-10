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
     * @var $repository
     * @var $service
     * @var $commentRepository
     */
    private $repository;
    private $service;
    private $commentRepository;

    public function __construct(ReplyCommentRepository $repository, ReplyCommentService $service, CommentRepository $commentRepository)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->commentRepository = $commentRepository;
    }

    public function items($id)
    {
        $comment = $this->commentRepository->find($id);
        if (empty($comment)) {
            return response()->json([
                'success' => 0
            ]);
        }

        $items = $this->repository->items($id);

        return AnswersCommentResource::collection($items);
    }

    public function store(ReplyCommentRequest $request)
    {
        $item = $this->service->store($request->all());

        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }

    public function update(ReplyCommentRequest $request, $id)
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
