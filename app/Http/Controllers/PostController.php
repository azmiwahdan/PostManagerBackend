<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\services\PostService;
use App\Models\Post;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function createPost()
    {
        return $this->postService->createPost(request());
    }

    public function getPostComments($postId)
    {
        return $this->postService->getPostComments($postId);
    }

    public function commentOnPost($postId)
    {
        return $this->postService->commentOnPost($postId, request());
    }

    public function replyToComment($commentId)
    {
        return $this->postService->replyToComment($commentId, request());
    }

    public function getCommentReplies($commentId)
    {
        return $this->postService->getCommentReplies($commentId);
    }

}
