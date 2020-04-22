<?php

namespace App\Repositories\Front\Friends;

use App\User;
use Illuminate\Support\Facades\DB;

class FriendRepository
{

    public function usersList(array $params)
    {
        $items = User::where('activated', 1)
            ->where('locked', 0);
        if (!empty($params['name'])){
            $items->whereHas('specificData', function ($query) use ($params){
                $query->where(DB::raw("CONCAT(`name`, ' ', `last_name`)"), 'LIKE', "%".$params['name']."%");
            });
        }

        return $items
            ->paginate(20);
    }

}
