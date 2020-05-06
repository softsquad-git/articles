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
        return UsersGroup::orderBy('id', $params['ordering'] ?? 'DESC')
            ->where('group_id', $params['group_id'])
            ->where('status', GroupStatus::USER_STATUS_ACTIVE)
            ->paginate(20);
    }
}
