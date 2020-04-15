<?php

namespace App\Services\Front\Articles;

use App\Models\Articles\RatingArticle;
use Illuminate\Support\Facades\Auth;

class RatingArticleService
{

    public function store(array $data, $item)
    {
        if (empty($item)) {
            $data['user_id'] = Auth::id();
            return RatingArticle::create($data);
        }
        $item->update($data);
        return $item;
    }

}
