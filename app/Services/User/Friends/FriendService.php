<?php

namespace App\Services\User\Friends;

use App\Helpers\FriendshipStatus;
use \Exception;
use App\Repositories\User\Friends\FriendRepository;
use App\User;
use Illuminate\Support\Facades\Auth;

class FriendService
{
    /**
     * @var FriendRepository
     */
    private $friendRepository;

    public function __construct(FriendRepository $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    /**
     * @param int $recipient_id
     * @return mixed
     */
    public function store(int $recipient_id)
    {
        return User::find(Auth::id())
            ->friends()->syncWithoutDetaching($recipient_id, ['status' => FriendshipStatus::SENT]);
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws Exception
     */
    public function remove(int $id): ?bool
    {
        $item = $this->friendRepository->findPivot($id);
        return $item->delete();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function acceptInvitation(int $id)
    {
        $item = $this->friendRepository->findPivot($id);
        if (empty($item) || $item->recipient_id != Auth::id())
            throw new Exception(sprintf('Not found'));
        return $item->update([
            'status' => FriendshipStatus::FRIENDS
        ]);
    }

}
