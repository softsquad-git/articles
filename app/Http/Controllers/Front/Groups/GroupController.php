<?php

namespace App\Http\Controllers\Front\Groups;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\Groups\GroupsResource;
use App\Repositories\Front\Groups\GroupRepository;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function getGroups(Request $request)
    {
        try {
            $params = [
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'ordering' => $request->input('ordering')
            ];
            return GroupsResource::collection($this->groupRepository->getGroups($params));
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
