<?php

namespace App\Http\services\servicesImpl;

use App\Http\Resources\PostResource;
use App\Http\services\CrudServiceInterface;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class PostService implements CrudServiceInterface
{
    protected function authorizeUser(Post $post): bool
    {
        $user = Auth::user();

        return $user->id === $post->user_id;
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'post_text' => 'required'
        ]);

        $user = $this->authService->retrieveAuthenticatedUser();

        $post = new Post;
        $post->post_text = $validatedData['post_text'];
        $post->user_id = $user->id;
        $post->comment_status = $request->input('comment_status', 'opened');
        $post->save();

        return response()->json([
            'message' => 'Post created successfully',
            'post' => new PostResource($post)
        ], 201);
    }

    public function update(int $id, Request $request)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found!'], 404);
        }

        if (!$this->authorizeUser($post)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'post_text' => 'required',
            'comment_status' => 'in:opened,closed'
        ]);

        $post->post_text = $validatedData['post_text'];
        $post->comment_status = $validatedData['comment_status'];
        $post->save();

        return response()->json(['message' => 'Post updated successfully']);
    }

    public function delete(int $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found!'], 404);
        }
        if (!$this->authorizeUser($post)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
