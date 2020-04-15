<?php

namespace App\Repositories\Front\Articles;

use App\Models\Articles\RatingArticle;

class RatingArticleRepository
{

    public function find($id)
    {
        return RatingArticle::find($id);
    }

    public static function getAverageRatings($id)
    {
        $ratings = RatingArticle::where('article_id', $id)
            ->get();
        $points = [];
        foreach ($ratings as $rating)
        {
            $points[] = $rating->points;
        }
        $points_sum = array_sum($points);
        $ratings_count = count($ratings);
        return $points_sum / $ratings_count;
    }

}
