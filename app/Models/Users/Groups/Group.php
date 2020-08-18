<?php

namespace App\Models\Users\Groups;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name',
        'description',
        'bg_image',
        'type',
        'is_accept_post',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(UsersGroup::class, 'group_id');
    }

    public function posts()
    {
        return $this->hasMany(PostsGroup::class, 'group_id');
    }
}
