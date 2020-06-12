<?php

namespace App\Http\Controllers\Front\Friends;

use App\Http\Controllers\Controller;
use App\Http\Resources\Friends\PeoplesResource;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Repositories\Front\Friends\FriendRepository;
use Illuminate\Http\Request;
use \Exception;
use \Illuminate\Http\JsonResponse;

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
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function usersList(Request $request)
    {
        $params = [
            'name' => $request->input('name'),
            'ordering' => $request->input('ordering')
        ];
        try {
            return PeoplesResource::collection($this->friendRepository->usersList($params));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
