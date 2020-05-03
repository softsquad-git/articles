<?php

namespace App\Repositories\User\Friends\Groups;

use App\Models\Friends\Groups\FriendGroupsUser;
use Illuminate\Support\Facades\Auth;

class GroupUsersRepository
{

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserGroup(int $id)
    {
        return FriendGroupsUser::find($id);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function items(array $params)
    {
        $status = $params['status'];
        $group_id = $params['group_id'];
        $ordering = $params['ordering'];

        $items = FriendGroupsUser::where('group_id', $group_id)
            ->where('status', $status)
            ->orderBy('id', $ordering ?? 'DESC');

        return $items
            ->get();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getGroupsBelongTo(array $params)
    {
        $status = $params['status'];
        $ordering = $params['ordering'];

        return FriendGroupsUser::where('user_id', Auth::id())
            ->where('status', $status)
            ->orderBy('id', $ordering ?? 'DESC')
            ->paginate(10);
    }

}
