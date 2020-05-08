<?php


namespace App\Repositories\User\Groups;


use App\Helpers\GroupStatus;
use App\Models\Users\Groups\Group;
use App\Models\Users\Groups\PostsGroupImages;
use App\Services\User\Groups\GroupsPostsService;
use Illuminate\Support\Facades\Auth;

class GroupsRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function findGroup(int $id)
    {
        return Group::find($id);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getGroups(array $params)
    {
        return Group::whereHas('users', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->where('status', GroupStatus::STATUS_ACTIVE)
            ->orderBy('id', $params['ordering'] ?? 'DESC')
            ->paginate(20);
    }

    /**
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function getAllImages(int $id)
    {
        $group = $this->findGroup($id);
        if (empty($group))
            throw new \Exception(sprintf('Group %d not found', $id));
        $imagesAll = PostsGroupImages::whereHas('post', function ($q) use ($id) {
            $q->where('group_id', $id);
        })->get();
        $images = [];
        foreach ($imagesAll as $img) {
            $images[] = asset(GroupsPostsService::GROUP_POST_IMAGES_PATH.$img->src);
        }
        return $images;
    }
}
