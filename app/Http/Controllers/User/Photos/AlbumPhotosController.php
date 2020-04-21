<?php

namespace App\Http\Controllers\User\Photos;

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
     * @var AlbumPhotosService
     */
    private $repository;
    private $service;

    public function __construct(AlbumPhotosRepository $repository, AlbumPhotosService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function items(Request $request)
    {
        $params = [
            'name' => $request->input('name'),
            'order_by' => $request->input('order_by')
        ];
        return AlbumPhotosResource::collection($this->repository->items($params));
    }

    public function store(AlbumPhotosRequest $request)
    {
        $item = $this->service->store($request->all());
        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }

    public function update(AlbumPhotosRequest $request, $id)
    {
        $item = $this->repository->find($id);
        if (empty($item)) {
            return response()->json([
                'success' => 0
            ]);
        }
        $item = $this->service->update($request->all(), $item);
        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }

    public function remove($id)
    {
        $item = $this->repository->find($id);
        if (empty($item)) {
            return response()->json([
                'success' => 0
            ]);
        }
        $this->service->remove($item);
        return response()->json([
            'success' => 1
        ]);
    }
}
