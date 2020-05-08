<?php

namespace App\Repositories\User\Groups;

use App\Helpers\GroupStatus;
use App\Models\Users\Groups\UsersGroup;

class GroupsUsersRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function findUserGroup(int $id)
    {
        return UsersGroup::find($id);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getUsersGroup(array $params)
    {
        $items = UsersGroup::orderBy('id', $params['ordering'] ?? 'DESC')
            ->where('group_id', $params['group_id'])
            ->where('status', GroupStatus::USER_STATUS_ACTIVE);
        if (!empty($params['is_author']))
            $items->where('is_author', 1);
        if (!empty($params['is_admin']))
            $items->where('is_admin', 1);

        return $items
            ->paginate(20);
    }
}
