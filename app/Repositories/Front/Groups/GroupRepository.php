<?php

namespace App\Repositories\Front\Groups;

use App\Models\Users\Groups\Group;
use App\Models\Users\Groups\UsersGroup;
use Illuminate\Support\Facades\Auth;

class GroupRepository
{

    public function getGroups(array $params)
    {
        $name = $params['name'];
        $type = $params['type'];
        $items = Group::orderBy('id', $params['ordering'] ?? 'DESC');
        if (!empty($name))
            $items->where('name', 'like', '%' . $name . '%');
        if (!empty($type))
            $items->where('type', $type);
        return $items->paginate(10);
    }

    /**
     * @param int $groupId
     * @return mixed
     * @throws \Exception
     */
    public function findGroup(int $groupId)
    {
        $item = Group::find($groupId);
        if (empty($item))
            throw new \Exception('Group not exist');
        return $item;
    }


    public static function checkBelongGroup(int $groupId)
    {
        try {
            $group = UsersGroup::where([
                'group_id' => $groupId,
                'user_id' => Auth::id()
            ])->first();
            if (!empty($group)) {
                if ($group->status === 1) {
                    return 1;
                } else {
                    return 2;
                }
            } else
                return 0;
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public static function checkAdminGroup(int $groupId)
    {
        try {
            $group = UsersGroup::where([
                'user_id' => Auth::id(),
                'group_id' => $groupId
            ])->first();
            if (empty($group))
                throw new \Exception('Group not found');
            return $group->is_admin;
        } catch (\Exception $e) {
            return  response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

}
