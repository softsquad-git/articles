<?php

namespace App\Services\User\Groups;

use App\Helpers\GroupStatus;
use App\Models\Users\Groups\PostsGroup;
use App\Repositories\User\Groups\GroupsPostsRepository;
use App\Repositories\User\Groups\GroupsRepository;
use Illuminate\Support\Facades\Auth;

class GroupsPostsService
{

    /**
     * @var GroupsRepository
     */
    private $groupsRepository;

    /**
     * @var GroupsPostsRepository
     */
    private $groupsPostsRepository;

    /**
     * GroupsPostsService constructor.
     * @param GroupsRepository $groupsRepository
     * @param GroupsPostsRepository $groupsPostsRepository
     */
    public function __construct(GroupsRepository $groupsRepository, GroupsPostsRepository $groupsPostsRepository)
    {
        $this->groupsRepository = $groupsRepository;
        $this->groupsPostsRepository = $groupsPostsRepository;
    }

    /**
     * @param array $data
     * @return PostsGroup
     * @throws \Exception
     */
    public function store(array $data): PostsGroup
    {
        $data['user_id'] = Auth::id();
        $group = $this->groupsRepository->findGroup($data['group_id']);
        if (empty($group))
            throw new \Exception(sprintf('Group %d not found', $data['group_id']));
        if ($group->is_accept_post === 1)
            $data['status'] = GroupStatus::POST_STATUS_WAITING;
        $post = PostsGroup::create($data);
        if (empty($post))
            throw new \Exception('Something went wrong');
        return $post;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function update(array $data, int $id)
    {
        $item = $this->groupsPostsRepository->findGroupPost($id);
        if (empty($item))
            throw new \Exception(sprintf('Post %d not found in this group', $id));
        $item->update($data);
        return $item;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function remove(int $id)
    {
        $item = $this->groupsPostsRepository->findGroupPost($id);
        if (empty($item))
            throw new \Exception(sprintf('Post %d not found in this group', $id));
        return $item->delete();
    }

}
