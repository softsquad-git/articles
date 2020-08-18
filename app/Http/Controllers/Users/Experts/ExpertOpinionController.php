<?php

namespace App\Http\Controllers\Users\Experts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Experts\ExpertOpinionRequest;
use App\Http\Resources\User\Experts\OpinionsExpertsResource;
use App\Repositories\User\Experts\ExpertOpinionRepository;
use App\Services\User\Experts\ExpertOpinionService;
use \Exception;
use \Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpertOpinionController extends Controller
{
    /**
     * @var ExpertOpinionService
     */
    private $expertOpinionService;

    /**
     * @var ExpertOpinionRepository
     */
    private $expertOpinionRepository;

    /**
     * @param ExpertOpinionService $expertOpinionService
     * @param ExpertOpinionRepository $expertOpinionRepository
     */
    public function __construct(
        ExpertOpinionService $expertOpinionService,
        ExpertOpinionRepository $expertOpinionRepository)
    {
        $this->expertOpinionService = $expertOpinionService;
        $this->expertOpinionRepository = $expertOpinionRepository;
    }

    public function getOpinions(Request $request)
    {
        $params = [
            'category_id' => $request->input('category_id')
        ];
        try {
            return OpinionsExpertsResource::collection($this->expertOpinionRepository->getOpinions($params));
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param ExpertOpinionRequest $request
     * @return JsonResponse
     */
    public function store(ExpertOpinionRequest $request)
    {
        try {
            $this->expertOpinionService->store($request->all());
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param ExpertOpinionRequest $request
     * @param int $opinionId
     * @return JsonResponse
     */
    public function update(ExpertOpinionRequest $request, int $opinionId)
    {
        try {
            $this->expertOpinionService->update($request->all(), $opinionId);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $opinionId
     * @return JsonResponse
     */
    public function remove(int $opinionId)
    {
        try {
            $this->expertOpinionService->remove($opinionId);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param int $categoryId
     * @return JsonResponse
     */
    public function isExpertInArticle(int $categoryId)
    {
        try {
            return response()->json([
                'status' => $this->expertOpinionRepository->isExpertInArticle($categoryId)
            ]);
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

}
