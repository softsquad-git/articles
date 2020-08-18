<?php

namespace App\Repositories\Comments;

use App\Models\Comments\ReplyComment;
use \Exception;

class ReplyCommentRepository
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function getAnswersComment(int $id)
    {
        $comment = $this->commentRepository->findComment($id);
        if (empty($comment))
            throw new \Exception(sprintf('Comment not found'));
        return ReplyComment::where('comment_id', $id)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function findReplyComment(int $id)
    {
        $reply = ReplyComment::find($id);
        if (empty($reply))
            throw new Exception('Reply not found');
        return $reply;
    }

}
