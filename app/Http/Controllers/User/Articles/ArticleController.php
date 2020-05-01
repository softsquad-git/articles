<?php

namespace App\Http\Controllers\User\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Articles\ArticleRequest;
use App\Http\Requests\User\Articles\ArticleUploadFileEditorRequest;
use App\Http\Requests\User\Articles\ArticleUploadVideoEditorRequest;
use App\Http\Requests\User\Articles\ArtilceImagesRequest;
use App\Http\Resources\Articles\ArticleImagesResource;
use App\Http\Resources\Articles\ArticleResource;
use App\Repositories\User\Articles\ArticleRepository;
use App\Services\User\Articles\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @var $repository
     * @var $service
     */
    private $service;
    private $repository;

    public function __construct(ArticleRepository $repository, ArticleService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function items(Request $request)
    {
        $search = [
            'status' => $request->get('status')
        ];

        $items = $this->repository->items($search);

        return ArticleResource::collection($items);
    }

    public function item($id)
    {
        $item = $this->repository->find($id);
        if (empty($item)) {
            return response()->json([
                'success' => 0
            ]);
        }

        return new ArticleResource($item);
    }

    public function store(ArticleRequest $request)
    {
        $item = $this->service->store($request->all());
        if ($request->hasFile('images'))
            $this->service->uploadImages($item->id, $request->file('images'));

        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }

    public function update(ArticleRequest $request, $id)
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

    public function uploadImages(ArtilceImagesRequest $request, $article_id)
    {
        $article = $this->repository->find($article_id);
        if ($request->hasFile('images') && !empty($article)){
            $images = $this->service->uploadImages($article_id, $request->file('images'));

            return response()->json([
                'success' => 1,
                'items' => $images
            ]);
        }

        return response()->json([
            'success' => 0
        ]);
    }

    public function removeImage($id)
    {
        $item = $this->repository->findImage($id);
        if (empty($item)){
            return response()->json([
                'success' => 0
            ]);
        }

        $this->service->removeImage($item);

        return response()->json([
            'success' => 1
        ]);
    }

    public function archive($id)
    {
        $item = $this->repository->find($id);
        if (empty($item)){
            return response()->json([
                'success' => 0
            ]);
        }

        $item = $this->service->archive($item);

        return response()->json([
            'success' => 1,
            'status' => $item->status
        ]);
    }

    public function uploadFileEditor(ArticleUploadFileEditorRequest $request){
        if ($request->hasFile('file'))
        {
            $link = $this->service->uploadImageEditor($request->file('file'));
            return [
                'link' => $link
            ];
        }
        return response()->json([
            'success' => 0
        ]);
    }

    public function getImages(int $id)
    {
        try {
            $items = $this->repository->getImages($id);
            return ArticleImagesResource::collection($items);
        } catch (\Exception $e){
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
