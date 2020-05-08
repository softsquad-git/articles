<?php

namespace App\Models\Users\Groups;

use App\Models\Comments\Comment;
use App\Models\Likes\Like;
use App\Services\User\Groups\GroupsPostsService;
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

    public function images()
    {
        return $this->hasMany(PostsGroupImages::class, 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'resource_id', 'id')
            ->where('resource_type', GroupsPostsService::RESOURCE_TYPE);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'resource_id', 'id')
            ->where('resource_type', GroupsPostsService::RESOURCE_TYPE);
    }
}
