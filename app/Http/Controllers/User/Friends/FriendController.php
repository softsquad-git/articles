<?php

namespace App\Http\Controllers\User\Friends;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Friends\FriendRequest;
use App\Http\Resources\Friends\FriendResource;
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

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function friends()
    {
        $items = $this->repository->getFriends(Auth::id());

        return FriendResource::collection($items);
    }

    /**
     * @param FriendRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FriendRequest $request)
    {
        try {
            $this->service->store($request->recipient_id);
            return response()->json([
                'success' => 1,
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function sentInvitations()
    {
        return FriendResource::collection($this->repository->sentInvitations());
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function waitingInvitations()
    {
        return FriendResource::collection($this->repository->waitingInvitations());
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        try {
            $this->service->remove($id);
            return response()->json([
                'success' => 1
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptInvitation(int $id)
    {
        try {
            $this->service->acceptInvitation($id);
            return response()->json([
                'success' => 1
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
