<?php

namespace App\Repositories\User\Groups;

use App\Helpers\GroupStatus;
use App\Models\Users\Groups\PostsGroup;
use App\Models\Users\Groups\PostsGroupImages;
use App\Models\Users\Groups\UsersGroup;
use App\Repositories\Front\Groups\GroupRepository;
use Illuminate\Support\Facades\Auth;

class GroupsPostsRepository
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

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

    /**
     * @param int $groupId
     * @param int $status
     * @return mixed
     * @throws \Exception
     */
    public function getPostsForAdmin(int $groupId, int $status)
    {
        $group = $this->groupRepository->findGroup($groupId);
        if (empty($group))
            throw new \Exception('Group not found');
        $user = UsersGroup::where([
            'user_id' => Auth::id(),
            'group_id' => $groupId
        ])->first();
        if ($user->is_admin != 1)
            throw new \Exception('Forbidden');
        return PostsGroup::where('status', $status)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    }
}
