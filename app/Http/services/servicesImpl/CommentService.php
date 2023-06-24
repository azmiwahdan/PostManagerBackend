<?php

namespace App\Http\Services\servicesImpl;

use App\Http\services\CrudServiceInterface;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class CommentService implements CrudServiceInterface
{
    public function update($commentId, Request $request)
    {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $user = Auth::user();

        if (!$this->isAuthorized($comment, $user)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'comment_text' => 'required'
        ]);

        $comment->comment_text = $validatedData['comment_text'];
        $comment->save();

        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => new CommentResource($comment)
        ]);
    }

    public function delete($commentId)
    {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $user = Auth::user();

        if (!$this->isAuthorized($comment, $user)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }

    private function isAuthorized($comment, $user)
    {
        $commentUserId = $comment->user_id;
        $postUserId = $comment->post->user_id;

        return $user->id === $commentUserId || $user->id === $postUserId;
    }
}
