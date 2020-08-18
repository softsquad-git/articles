<?php

namespace App\Repositories\User\Experts;

use App\Models\Users\Experts\ExpertArticleOpinion;
use \Exception;

class ExpertOpinionRepository
{
    /**
     * @var ExpertRepository
     */
    private $expertRepository;

    public function __construct(ExpertRepository $expertRepository)
    {
        $this->expertRepository = $expertRepository;
    }

    /**
     * @param int $opinionId
     * @return mixed
     * @throws Exception
     */
    public function findOpinionExpert(int $opinionId)
    {
        $opinion = ExpertArticleOpinion::find($opinionId);
        if (empty($opinion))
            throw new Exception('Opinion not found');
        return $opinion;
    }

    /**
     * @param int $categoryId
     * @return int
     */
    public function isExpertInArticle(int $categoryId)
    {
        $expert = $this->expertRepository->findExpertUser($categoryId);
        if (empty($expert))
            return 0;  #no expert
        else
            return 1;  #yes expert
    }

    public function getOpinions(array $params)
    {
        $expert = $this->expertRepository->findExpertUser($params['category_id']);
        return ExpertArticleOpinion::where('expert_id', $expert->id)
            ->get();
    }

}
