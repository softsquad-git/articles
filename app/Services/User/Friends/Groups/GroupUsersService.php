<?php

namespace App\Services\User\Friends\Groups;

use App\Helpers\GroupsStatus;
use App\Models\Friends\Groups\FriendGroupsUser;
use App\Repositories\User\Friends\Groups\GroupRepository;
use App\Repositories\User\Friends\Groups\GroupUsersRepository;
use Illuminate\Support\Facades\Auth;

class GroupUsersService
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var GroupUsersRepository
     */
    private $groupUserRepository;

    public function __construct(GroupUsersRepository $groupUserRepository, GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->groupUserRepository = $groupUserRepository;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        $data['user_id'] = Auth::id();
        $group = $this->groupRepository->findGroup($data['group_id']);
        if (empty($group))
            throw new \Exception(sprintf('Group not found'));
        if ($group->type === GroupsStatus::PUBLIC)
            $data['status'] = GroupsStatus::GROUP_USER_ACTIVE;
        else
            $data['status'] = GroupsStatus::GROUP_USER_WAITING_ACCEPT;

        return FriendGroupsUser::create($data);
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws \Exception
     */
    public function remove(int $id): ?bool
    {
        $item = $this->groupUserRepository->findUserGroup($id);
        if (empty($item))
            throw new \Exception(sprintf('Group user not found'));

        return $item->delete();
    }

    /**
     * @param int $group_id
     * @param int $status
     * @return mixed
     * @throws \Exception
     */
    public function updateStatus(int $group_id, int $status)
    {
        $group = $this->groupUserRepository->findUserGroup($group_id);
        if (empty($group))
            throw new \Exception(sprintf('Group not found'));
        if (!is_int($status))
            throw new \Exception(sprintf('Refresh page'));

        $group->update([
            'status' => $status
        ]);

        return $group;
    }

}
