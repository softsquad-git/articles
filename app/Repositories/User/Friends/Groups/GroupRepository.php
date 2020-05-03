<?php

namespace App\Repositories\User\Friends\Groups;

use App\Models\Friends\Groups\FriendGroups;
use Illuminate\Support\Facades\Auth;

class GroupRepository
{

    /**
     * @param array $params
     * @return FriendGroups
     */
    public function items(array $params)
    {
        $items = FriendGroups::where('user_id', Auth::id())
            ->orderBy('id', $params['ordering'] ?? 'DESC');
        $name = $params['name'];
        if (empty($name))
            $items->where('name', 'like', '%' . $name . '%');

        return $items
            ->paginate(10);
    }

    /**
     * @param int $id
     * @return FriendGroups
     */
    public function findGroup(int $id)
    {
        return FriendGroups::find($id);
    }

    public function getBelongGroups()
    {

    }

}
