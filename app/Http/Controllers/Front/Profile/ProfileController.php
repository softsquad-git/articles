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
use App\Repositories\User\Photos\AlbumPhotosRepository;
use App\Services\Front\Profile\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @var $service
     * @var $repository
     * @var AlbumPhotosRepository,
     * @var FriendRepository
     */
    private $service;
    private $repository;
    private $albumPhotosRepository;
    private $friendRepository;

    public function __construct(ProfileRepository $repository,
                                ProfileService $service,
                                AlbumPhotosRepository $albumPhotosRepository,
                                FriendRepository $friendRepository
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->albumPhotosRepository = $albumPhotosRepository;
        $this->friendRepository = $friendRepository;
    }

    public function user($id)
    {
        $item = $this->repository->find($id);
        if (empty($item)) {
            return response()->json([
                'success' => 0
            ]);
        }
        return new UserResource($item);
    }

    public function articles(Request $request)
    {
        if (empty($request->input('user_id'))) {
            return response()->json([
                'success' => 0
            ], 403);
        }
        $params = [
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title'),
            'category_id' => $request->input('category_id')
        ];
        return ArticleResource::collection($this->repository->articles($params));
    }

    public function albums(Request $request)
    {
        if (empty($request->input('user_id'))) {
            return response()->json(['success' => 0]);
        }
        $item = $this->repository->find($request->input('user_id'));
        if (empty($item)) {
            return response()->json([
                'success' => 0
            ]);
        }
        return AlbumPhotosResource::collection($this->repository->albums($item));
    }

    public function photos(Request $request)
    {
        if (empty($request->input('album_id'))) {
            return response()->json([
                'success' => 0
            ]);
        }
        $item = $this->albumPhotosRepository->find($request->input('album_id'));
        if (empty($item)) {
            return response()->json([
                'success' => 0
            ]);
        }
        $items = $this->repository->photos($item);

        return PhotosResource::collection($items);
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
