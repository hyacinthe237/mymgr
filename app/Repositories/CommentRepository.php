<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Traits\BaseRepository;

class CommentRepository
{
    use BaseRepository;

    /**
     * @var Comment
     */
    protected $model;
    protected $baseUrl;

    /**
     * CommentRepository constructor.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
        $this->baseUrl = 'comment';
    }

    public function getByProjectId($id)
    {
        return $this->model
                    ->where('commentable_id', $id)
                    ->where('commentable_type', 'App\Models\Project')
                    ->get();
    }

    public function getByTicketId($id)
    {
        return $this->model
                    ->where('commentable_id', $id)
                    ->where('commentable_type', 'App\Models\Ticket')
                    ->get();
    }
    public function delete($code)
    {
       $this->model = $this->getByCode($code);
       $this->model
            ->owner
            ->comments()
            ->detach($this->model->id);
       $this->model->delete();

       return $this->model;
    }
}
