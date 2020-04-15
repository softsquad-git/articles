<?php

namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Articles\ArticleResource;
use App\Http\Resources\Users\UserResource;
use App\Repositories\Front\Profile\ProfileRepository;
use App\Services\Front\Profile\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @var $service
     * @var $repository
     */
    private $service;
    private $repository;

    public function __construct(ProfileRepository $repository, ProfileService $service)
    {
        $this->service = $service;
        $this->repository = $repository;
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
}
