<?php

namespace App\Http\Controllers;

use App\Http\services\servicesImpl\PostCommentService;

class PostCommentController extends Controller
{
    protected $postCommentService;

    public function __construct(PostCommentService $postService)
    {
        $this->postCommentService = $postService;
    }

    public function getPostComments($postId)
    {
        return $this->postCommentService->getPostComments($postId);
    }

    public function commentOnPost($postId)
    {
        return $this->postCommentService->commentOnPost($postId, request());
    }

    public function replyToComment($commentId)
    {
        return $this->postCommentService->replyToComment($commentId, request());
    }

    public function getCommentReplies($commentId)
    {
        return $this->postCommentService->getCommentReplies($commentId);
    }
}
