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
     * @var CommentRepository
     */
    private $commentsRepository;

    /**
     * @var CommentService
     */
    private $commentsService;

    /**
     * CommentController constructor.
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        try {
            $params = [
                'resource_id' => $request->input('resource_id'),
                'resource_type' => $request->input('resource_type')
            ];
            return CommentResource::collection($this->commentsRepository->getComments($params));
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param CommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentRequest $request)
    {
        try {
            $this->commentsService->store($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param CommentRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CommentRequest $request, $id)
    {
        try {
            $this->commentsService->update($request->all(), $id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($id)
    {
        try {
            $this->commentsService->remove($id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
