<?php

namespace App\Models\Friends\Groups;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FriendGroups extends Model
{
    protected $table = 'friendship_groups';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'type',
        'status',
        'is_accept_post',
        'is_view'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
