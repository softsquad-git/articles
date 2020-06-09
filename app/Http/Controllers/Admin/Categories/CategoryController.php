<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\CategoryRequest;
use App\Http\Resources\Categories\CategoryResource;
use App\Repositories\ADMIN\Categories\CategoryRepository;
use App\Services\ADMIN\Categories\CategoryService;
use Illuminate\Http\Request;
use \Exception;
use \Illuminate\Http\JsonResponse;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryService $categoryService, CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
    }

    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getCategories(Request $request)
    {
        $params = [
            'name' => $request->input('name')
        ];
        try {
            return CategoryResource::collection($this->categoryRepository->getCategories($params));
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        try {
            $this->categoryService->store($request->input());
            return response()->json([
                'success' => 1
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param CategoryRequest $request
     * @param int $categoryId
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, int $categoryId)
    {
        try {
            $this->categoryService->update($request->all(), $categoryId);
            return response()->json([
                'success' => 1
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param int $categoryId
     * @return JsonResponse
     */
    public function remove(int $categoryId)
    {
        try {
            $this->categoryService->remove($categoryId);
            return response()->json([
                'success' => 1
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => 0
            ]);
        }
    }

    /**
     * @param int $categoryId
     * @return CategoryResource|JsonResponse
     */
    public function findCategory(int $categoryId)
    {
        try {
            return new CategoryResource($this->categoryRepository->findCategory($categoryId));
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
