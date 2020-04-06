<?php

namespace App\Models\Users;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $table = 'avatars';

    protected $fillable = [
        'user_id',
        '_src'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
