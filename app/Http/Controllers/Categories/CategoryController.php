<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticlesListResource;
use App\Http\Resources\Categories\CategoryResource;
use App\Repositories\Categories\CategoryRepository;
use Illuminate\Http\Request;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use \Exception;
use \Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;


    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function all()
    {
        try {
            return CategoryResource::collection($this->categoryRepository->getAllCategories());
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function items(Request $request)
    {
        $search = [
            'name' => $request->input('name')
        ];
        try {
            return CategoryResource::collection($this->categoryRepository->getCategories($search));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param string $alias
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getArticlesInCategory(Request $request, string $alias)
    {
        try {
            $params = [
                'title' => $request->input('title'),
                'location' => $request->input('location'),
                'ordering' => $request->input('ordering')
            ];
            return ArticlesListResource::collection($this->categoryRepository->articlesInCategory($alias, $params));
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
