<?php

namespace App\Services\Likes;

use App\Models\Likes\Like;
use Illuminate\Support\Facades\Auth;

class LikeService
{

    public function like(array $data, $item)
    {
        $data['user_id'] = Auth::id();
        // add like or dislike
        if (empty($item)){
            return Like::create($data);
        }
        // remove like or dislike
        $like = $data['like'];
        if ($item->like == $like){
            $item->delete();

            return true;
        }
        // update like or dislike
        $item->update($data);

        return $item;
    }

}
