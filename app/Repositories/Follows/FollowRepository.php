<?php

namespace App\Repositories\Follows;

use App\Models\Follows\Follow;
use Illuminate\Support\Facades\Auth;

class FollowRepository
{

    /**
     * @param int $resource_id
     * @param string $resource_type
     * @return mixed
     */
    public function follow(int $resource_id, string $resource_type)
    {
        return Follow::where([
            'user_id' => Auth::id(),
            'resource_id' => $resource_id,
            'resource_type' => $resource_type
        ])->first();
    }

}
