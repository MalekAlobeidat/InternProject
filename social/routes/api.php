<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MalekController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ModeratorController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // Route::resource('posts', PostController::class);
Route::get('/posts/search/{title}', [PostController::class, 'search']);
Route::get('/post/author/{id}', [PostController::class, 'get_author']);
    return $request->user();
});

Route::post('/signup', [AuthController::class, 'sign_up']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
//////////////////////////

Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::post('/posts/{post}', [PostController::class, 'update']);
Route::delete('/posts/{post}', [PostController::class, 'destroy']);
///////////////////////////

Route::get('/comments', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store']);
Route::get('/comments/{comment}', [CommentController::class, 'show']);
Route::put('/comments/{comment}', [CommentController::class, 'update']);
Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

///////////////////////////////////
Route::post('/like', [LikeController::class, 'like']);
Route::delete('/unlike', [LikeController::class, 'unlike']);





Route::post('/friendRequest',[MalekController::class,'friendRequest']);
// Route::post('/respond',[MalekController::class,'respond']);
Route::post('/test',[MalekController::class,'test']);

Route::post('/updateUser/{id}',[MalekController::class,'updateUser']);
Route::get('/friendsPosts/{id}',[MalekController::class,'friendsPosts']);
Route::get('/getUserPostsAndInteractions/{id}',[MalekController::class,'getUserPostsAndInteractions']);
Route::get('/getUserAndFriendsPosts/{id}',[MalekController::class,'getUserAndFriendsPosts']);






// route for creating report from user
Route::post('/reports/{UserID}/{PostID}', [ReportController::class, 'makeReport']);
// route for handling moderator response on reports
Route::get('/reports', [ModeratorController::class, 'reports']);
Route::get('/reports/{PostID}', [ModeratorController::class, 'showReport']);
Route::delete('/reports/{PostID}', [ModeratorController::class, 'deleteReport']);
Route::put('/reports/{PostID}/accept', [ModeratorController::class, 'acceptReport']);
// analytic routes
Route::get('/analytics/likes', [AnalyticsController::class, 'getLikes']);
Route::get('/analytics/comments', [AnalyticsController::class, 'getComments']);
Route::get('/analytics/report', [AnalyticsController::class, 'analyticsReport']);
// routes for creating, updating, deleting user
Route::post('/', [UserController::class, 'createUser']);
Route::put('/{id}', [UserController::class, 'updateUser']);
Route::delete('/{id}', [UserController::class, 'deleteUser']);
