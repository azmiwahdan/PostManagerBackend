<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'getAllUsers']);
        Route::get('/{userId}', [UserController::class, 'getUserById']);
        Route::put('/{userId}', [UserController::class, 'updateUser']);
        Route::get('/{userId}', [UserController::class, 'deleteUser']);
    });
    Route::prefix('/posts')->group(function () {
        Route::post('/', [PostController::class, 'createPost']);
        Route::put('/{postId}', [PostController::class, 'updatePost']);
        Route::delete('/{postId}', [PostController::class, 'deletePost']);
        Route::get('/{postId}/comments', [PostCommentController::class, 'getPostComments']);
        Route::Post('/{postId}/comments', [PostCommentController::class, 'commentOnPost']);
        Route::post('/comments/{commentId}/replies', [PostCommentController::class, 'replyToComment']);
        Route::get('/comments/{commentId}/replies', [PostCommentController::class, 'getCommentReplies']);
    });
    Route::prefix('/comments')->group(function () {
        Route::patch('/{commentId}', [CommentController::class, 'updateComment']);
        Route::delete('/{commentId}', [CommentController::class, 'deleteComment']);
    });
});

//public routers
Route::prefix('users')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
});
