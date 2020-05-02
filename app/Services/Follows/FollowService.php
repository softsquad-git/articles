<?php

namespace App\Services\Follows;

use App\Models\Follows\Follow;
use App\Repositories\Follows\FollowRepository;
use Illuminate\Support\Facades\Auth;

class FollowService
{
    /**
     * @var FollowRepository
     */
    private $followRepository;

    /**
     * FollowService constructor.
     * @param FollowRepository $followRepository
     */
    public function __construct(FollowRepository $followRepository)
    {
        $this->followRepository = $followRepository;
    }

    /**
     * @param array $data
     * @param array $params
     * @return bool
     * @throws \Exception
     */
    public function follow(array $data, array $params)
    {
        $item = $this->followRepository->follow($params['resource_id'], $params['resource_type']);
        if (!empty($item)) {
            $item->delete();
            return true;
        }
        $data['user_id'] = Auth::id();
        $follow = Follow::create($data);
        if (empty($follow))
            throw new \Exception(sprintf('Refresh page and try again'));
        return $follow;
    }

}
