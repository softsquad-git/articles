<?php

namespace App\Helpers;

use App\Services\User\Articles\ArticleService;

class ArticleImage
{
    /**
     * @param string|null $image
     * @return string
     */
    public static function topImage(?string $image): string
    {
        $b_path = ArticleService::IMAGES_ARTICLE_PATH;
        if (!empty($image->src))
            return asset($b_path.$image->src);

        return asset($b_path.config('app.enum.defaults.filenames.article'));
    }
}
