<?php


namespace App\Services\User\Groups;


use App\Helpers\GroupStatus;
use App\Models\Users\Groups\Group;
use App\Models\Users\Groups\UsersGroup;
use App\Repositories\User\Groups\GroupsRepository;
use Illuminate\Support\Facades\Auth;

class GroupsService
{

    /**
     * @var GroupsRepository
     */
    private $groupsRepository;

    public function __construct(GroupsRepository $groupsRepository)
    {
        $this->groupsRepository = $groupsRepository;
    }

    /**
     * @param array $data
     * @return Group
     * @throws \Exception
     */
    public function store(array $data): Group
    {
        $group = Group::create($data);
        if (empty($group))
            throw new \Exception('Something went wrong');
        $userData = [
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'is_admin' => 1,
            'status' => GroupStatus::USER_STATUS_ACTIVE,
            'is_author' => 1
        ];
        $user = UsersGroup::create($userData);
        if (empty($user)) {
            $this->remove($group->id);
            throw new \Exception('The default user cannot be assigned. The group has not been created. Please try again in a moment');
        }

        return $group;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Group
     * @throws \Exception
     */
    public function update(array $data, int $id): Group
    {
        $item = $this->groupsRepository->findGroup($id);
        if (empty($item))
            throw new \Exception(sprintf('Group %d not found', $id));
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
        $item = $this->groupsRepository->findGroup($id);
        if (empty($item))
            throw new \Exception(sprintf('Group %d not found', $id));
        return $item->delete();
    }

}
