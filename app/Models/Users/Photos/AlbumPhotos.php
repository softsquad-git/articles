<?php

namespace App\Models\Users\Photos;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AlbumPhotos extends Model
{
    protected $table = 'photos_album';

    protected $fillable = [
        'user_id',
        'name',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photos::class, 'album_id');
    }
}
