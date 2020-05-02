<?php

namespace App\Services\Front\Articles;

use App\Models\Articles\RatingArticle;
use App\Repositories\Front\Articles\RatingArticleRepository;
use Illuminate\Support\Facades\Auth;

class RatingArticleService
{

    /**
     * @var RatingArticleRepository
     */
    private $ratingArticleRepository;

    /**
     * RatingArticleService constructor.
     * @param RatingArticleRepository $ratingArticleRepository
     */
    public function __construct(RatingArticleRepository $ratingArticleRepository)
    {
        $this->ratingArticleRepository = $ratingArticleRepository;
    }

    /**
     * @param array $data
     * @param int $article_id
     * @return mixed
     */
    public function store(array $data, int $article_id)
    {
        $item = $this->ratingArticleRepository->findRatingUser($article_id);
        if (empty($item)) {
            $data['user_id'] = Auth::id();
            return RatingArticle::create($data);
        }
        $item->update($data);
        return $item;
    }

}
