<?php

namespace App\Services\User\Experts;

use App\Models\Users\Experts\ExpertArticleOpinion;
use App\Repositories\User\Articles\ArticleRepository;
use App\Repositories\User\Experts\ExpertOpinionRepository;
use \Exception;
use Illuminate\Support\Facades\Auth;

class ExpertOpinionService
{
    /**
     * @var ExpertOpinionRepository
     */
    private $expertOpinionRepository;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * ExpertOpinionService constructor.
     * @param ExpertOpinionRepository $expertOpinionRepository
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ExpertOpinionRepository $expertOpinionRepository, ArticleRepository $articleRepository)
    {
        $this->expertOpinionRepository = $expertOpinionRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function store(array $data)
    {
        $articleId = $data['article_id'];
        $this->articleRepository->find($articleId);
        $expertId = Auth::user()->expert->id;
        $data['expert_id'] = $expertId;
        $opinion = ExpertArticleOpinion::create($data);
        if (empty($opinion))
            throw new Exception('Created opinion error');
        return $opinion;
    }

    /**
     * @param array $data
     * @param int $opinionId
     * @return mixed
     * @throws Exception
     */
    public function update(array $data, int $opinionId)
    {
        $opinion = $this->expertOpinionRepository->findOpinionExpert($opinionId);
        $opinion->update($data);
        return $opinion;
    }

    /**
     * @param int $opinionId
     * @return mixed
     * @throws Exception
     */
    public function remove(int $opinionId)
    {
        return $this->expertOpinionRepository->findOpinionExpert($opinionId)->delete();

    }
}
