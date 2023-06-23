<?php

namespace App\Http\services;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;


class PostService
{
    protected $authService;

    public function __construct(LoginService $loginService)
    {
        $this->authService = $loginService;
    }

    public function createPost(Request $request)
    {
        $validateData = $request->validate([
            'post_text' => 'required'
        ]);
        $user = $this->authService->retrieveAuthenticatedUser();
        $post = new Post;
        $post->post_text = $request->post_text;
        $post->user_id = $user->id;
        $post->save();
        return response()->json([
            'message' => 'Post created successfully',
            'post' => new PostResource($post)],
            201);
    }

    public function getPostComments($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        $comments = $post->comments()->whereNull('parent_comment_id')->get();
        return CommentResource::collection($comments);
    }

    public function commentOnPost($postId, Request $request)
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['message' => 'post not found'], 404);
        }
        $user = $this->authService->retrieveAuthenticatedUser();
        $validatedData = $request->validate([
            'comment_text' => 'required'
        ]);
        $comment = new Comment;
        $comment->post_id = $postId;
        $comment->comment_text = $validatedData['comment_text'];
        $comment->user_id = $user->id;
        $comment->save();
        return response()->json([
            'message' => 'Comment created successfully',
            'comment' => new CommentResource($comment)],
            201);

    }

    public function replyToComment($commentId, Request $request)
    {
        $request->validate([
            'reply_text' => 'required',
        ]);
        $user = Auth::user();
        $parentComment = Comment::findOrFail($commentId);

        $reply = new Comment();
        $reply->comment_text = $request->reply_text;
        $reply->user_id = $user->id;
        $reply->post_id = $parentComment->post_id;
        $reply->parent_comment_id = $parentComment->id;
        $reply->save();

        return response()->json([
            'message' => 'Reply created successfully',
            'reply' => new CommentResource($reply),
        ], 201);
    }

    public function getCommentReplies($commentId)
    {
        $parentComment = Comment::findOrFail($commentId);
        $replies = $parentComment->replies;
        return response()->json([
            'replies' => CommentResource::collection($replies),
        ]);
    }
    //TODO : enum post privacy (public,only me)--do it

}
