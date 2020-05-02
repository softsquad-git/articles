<?php

namespace App\Repositories\Front\Articles;

use App\Models\Articles\RatingArticle;
use Illuminate\Support\Facades\Auth;

class RatingArticleRepository
{

    public function find($id)
    {
        return RatingArticle::find($id);
    }

    public static function getAverageRatings(int $id)
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
        return $ratings_count == 0 ? 0 : ($points_sum / $ratings_count);
    }

    public function findRatingUser($id){
        return RatingArticle::where([
            'user_id' => Auth::id(),
            'article_id' => $id
        ])->first();
    }

}
