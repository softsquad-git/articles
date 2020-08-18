<?php

namespace App\Observer\Comments;

use App\Models\Comments\Comment;

class CommentsObserve
{

    public function deleting(Comment $comment)
    {
        $comment->answers()->delete();
    }

}
