<?php

namespace App\Repositories\User\Photos;

use App\Models\Users\Photos\AlbumPhotos;
use Illuminate\Support\Facades\Auth;
use \Exception;

class AlbumPhotosRepository
{

    /**
     * @param array $params
     * @return mixed
     */
    public function items(array $params)
    {
        $items = AlbumPhotos::orderBy('id', $params['order_by'] ?? 'DESC')
            ->where('user_id', Auth::id());
        if (!empty($params['name']))
            $items->where('name', 'like', '%' . $params['name'] . '%');

        return $items
            ->paginate(6);
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function findAlbum($id)
    {
        $album = AlbumPhotos::find($id);
        if (empty($album))
            throw new Exception('Album not found');
        return $album;
    }

}
