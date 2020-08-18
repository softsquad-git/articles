<?php

namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Articles\ArticleResource;
use App\Http\Resources\Friends\FriendResource;
use App\Http\Resources\User\Photos\AlbumPhotosResource;
use \Exception;
use App\Http\Resources\Users\UserResource;
use App\Repositories\Front\Profile\ProfileRepository;
use App\Repositories\User\Friends\FriendRepository;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProfileController extends Controller
{
    /**
     * @var ProfileRepository
     */
    private $profileRepository;
    /**
     * @var FriendRepository
     */
    private $friendRepository;

    /**
     * @param ProfileRepository $profileRepository
     * @param FriendRepository $friendRepository
     */
    public function __construct(
        ProfileRepository $profileRepository,
        FriendRepository $friendRepository
    )
    {
        $this->profileRepository = $profileRepository;
        $this->friendRepository = $friendRepository;
    }

    /**
     * @param int $id
     * @return UserResource|JsonResponse
     */
    public function user(int $id)
    {
        try {
            return new UserResource($this->profileRepository->findUser($id));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function articles(Request $request)
    {
        $params = [
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title'),
            'category_id' => $request->input('category_id')
        ];
        try {
            return ArticleResource::collection($this->profileRepository->articles($params));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function albums(Request $request)
    {
        try {
            return AlbumPhotosResource::collection($this->profileRepository->albums($request->input('user_id')));
        } catch (\Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function photos(Request $request)
    {
        try {
            $items = $this->profileRepository->photos($request->input('album_id'));
            return response()->json([
                'data' => $items
            ]);
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $userId
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function friends(int $userId)
    {
        try {
            $items = $this->friendRepository->getFriends($userId);
            return FriendResource::collection($items);
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
