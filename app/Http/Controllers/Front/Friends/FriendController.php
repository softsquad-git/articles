<?php

namespace App\Http\Controllers\Front\Friends;

use App\Http\Controllers\Controller;
use App\Http\Resources\Friends\PeoplesResource;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Repositories\Front\Friends\FriendRepository;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * @var FriendRepository
     */
    private $friendRepository;

    /**
     * @param FriendRepository $friendRepository
     */
    public function __construct(FriendRepository $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function usersList(Request $request)
    {
        $params = ['name' => $request->input('name'), 'ordering' => $request->input('ordering')];
        return PeoplesResource::collection($this->friendRepository->usersList($params));
    }
}
