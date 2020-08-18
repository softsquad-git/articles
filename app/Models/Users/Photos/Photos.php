<?php

namespace App\Models\Users\Photos;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $table = 'photos_user';

    protected $fillable = [
        'user_id',
        'album_id',
        'src'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(AlbumPhotos::class);
    }
}
