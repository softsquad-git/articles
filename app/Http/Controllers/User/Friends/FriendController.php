<?php

namespace App\Http\Controllers\User\Friends;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Friends\FriendRequest;
use App\Http\Resources\Users\UserResource;
use App\Repositories\User\Friends\FriendRepository;
use App\Services\User\Friends\FriendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    /**
     * @var FriendService
     * @var FriendRepository
     */
    private $service;
    private $repository;

    public function __construct(FriendService $service, FriendRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function friends(Request $request)
    {
        $status = $request->input('status');
        $items = $this->repository->getFriends($status, Auth::id());

        return UserResource::collection($items);
    }

    public function store(FriendRequest $request)
    {
        try {

        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
        $this->service->store($request->recipient_id);
        return response()->json([
            'success' => 1,
        ]);
    }
}
