<?php


namespace App\Repositories\User\Groups;


use App\Helpers\GroupStatus;
use App\Models\Users\Groups\Group;
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

    public function getGroups(array $params)
    {
        return Group::whereHas('users', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->where('status', GroupStatus::STATUS_ACTIVE)
            ->orderBy('id', $params['ordering'] ?? 'DESC')
            ->paginate(20);
    }
}
