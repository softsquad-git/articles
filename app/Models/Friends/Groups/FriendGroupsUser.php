<?php

namespace App\Models\Friends\Groups;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FriendGroupsUser extends Model
{
    protected $table = 'friendship_groups_users';

    protected $fillable = [
        'user_id',
        'group_id',
        'is_admin',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(FriendGroups::class);
    }
}
