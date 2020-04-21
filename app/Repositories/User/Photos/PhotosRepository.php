<?php

namespace App\Repositories\User\Photos;

use App\Models\Users\Photos\Photos;
use Illuminate\Support\Facades\Auth;

class PhotosRepository
{

    public function items(int $album_id)
    {
        return Photos::where([
            'user_id' => Auth::id(),
            'album_id' => $album_id
        ])->orderBy('id', 'DESC')
            ->paginate(10);
    }

    public function find($id)
    {
        return Photos::find($id);
    }

}
