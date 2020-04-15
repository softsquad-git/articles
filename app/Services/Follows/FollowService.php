<?php

namespace App\Services\Follows;

use App\Models\Follows\Follow;
use Illuminate\Support\Facades\Auth;

class FollowService
{

    public function follow(array $data, $item)
    {
        if (!empty($item))
        {
            $item->delete();
            return true;
        }

        $data['user_id'] = Auth::id();
        return Follow::create($data);
    }

}
