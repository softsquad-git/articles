<?php

namespace App\Http\Controllers\User\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Groups\PostsGroupRequest;
use App\Http\Resources\Users\Groups\PostsGroupResource;
use App\Repositories\User\Groups\GroupsPostsRepository;
use App\Services\User\Groups\GroupsPostsService;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostsGroupController extends Controller
{
    /**
     * @var GroupsPostsRepository
     */
    private $groupsPostsRepository;

    /**
     * @var GroupsPostsService
     */
    private $groupsPostsService;

    /**
     * PostsGroupController constructor.
     * @param GroupsPostsService $groupsPostsService
     * @param GroupsPostsRepository $groupsPostsRepository
     */
    public function __construct(GroupsPostsService $groupsPostsService, GroupsPostsRepository $groupsPostsRepository)
    {
        $this->groupsPostsRepository = $groupsPostsRepository;
        $this->groupsPostsService = $groupsPostsService;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return AnonymousResourceCollection
     */
    public function getPostsGroup(Request $request, int $id)
    {
        $params = [
            'ordering' => $request->input('ordering'),
            'group_id' => $id
        ];
        return PostsGroupResource::collection($this->groupsPostsRepository->getActivityPosts($params));
    }

    /**
     * @param PostsGroupRequest $request
     * @return JsonResponse
     */
    public function store(PostsGroupRequest $request)
    {
        try {
            $this->groupsPostsService->store($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param PostsGroupRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PostsGroupRequest $request, int $id)
    {
        try {
            $this->groupsPostsService->update($request->all(), $id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function remove(int $id)
    {
        try {
            $this->groupsPostsService->remove($id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
