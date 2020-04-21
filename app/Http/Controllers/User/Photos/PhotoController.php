<?php

namespace App\Http\Controllers\User\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Photos\PhotosRequest;
use App\Http\Resources\User\Photos\PhotosResource;
use App\Repositories\User\Photos\AlbumPhotosRepository;
use App\Repositories\User\Photos\PhotosRepository;
use App\Services\User\Photos\PhotosService;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * @var PhotosRepository
     * @var PhotosService
     * @var AlbumPhotosRepository
     */
    private $repository;
    private $service;
    private $albumRepository;

    public function __construct(PhotosService $service, PhotosRepository $repository, AlbumPhotosRepository $albumRepository)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->albumRepository = $albumRepository;
    }

    public function items($album_id)
    {
        return PhotosResource::collection($this->repository->items($album_id));
    }

    public function store(PhotosRequest $request)
    {
        $album_id = $request->input('album_id') ?? 0;
        if (!empty($album_id) && $album_id > 0) {
            $album = $this->albumRepository->find($album_id);
            if (empty($album)) {
                $album_id = 0;
            }
        }
        if ($request->hasFile('photos')) {
            $item = $this->service->store($album_id, $request->file('photos'));
            return response()->json([
                'success' => 1,
                'item' => $item
            ]);
        }
        return response()->json([
            'success' => 0,
            'msg' => 'No photos'
        ]);
    }

    public function remove($id)
    {
        $item = $this->repository->find($id);
        try {
            $result = $this->service->remove($item);
            if ($result === null){
                return response()->json([
                    'success' => 0
                ]);
            }
            return response()->json([
                'success' => 1
            ]);
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }

}
