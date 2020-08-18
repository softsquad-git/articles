<?php

namespace App\Services\Likes;

use App\Models\Likes\Like;
use App\Repositories\Likes\LikeRepository;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    /**
     * @var LikeRepository
     */
    private $likeRepository;

    /**
     * @param LikeRepository $likeRepository
     */
    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    /**
     * @param array $data
     * @param array $params
     * @return bool
     */
    public function like(array $data, array $params)
    {
        $item = $this->likeRepository->like($params);
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
