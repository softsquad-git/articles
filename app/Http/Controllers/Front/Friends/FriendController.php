<?php

namespace App\Http\Controllers\Front\Friends;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserResource;
use App\Repositories\Front\Friends\FriendRepository;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * @var FriendRepository
     */
    private $repository;

    public function __construct(FriendRepository $repository)
    {
        $this->repository = $repository;
    }

    public function usersList(Request $request)
    {
        $params = [
            'name' => $request->input('name')
        ];

        return UserResource::collection($this->repository->usersList($params));
    }
}
