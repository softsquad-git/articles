<?php

namespace App\Models\Users\Groups;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PostsGroupImages extends Model
{
    protected $table = 'groups_posts_images';

    protected $fillable = [
        'user_id',
        'group_id',
        'src',
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
