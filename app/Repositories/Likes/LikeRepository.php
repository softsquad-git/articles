<?php

namespace App\Repositories\Likes;

use App\Models\Likes\Like;
use Illuminate\Support\Facades\Auth;

class LikeRepository
{

    public function like($resource_id, $resource_type)
    {
        return Like::where([
            'user_id' => Auth::id(),
            'resource_id' => $resource_id,
            'resource_type' => $resource_type
        ])->first();
    }

}
