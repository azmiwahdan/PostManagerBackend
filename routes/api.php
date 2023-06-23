<?php

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
    Route::prefix('/posts')->group(function () {
        Route::post('/', [PostController::class, 'createPost']);
        Route::get('/{postId}/comments', [PostController::class, 'getPostComments']);
        Route::Post('/{postId}/comments', [PostController::class, 'commentOnPost']);
        Route::post('/comments/{commentId}/replies', [PostController::class, 'replyToComment']);
        Route::get('/comments/{commentId}/replies', [PostController::class, 'getCommentReplies']);

    });
});

//public routers
Route::prefix('users')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
});
