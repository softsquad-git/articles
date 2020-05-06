<?php

namespace App\Models\Users\Groups;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UsersGroup extends Model
{
    protected $table = 'groups_users';

    protected $fillable = [
        'user_id',
        'group_id',
        'is_admin',
        'status',
        'is_author'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
