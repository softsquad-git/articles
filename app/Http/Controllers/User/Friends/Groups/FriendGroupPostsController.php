<?php

namespace App\Http\Controllers\User\Friends\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Friends\FriendGroupsPostsRequest;
use App\Http\Resources\User\Friends\Groups\GroupPostsResource;
use App\Repositories\User\Friends\Groups\GroupPostsRepository;
use App\Services\User\Friends\Groups\GroupPostsService;
use Illuminate\Http\Request;

class FriendGroupPostsController extends Controller
{
    /**
     * @var GroupPostsRepository
     */
    private $groupPostsRepository;

    /**
     * @var GroupPostsService
     */
    private $groupPostsService;

    /**
     * FriendGroupPostsController constructor.
     * @param GroupPostsService $groupPostsService
     * @param GroupPostsRepository $groupPostsRepository
     */
    public function __construct(GroupPostsService $groupPostsService, GroupPostsRepository $groupPostsRepository)
    {
        $this->groupPostsService = $groupPostsService;
        $this->groupPostsRepository = $groupPostsRepository;
    }

    /**
     * @param Request $request
     * @param int $group_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function items(Request $request, int $group_id)
    {
        $params = [
            'ordering' => $request->input('ordering')
        ];
        try {
            return GroupPostsResource::collection($this->groupPostsRepository->items($params, $group_id));
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param FriendGroupsPostsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FriendGroupsPostsRequest $request)
    {
        try {
            $this->groupPostsService->store($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param FriendGroupsPostsRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FriendGroupsPostsRequest $request, int $id)
    {
        try {
            $this->groupPostsService->update($request->all(), $id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 1, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        try {
            $this->groupPostsService->remove($id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 1, 'msg' => $e->getMessage()]);
        }
    }
}
