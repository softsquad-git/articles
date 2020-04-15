<?php

namespace App\Repositories\Follows;

use App\Models\Follows\Follow;
use Illuminate\Support\Facades\Auth;

class FollowRepository
{

    public function follow($resource_id, $resource_type)
    {
        return Follow::where([
            'user_id' => Auth::id(),
            'resource_id' => $resource_id,
            'resource_type' => $resource_type
        ])->first();
    }

}
