<?php

namespace App\Services\User\Photos;

use App\Models\Users\Photos\AlbumPhotos;
use Illuminate\Support\Facades\Auth;

class AlbumPhotosService
{
    /**
     * @param array $data
     * @return AlbumPhotos
     */
    public function store(array $data): AlbumPhotos
    {
        $data['user_id'] = Auth::id();
        return AlbumPhotos::create($data);
    }

    /**
     * @param array $data
     * @param AlbumPhotos $item
     * @return AlbumPhotos
     */
    public function update(array $data, AlbumPhotos $item): AlbumPhotos
    {
        $item->update($data);
        return $item;
    }

    /**
     * @param AlbumPhotos $item
     * @return bool|null
     * @throws \Exception
     */
    public function remove(AlbumPhotos $item): ?bool
    {
        return $item->delete();
    }

}
