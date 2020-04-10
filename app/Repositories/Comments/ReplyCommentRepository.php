<?php

namespace App\Repositories\Comments;

use App\Models\Comments\ReplyComment;

class ReplyCommentRepository
{

    public function items(int $id)
    {
        return ReplyComment::where('comment_id', $id)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    }

    public function find($id)
    {
        return ReplyComment::find($id);
    }

}
