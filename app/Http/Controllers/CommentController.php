<?php

namespace App\Http\Controllers;

use App\Http\Services\servicesImpl\CommentService;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function updateComment($commentId)
    {
        return $this->commentService->updateComment($commentId, Reuest());
    }

    public function deleteComment($commentId)
    {
        return $this->commentService->deleteComment($commentId);
    }
}
