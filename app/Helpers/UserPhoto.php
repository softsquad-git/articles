<?php

namespace App\Helpers;

use App\Services\User\Photos\PhotosService;

class UserPhoto
{

    public static function intro($photo)
    {
        if (!empty($photo)){
            return asset(PhotosService::PATH_PHOTOS.$photo);
        }
        return asset(PhotosService::PATH_PHOTOS.'df-album.jpg');
    }

}
