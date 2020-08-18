<?php

namespace App\Http\Controllers\Users\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Photos\PhotosRequest;
use App\Http\Resources\User\Photos\PhotosResource;
use App\Repositories\User\Photos\AlbumPhotosRepository;
use App\Repositories\User\Photos\PhotosRepository;
use App\Services\User\Photos\PhotosService;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use \Exception;
use \Illuminate\Http\JsonResponse;

class PhotoController extends Controller
{

    /**
     * @var PhotosRepository
     */
    private $photosRepository;
    /**
     * @var PhotosService
     */
    private $photosService;
    /**
     * @var AlbumPhotosRepository
     */
    private $albumRepository;

    /**
     * @param PhotosService $photosService
     * @param PhotosRepository $photosRepository
     * @param AlbumPhotosRepository $albumRepository
     */
    public function __construct(
        PhotosService $photosService,
        PhotosRepository $photosRepository,
        AlbumPhotosRepository $albumRepository
    )
    {
        $this->photosService = $photosService;
        $this->photosRepository = $photosRepository;
        $this->albumRepository = $albumRepository;
    }

    /**
     * @param int $album_id
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function items(int $album_id)
    {
        try {
            return PhotosResource::collection($this->photosRepository->items($album_id));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param PhotosRequest $request
     * @return JsonResponse
     */
    public function store(PhotosRequest $request)
    {
        $album_id = $request->input('album_id') ?? 0;
        try {
            if ($request->hasFile('photos')) {
                $this->photosService->store($album_id, $request->file('photos'));
                return response()->json(['success' => 1]);
            }
            return response()->json(['success' => 0, 'msg' => 'No photos']);
        } catch (\Exception $e) {
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
            $this->photosService->remove($id);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

}
