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

    public function getFollows(string $resource_type)
    {
        return Follow::where([
            'user_id' => Auth::id(),
            'resource_type' => $resource_type
        ])->orderBy('id', 'DESC')
            ->paginate(10);
    }

    public function getWatchingYou()
    {
        return Follow::where([
            'resource_id' => Auth::id(),
            'resource_type' => 'USER'
        ])->orderBy('id', 'DESC')
            ->paginate(10);
    }

    public function findFollow(int $id)
    {
        return Follow::find($id);
    }

}
