<?php

namespace App\Http\Controllers\User\Friends\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Friends\FriendGroupsUserRequest;
use App\Http\Resources\User\Friends\Groups\GroupUsersResource;
use App\Repositories\User\Friends\Groups\GroupUsersRepository;
use App\Services\User\Friends\Groups\GroupUsersService;
use Illuminate\Http\Request;

class FriendGroupUserController extends Controller
{
    /**
     * @var GroupUsersRepository
     */
    private $groupUserRepository;

    /**
     * @var GroupUsersService
     */
    private $groupUserService;

    public function __construct(GroupUsersService $groupUserService, GroupUsersRepository $groupUserRepository)
    {
        $this->groupUserRepository = $groupUserRepository;
        $this->groupUserService = $groupUserService;
    }

    public function items(Request $request, $group_id)
    {
        $params = [
            'status' => $request->input('status'),
            'group_id' => $group_id,
            'ordering' => $request->input('ordering')
        ];

        return GroupUsersResource::collection($this->groupUserRepository->items($params));
    }

    public function store(FriendGroupsUserRequest $request)
    {
        try {
            $item = $this->groupUserService->store($request->all());
            return response()->json([
                'success' => 1,
                'item' => $item
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function remove(int $id)
    {
        try {
            $this->groupUserService->remove($id);
            return response()->json([
                'success' => 1
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function updateStatus(int $group_id, int $status)
    {
        try {
            $item = $this->groupUserService->updateStatus($group_id, $status);

            return response()->json([
                'success' => 1,
                'item' => $item
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function getGroupsBelongTo(Request $request)
    {
        $params = [
            'status' => $request->input('status'),
            'ordering' => $request->input('ordering')
        ];

        return GroupUsersResource::collection($this->groupUserRepository->getGroupsBelongTo($params));
    }
}
