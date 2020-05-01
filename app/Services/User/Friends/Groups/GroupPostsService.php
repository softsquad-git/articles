<?php

namespace App\Services\User\Friends\Groups;

use App\Helpers\GroupsStatus;
use App\Models\Friends\Groups\FriendGroupsPosts;
use App\Repositories\User\Friends\Groups\GroupPostsRepository;
use App\Repositories\User\Friends\Groups\GroupRepository;
use Illuminate\Support\Facades\Auth;

class GroupPostsService
{

    const RESOURCE_TYPE = 'POST_GROUP';

    /**
     * @var GroupPostsRepository
     */
    private $groupPostsRepository;

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupPostsRepository $groupPostsRepository, GroupRepository $groupRepository)
    {
        $this->groupPostsRepository = $groupPostsRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * @param array $data
     * @return FriendGroupsPosts
     * @throws \Exception
     */
    public function store(array $data): FriendGroupsPosts
    {
        $group_id = $data['group_id'];
        $group = $this->groupRepository->findGroup($group_id);
        if (empty($group))
            throw new \Exception(sprintf('Group not found'));

        if ($group->is_accept_post === 1 && $group->user_id != Auth::id())
            $data['status'] = GroupsStatus::GROUP_POST_WAITING_ACCEPT;
        elseif ($group->user_id == Auth::id())
            $data['status'] = GroupsStatus::GROUP_POST_AUTHOR;
        $data['user_id'] = Auth::id();

        return FriendGroupsPosts::create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return FriendGroupsPosts
     * @throws \Exception
     */
    public function update(array $data, int $id): FriendGroupsPosts
    {
        $item = $this->groupPostsRepository->findPostGroup($id);
        if (empty($item))
            throw new \Exception(sprintf('Post not found'));
        $item->update($data);

        return $item;
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws \Exception
     */
    public function remove(int $id): ?bool
    {
        $item = $this->groupPostsRepository->findPostGroup($id);
        if (empty($item))
            throw new \Exception(sprintf('Post not found'));

        return $item->delete();
    }
}
