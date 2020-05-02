<?php

namespace App\Http\Controllers\User\Friends\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Friends\FriendGroupsRequest;
use App\Http\Resources\User\Friends\Groups\GroupResource;
use App\Repositories\User\Friends\Groups\GroupRepository;
use App\Services\User\Friends\Groups\GroupService;
use Illuminate\Http\Request;

class FriendGroupController extends Controller
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var GroupService
     */
    private $groupService;

    public function __construct(GroupRepository $groupRepository, GroupService $groupService)
    {
        $this->groupRepository = $groupRepository;
        $this->groupService = $groupService;
    }

    public function items(Request $request)
    {
        $params = [
            'name' => $request->input('name'),
            'ordering' => $request->input('ordering')
        ];
        return GroupResource::collection($this->groupRepository->items($params));
    }

    public function item($id)
    {
        try {
            $item = $this->groupRepository->findGroup($id);
            if (empty($item))
                throw new \Exception(sprintf('Group not found'));
            return new GroupResource($item);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function store(FriendGroupsRequest $request)
    {
        try {
            $item = $this->groupService->store($request->all());

            return response()->json([
                'success' => 1,
                'item' => $item
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function update(FriendGroupsRequest $request, int $id)
    {
        try {
            $item = $this->groupService->update($request->all(), $id);

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
            $this->groupService->remove($id);

            return response()->json([
                'success' => 1
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

}
