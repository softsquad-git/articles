<?php

namespace App\Services\User\Friends\Groups;

use App\Models\Friends\Groups\FriendGroups;
use App\Repositories\User\Friends\Groups\GroupRepository;
use Illuminate\Support\Facades\Auth;

class GroupService
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
     * @param array $data
     * @return FriendGroups
     */
    public function store(array $data): FriendGroups
    {
        $data['user_id'] = Auth::id();

        return FriendGroups::create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return FriendGroups
     * @throws \Exception
     */
    public function update(array $data, int $id): FriendGroups
    {
        $item = $this->groupRepository->findGroup($id);
        if (empty($item))
            throw new \Exception(sprintf('Group not found'));
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
        $item = $this->groupRepository->findGroup($id);
        if (empty($item))
            throw new \Exception(sprintf('Group not found'));

        return $item->delete();
    }
}
