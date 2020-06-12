<?php

namespace App\Http\Controllers\Users\Friends;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Friends\FriendRequest;
use App\Http\Resources\Friends\FriendResource;
use App\Repositories\User\Friends\FriendRepository;
use App\Services\User\Friends\FriendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Exception;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use \Illuminate\Http\JsonResponse;

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
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function friends(Request $request)
    {
        try {
            $items = $this->friendRepository->getFriends(Auth::id(), $request->input('name'));
            return FriendResource::collection($items);
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param FriendRequest $request
     * @return JsonResponse
     */
    public function store(FriendRequest $request)
    {
        try {
            $this->friendService->store($request->recipient_id);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function sentInvitations()
    {
        try {
            return FriendResource::collection($this->friendRepository->sentInvitations());
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function waitingInvitations()
    {
        try {
            return FriendResource::collection($this->friendRepository->waitingInvitations());
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function remove(int $id)
    {
        try {
            $this->friendService->remove($id);
            return response()->json(['success' => 1]);
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function acceptInvitation(int $id)
    {
        try {
            $this->friendService->acceptInvitation($id);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
