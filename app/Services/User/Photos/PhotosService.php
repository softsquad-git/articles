<?php

namespace App\Services\User\Photos;

use App\Models\Users\Photos\Photos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PhotosService
{
    const PATH_PHOTOS = 'assets/data/user/photos/';

    public function store(int $album_id, array $photos): array
    {
        $photosUser = [];
        $b_path = PhotosService::PATH_PHOTOS;
        foreach ($photos as $photo){
            $file_name = md5(time() . Str::random(32) . '.' . $photo->getClientOriginalExtension());
            $photo->move($b_path, $file_name);
            $img = Photos::create([
                'user_id' => Auth::id(),
                'album_id' => $album_id,
                'src' => $file_name
            ]);
            $photosUser[] = $img;
        }
        return $photosUser;
    }

    /**
     * @param Photos $item
     * @return bool|null
     * @throws \Exception
     */
    public function remove(Photos $item): ?bool
    {
        if (empty($item))
            throw new \Exception('Photo not found');
        return $item->delete();
    }

}
