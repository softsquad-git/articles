<?php

namespace App\Models\Likes;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    protected $fillable = [
        'user_id',
        'resource_id',
        'resource_type',
        'like'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
