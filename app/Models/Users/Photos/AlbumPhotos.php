<?php

namespace App\Models\Users\Photos;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AlbumPhotos extends Model
{
    protected $table = 'photos_album';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'is_public',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photos::class, 'album_id')
            ->where('user_id', Auth::id());
    }
}
