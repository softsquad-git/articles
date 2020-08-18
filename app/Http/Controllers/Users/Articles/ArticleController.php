<?php

namespace App\Http\Controllers\Users\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Articles\ArticleRequest;
use App\Http\Requests\User\Articles\ArticleUploadFileEditorRequest;
use App\Http\Resources\Articles\ArticleResource;
use App\Http\Resources\ArticlesListResource;
use App\Repositories\User\Articles\ArticleRepository;
use App\Services\User\Articles\ArticleService;
use Illuminate\Http\Request;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use \Exception;
use \Illuminate\Http\JsonResponse;

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
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        $search = [
            'status' => $request->get('status'),
            'category' => $request->input('category'),
            'ordering' => $request->input('ordering')
        ];
        try {
            return ArticlesListResource::collection($this->articleRepository->items($search));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param $id
     * @return ArticleResource|JsonResponse
     */
    public function item($id)
    {
        try {
            return new ArticleResource($this->articleRepository->find($id));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param ArticleRequest $request
     * @return JsonResponse
     */
    public function store(ArticleRequest $request)
    {
        try {
            $item = $this->articleService->store($request->all());
            if ($request->hasFile('image'))
                $this->articleService->uploadImage($item->id, $request->file('image'));
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param ArticleRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ArticleRequest $request, int $id)
    {
        try {
            $item = $this->articleService->update($request->all(), $id);
            if ($request->hasFile('image'))
                $this->articleService->uploadImage($item->id, $request->file('image'));
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $articleId
     * @return JsonResponse
     */
    public function remove(int $articleId)
    {
        try {
            $this->articleService->remove($articleId);
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function archive(int $id)
    {
        try {
            $this->articleService->archive($id);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param ArticleUploadFileEditorRequest $request
     * @return array|JsonResponse
     */
    public function uploadFileEditor(ArticleUploadFileEditorRequest $request)
    {
        try {
            if ($request->hasFile('image')) {
                $link = $this->articleService->uploadImageEditor($request->file('image'));
                return ['link' => $link];
            }
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
