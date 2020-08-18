<?php

namespace App\Http\Controllers\Users\Experts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Experts\ExpertRequest;
use App\Http\Resources\Categories\CategoryResource;
use App\Repositories\User\Experts\ExpertRepository;
use App\Services\User\Experts\ExpertService;
use \Exception;
use \Illuminate\Http\JsonResponse;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExpertController extends Controller
{
    /**
     * @var ExpertRepository
     */
    private $expertRepository;

    /**
     * @var ExpertService
     */
    private $expertService;

    /**
     * ExpertController constructor.
     * @param ExpertService $expertService
     * @param ExpertRepository $expertRepository
     */
    public function __construct(ExpertService $expertService, ExpertRepository $expertRepository)
    {
        $this->expertRepository = $expertRepository;
        $this->expertService = $expertService;
    }

    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getCategories()
    {
        try {
            return CategoryResource::collection($this->expertRepository->getCategories());
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param ExpertRequest $request
     * @return JsonResponse
     */
    public function registerExpert(ExpertRequest $request)
    {
        try {
            $this->expertService->registerExpert($request->all());
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $categoryId
     * @return JsonResponse
     */
    public function remove(int $categoryId)
    {
        try {
            $this->expertService->remove($categoryId);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
