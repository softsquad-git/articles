<?php

namespace App\Http\Controllers\Users\Friends;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Friends\FriendRequest;
use App\Http\Resources\Friends\FriendResource;
use App\Repositories\User\Friends\FriendRepository;
use App\Services\User\Friends\FriendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    /**
     * @var FriendService
     */
    private $friendService;
    /**
     * @var FriendRepository
     */
    private $friendRepository;

    /**
     * FriendController constructor.
     * @param FriendService $friendService
     * @param FriendRepository $friendRepository
     */
    public function __construct(FriendService $friendService, FriendRepository $friendRepository)
    {
        $this->friendService = $friendService;
        $this->friendRepository = $friendRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function friends(Request $request)
    {
        try {
            $items = $this->friendRepository->getFriends(Auth::id(), $request->input('name'));
            return FriendResource::collection($items);
        } catch (\Exception $e){
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param FriendRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FriendRequest $request)
    {
        try {
            $this->friendService->store($request->recipient_id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function sentInvitations()
    {
        try {
            return FriendResource::collection($this->friendRepository->sentInvitations());
        } catch (\Exception $e){
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function waitingInvitations()
    {
        try {
            return FriendResource::collection($this->friendRepository->waitingInvitations());
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        try {
            $this->friendService->remove($id);
            return response()->json(['success' => 1]);
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
            $this->friendService->acceptInvitation($id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
