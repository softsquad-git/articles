<?php

namespace App\Services\Comments;

use App\Models\Comments\Comment;
use App\Repositories\Comments\CommentRepository;
use Illuminate\Support\Facades\Auth;
use \Exception;

class CommentService
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
     * @param array $data
     * @return Comment
     * @throws Exception
     */
    public function store(array $data): Comment
    {
        $data['user_id'] = Auth::id();
        $item = Comment::create($data);
        if (empty($item))
            throw new Exception(sprintf('Refresh page and try again'));
        return $item;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Comment
     * @throws Exception
     */
    public function update(array $data, int $id): Comment
    {
        $item = $this->commentRepository->findComment($id);
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
        $item = $this->commentRepository->findComment($id);
        return $item->delete();
    }

}
