<?php

namespace App\Repositories\Front\Groups;

use App\Models\Users\Groups\Group;

class GroupRepository
{

    public function getGroups(array $params)
    {
        $name = $params['name'];
        $type = $params['type'];
        $items = Group::orderBy('id', $params['ordering'] ?? 'DESC');
        if (!empty($name))
            $items->where('name', 'like', '%'. $name . '%');
        if (!empty($type))
            $items->where('type', $type);
        return $items->paginate(10);
    }

}
