<?php

namespace App\Http\Controllers\User\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Groups\UsersGroupRequest;
use App\Http\Resources\Users\Groups\UsersGroupResource;
use App\Repositories\User\Groups\GroupsUsersRepository;
use App\Services\User\Groups\GroupsUsersService;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsersGroupController extends Controller
{
    /**
     * @var GroupsUsersRepository
     */
    private $groupsUsersRepository;

    /**
     * @var GroupsUsersService
     */
    private $groupsUsersService;

    /**
     * UsersGroupController constructor.
     * @param GroupsUsersService $groupsUsersService
     * @param GroupsUsersRepository $groupsUsersRepository
     */
    public function __construct(GroupsUsersService $groupsUsersService, GroupsUsersRepository $groupsUsersRepository)
    {
        $this->groupsUsersRepository = $groupsUsersRepository;
        $this->groupsUsersService = $groupsUsersService;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getUsersGroup(Request $request, int $id)
    {
        try {
            $params = [
                'ordering' => $request->input('ordering'),
                'group_id' => $id,
                'is_author' => $request->input('is_author'),
                'is_admin' => $request->input('is_admin'),
                'status' => $request->input('status')
            ];
            return UsersGroupResource::collection($this->groupsUsersRepository->getUsersGroup($params));
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param UsersGroupRequest $request
     * @return JsonResponse
     */
    public function store(UsersGroupRequest $request)
    {
        try {
            $this->groupsUsersService->store($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param UsersGroupRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UsersGroupRequest $request, int $id)
    {
        try {
            $this->groupsUsersService->update($request->only(['status', 'is_admin']), $id);
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
            $this->groupsUsersService->remove($id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function joinUserGroup(int $groupId)
    {
        try {
            $this->groupsUsersService->joinUserGroup($groupId);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
