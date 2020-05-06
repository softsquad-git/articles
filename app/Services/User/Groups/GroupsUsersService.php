<?php

namespace App\Services\User\Groups;

use App\Models\Users\Groups\UsersGroup;
use App\Repositories\User\Groups\GroupsRepository;
use App\Repositories\User\Groups\GroupsUsersRepository;
use App\Repositories\User\UserRepository;

class GroupsUsersService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var GroupsUsersRepository
     */
    private $groupsUsersRepository;

    /**
     * @var GroupsRepository
     */
    private $groupsRepository;

    /**
     * GroupsUsersService constructor.
     * @param UserRepository $userRepository
     * @param GroupsRepository $groupsRepository
     * @param GroupsUsersRepository $groupsUsersRepository
     */
    public function __construct(
        UserRepository $userRepository,
        GroupsRepository $groupsRepository,
        GroupsUsersRepository $groupsUsersRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->groupsRepository = $groupsRepository;
        $this->groupsUsersRepository = $groupsUsersRepository;
    }

    /**
     * @param array $data
     * @return UsersGroup
     * @throws \Exception
     */
    public function store(array $data): UsersGroup
    {
        $data['is_author'] = 0;
        $user = $this->userRepository->findUser($data['user_id']);
        if (empty($user))
            throw new \Exception(sprintf('User %d not found', $data['user_id']));
        $group = $this->groupsRepository->findGroup($data['group_id']);
        if (empty($group))
            throw new \Exception(sprintf('Group %d not found', $data['group_id']));
        $userGroup = UsersGroup::create($data);
        if (empty($userGroup))
            throw new \Exception('Something wen wrong');
        return $userGroup;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function update(array $data, int $id)
    {
        $userGroup = $this->groupsUsersRepository->findUserGroup($id);
        if (empty($userGroup))
            throw new \Exception(sprintf('User %d not found in this group', $id));
        $userGroup->update($data);
        return $userGroup;
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws \Exception
     */
    public function remove(int $id): ?bool
    {
        $userGroup = $this->groupsUsersRepository->findUserGroup($id);
        if (empty($userGroup))
            throw new \Exception(sprintf('User %d not found in this group', $id));
        return $userGroup->delete();
    }
}
