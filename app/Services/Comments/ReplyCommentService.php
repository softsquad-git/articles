<?php

namespace App\Services\Comments;

use App\Models\Comments\ReplyComment;
use App\Repositories\Comments\ReplyCommentRepository;
use Illuminate\Support\Facades\Auth;
use \Exception;

class ReplyCommentService
{
    /**
     * @var ReplyCommentRepository
     */
    private $replyCommentRepository;

    /**
     * @param ReplyCommentRepository $replyCommentRepository
     */
    public function __construct(ReplyCommentRepository $replyCommentRepository)
    {
        $this->replyCommentRepository = $replyCommentRepository;
    }

    /**
     * @param array $data
     * @return ReplyComment
     * @throws Exception
     */
    public function store(array $data): ReplyComment
    {
        $parent_id = $data['parent_id'];
        if (empty($parent_id))
            $parent_id = 0;
        $data['parent_id'] = $parent_id;
        $data['user_id'] = Auth::id();
        $item = ReplyComment::create($data);
        if (empty($item))
            throw new Exception('Try again');
        return $item;
    }

    /**
     * @param array $data
     * @param int $id
     * @return ReplyComment
     * @throws Exception
     */
    public function update(array $data, int $id): ReplyComment
    {
        $item = $this->replyCommentRepository->findReplyComment($id);
        $item->update($data);
        return $item;
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws Exception
     */
    public function remove(int $id): ?bool
    {
        $item = $this->replyCommentRepository->findReplyComment($id);
        return $item->delete();
    }

}
