<?php

namespace App\Services\Front\Articles;

use App\Models\Articles\RatingArticle;
use Illuminate\Support\Facades\Auth;

class RatingArticleService
{

    public function store(array $data)
    {
        $data['user_id'] = Auth::id();
        return RatingArticle::create($data);
    }

}
