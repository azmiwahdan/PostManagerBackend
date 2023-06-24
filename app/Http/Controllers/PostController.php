<?php

namespace App\Http\Controllers;

use App\Http\services\servicesImpl\PostService;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class PostController
{
    protected PostService $postService;

    public function __construct(PostService $service)
    {
        $this->postService = $service;
    }

    public function createPost()
    {
        return $this->postService->create(Request());
    }

    public function updatePost($postId)
    {
        return $this->postService->update($postId, Request());
    }

    public function deletePost($postId)
    {
        return $this->postService->delete($postId);
    }
}
