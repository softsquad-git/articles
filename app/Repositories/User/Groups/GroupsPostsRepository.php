<?php

namespace App\Repositories\User\Groups;

use App\Helpers\GroupStatus;
use App\Models\Users\Groups\PostsGroup;
use App\Models\Users\Groups\PostsGroupImages;

class GroupsPostsRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function findGroupPost(int $id)
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

    public function getPostImages(int $id)
    {
        return PostsGroupImages::where('post_id', $id)
            ->get();
    }

    public function findImagePost(int $id)
    {
        return PostsGroupImages::find($id);
    }
}
