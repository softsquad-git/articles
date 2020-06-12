<?php

namespace App\Http\Controllers\Users\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Photos\AlbumPhotosRequest;
use App\Http\Resources\User\Photos\AlbumPhotosResource;
use App\Repositories\User\Photos\AlbumPhotosRepository;
use App\Services\User\Photos\AlbumPhotosService;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use \Exception;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AlbumPhotosController extends Controller
{
    /**
     * @var AlbumPhotosRepository
     */
    private $albumPhotosRepository;
    /**
     * @var AlbumPhotosService
     */
    private $albumPhotosService;

    /**
     * @param AlbumPhotosRepository $albumPhotosRepository
     * @param AlbumPhotosService $albumPhotosService
     */
    public function __construct(AlbumPhotosRepository $albumPhotosRepository, AlbumPhotosService $albumPhotosService)
    {
        $this->albumPhotosRepository = $albumPhotosRepository;
        $this->albumPhotosService = $albumPhotosService;
    }

    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        $params = [
            'name' => $request->input('name'),
            'order_by' => $request->input('order_by')
        ];
        try {
            return AlbumPhotosResource::collection($this->albumPhotosRepository->items($params));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param AlbumPhotosRequest $request
     * @return JsonResponse
     */
    public function store(AlbumPhotosRequest $request)
    {
        try {
            $this->albumPhotosService->store($request->all());
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param AlbumPhotosRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AlbumPhotosRequest $request, int $id)
    {
        try {
            $this->albumPhotosService->update($request->all(), $id);
            return $this->successResponse();
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
            $this->albumPhotosService->remove($id);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
