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
    private $friendRepository;

    /**
     * FriendController constructor.
     * @param FriendRepository $friendRepository
     */
    public function __construct(FriendRepository $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function usersList(Request $request)
    {
        $params = ['name' => $request->input('name')];
        return UserResource::collection($this->friendRepository->usersList($params));
    }
}
