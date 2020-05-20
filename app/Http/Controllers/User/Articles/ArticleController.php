<?php

namespace App\Http\Controllers\User\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Articles\ArticleRequest;
use App\Http\Requests\User\Articles\ArticleUploadFileEditorRequest;
use App\Http\Requests\User\Articles\ArtilceImagesRequest;
use App\Http\Resources\Articles\ArticleImagesResource;
use App\Http\Resources\Articles\ArticleResource;
use App\Repositories\User\Articles\ArticleRepository;
use App\Services\User\Articles\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * ArticleController constructor.
     * @param ArticleRepository $articleRepository
     * @param ArticleService $articleService
     */
    public function __construct(ArticleRepository $articleRepository, ArticleService $articleService)
    {
        $this->articleRepository = $articleRepository;
        $this->articleService = $articleService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        $search = [
            'status' => $request->get('status'),
            'category' => $request->input('category'),
            'ordering' => $request->input('ordering')
        ];
        return ArticleResource::collection($this->articleRepository->items($search));
    }

    /**
     * @param $id
     * @return ArticleResource|\Illuminate\Http\JsonResponse
     */
    public function item($id)
    {
        try {
            return new ArticleResource($this->articleRepository->find($id));
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param ArticleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ArticleRequest $request)
    {
        try {
            $item = $this->articleService->store($request->all());
            if ($request->hasFile('images'))
                $this->articleService->uploadImages($item->id, $request->file('images'));
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param ArticleRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ArticleRequest $request, int $id)
    {
        try {
            $this->articleService->update($request->all(), $id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $articleId
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(int $articleId)
    {
        try {
            $this->articleService->remove($articleId);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param ArtilceImagesRequest $request
     * @param int $article_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImages(ArtilceImagesRequest $request, int $article_id)
    {
        try {
            if ($request->hasFile('images')) {
                $this->articleService->uploadImages($article_id, $request->file('images'));
                return response()->json(['success' => 1]);
            }
            return response()->json(['msg' => 'Images not found']);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeImage(int $id)
    {
        try {
            $this->articleService->removeImage($id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive(int $id)
    {
        try {
            $this->articleService->archive($id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param ArticleUploadFileEditorRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function uploadFileEditor(ArticleUploadFileEditorRequest $request)
    {
        if ($request->hasFile('image')) {
            $link = $this->articleService->uploadImageEditor($request->file('image'));
            return ['link' => $link];
        }
        return response()->json(['success' => 0]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getImages(int $id)
    {
        try {
            $items = $this->articleRepository->getImages($id);
            return ArticleImagesResource::collection($items);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
