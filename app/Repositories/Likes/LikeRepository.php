<?php

namespace App\Repositories\Likes;

use App\Models\Likes\Like;
use Illuminate\Support\Facades\Auth;

class LikeRepository
{

    /**
     * @param array $params
     * @return mixed
     */
    public function like(array $params)
    {
        return Like::where([
            'user_id' => Auth::id(),
            'resource_id' => $params['resource_id'],
            'resource_type' => $params['resource_type']
        ])->first();
    }

}
