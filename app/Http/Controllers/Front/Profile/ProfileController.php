<?php

namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Articles\ArticleResource;
use App\Http\Resources\Friends\FriendResource;
use App\Http\Resources\User\Photos\AlbumPhotosResource;
use App\Http\Resources\User\Photos\PhotosResource;
use App\Http\Resources\Users\UserResource;
use App\Repositories\Front\Profile\ProfileRepository;
use App\Repositories\User\Friends\FriendRepository;
use Illuminate\Http\Request;

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
     * ProfileController constructor.
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
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function user(int $id)
    {
        try {
            return new UserResource($this->profileRepository->findUser($id));
        }catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
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
        } catch (\Exception $e){
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function albums(Request $request)
    {
        try {
            return AlbumPhotosResource::collection($this->profileRepository->albums($request->input('user_id')));
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function photos(Request $request)
    {
        try {
            $items = $this->profileRepository->photos($request->input('album_id'));
            return response()->json([
                'data' => $items
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function friends(int $user_id){
        try {
            $items = $this->friendRepository->getFriends($user_id);
            return FriendResource::collection($items);
        } catch (\Exception $e){
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
