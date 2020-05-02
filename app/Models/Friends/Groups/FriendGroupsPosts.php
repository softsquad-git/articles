<?php

namespace App\Models\Friends\Groups;

use App\Models\Likes\Like;
use App\Services\User\Friends\Groups\GroupPostsService;
use App\User;
use Illuminate\Database\Eloquent\Model;

class FriendGroupsPosts extends Model
{
    protected $table = 'friendship_groups_posts';

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
        return $this->belongsTo(FriendGroups::class);
    }

    public function likes(){
        return $this->hasMany(Like::class, 'resource_id', 'id')
            ->where('resource_type', GroupPostsService::RESOURCE_TYPE);
    }
}
