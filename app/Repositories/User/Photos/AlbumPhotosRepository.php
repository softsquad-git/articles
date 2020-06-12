<?php

namespace App\Repositories\User\Photos;

use App\Models\Users\Photos\AlbumPhotos;
use Illuminate\Support\Facades\Auth;

class AlbumPhotosRepository
{

    public function items(array $params)
    {
        $items = AlbumPhotos::orderBy('id', $params['order_by'] ?? 'DESC')
            ->where('user_id', Auth::id());
        if (!empty($params['name']))
            $items->where('name', 'like', '%' . $params['name'] . '%');

        return $items
            ->paginate(6);
    }

    public function find($id)
    {
        return AlbumPhotos::find($id);
    }

}
