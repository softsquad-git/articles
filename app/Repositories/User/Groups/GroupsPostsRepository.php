<?php

namespace App\Repositories\User\Groups;

use App\Helpers\GroupStatus;
use App\Models\Users\Groups\PostsGroup;

class GroupsPostsRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function findPostGroup(int $id)
    {
        return PostsGroup::find($id);
    }

    public function getActivityPosts(array $params)
    {
        return PostsGroup::orderBy('id', $params['ordering'] ?? 'DESC')
            ->where('group_id', $params['group_id'])
            ->where('status', GroupStatus::POST_STATUS_ACTIVE)
            ->paginate(20);
    }
}
