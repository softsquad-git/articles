<?php

namespace App\Helpers;

use App\Services\User\Articles\ArticleService;

class ArticleImage
{
    public static function topImage($image){
        $b_path = ArticleService::IMAGES_ARTICLE_PATH;

        if (!empty($image->src))
        {
            return asset($b_path.$image->src);
        }

        return asset($b_path.'df.png');
    }
}
