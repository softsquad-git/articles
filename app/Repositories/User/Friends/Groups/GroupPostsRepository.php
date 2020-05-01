<?php

namespace App\Repositories\User\Friends\Groups;

use App\Models\Friends\Groups\FriendGroupsPosts;

class GroupPostsRepository
{

    /**
     * @param array $params
     * @param int $group_id
     * @return mixed
     */
    public function items(array $params, int $group_id)
    {
        return FriendGroupsPosts::where('group_id', $group_id)
            ->orderBy('id', $params['ordering'] ?? 'DESC')
            ->paginate(20);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findPostGroup(int $id)
    {
        return FriendGroupsPosts::find($id);
    }

}
