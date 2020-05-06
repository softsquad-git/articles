<?php

namespace App\Models\Users\Groups;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PostsGroup extends Model
{
    protected $table = 'groups_posts';

    protected $fillable = [
        'user_id',
        'group_id',
        'content',
        'status'
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
