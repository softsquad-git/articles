<?php

namespace App\Http\Controllers\Users\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Photos\AlbumPhotosRequest;
use App\Http\Resources\User\Photos\AlbumPhotosResource;
use App\Repositories\User\Photos\AlbumPhotosRepository;
use App\Services\User\Photos\AlbumPhotosService;
use Illuminate\Http\Request;

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
     * AlbumPhotosController constructor.
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        $params = [
            'name' => $request->input('name'),
            'order_by' => $request->input('order_by')
        ];
        try {
            return AlbumPhotosResource::collection($this->albumPhotosRepository->items($params));
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param AlbumPhotosRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AlbumPhotosRequest $request)
    {
        try {
            $this->albumPhotosService->store($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param AlbumPhotosRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AlbumPhotosRequest $request, int $id)
    {
        try {
            $this->albumPhotosService->update($request->all(), $id);
            return response()->json(['success' => 1]);
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
            $this->albumPhotosService->remove($id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
