<?php

namespace App\Models\Comments;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ReplyComment extends Model
{
    protected $table = 'answers_comment';

    protected $fillable = [
        'user_id',
        'comment_id',
        'content',
        'parent_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
