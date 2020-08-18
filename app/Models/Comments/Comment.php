<?php

namespace App\Models\Comments;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'user_id',
        'resource_id',
        'resource_type',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(ReplyComment::class, 'comment_id');
    }
}
