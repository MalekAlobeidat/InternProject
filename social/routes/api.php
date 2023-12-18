<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Api\MalekController;
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
    return $request->user();
});
Route::post('/friendRequest',[MalekController::class,'friendRequest']);
Route::post('/respondToFriendRequest',[MalekController::class,'respondToFriendRequest']);
Route::post('/updateUser/{id}',[MalekController::class,'updateUser']);

// route for creating report from user
Route::post('/reports/{UserID}/{PostID}', [ReportController::class, 'makeReport']);
// route for handling moderator response on reports
Route::get('/reports', [ModeratorController::class, 'reports']);
Route::get('/reports/{ReporID}', [ModeratorController::class, 'showReport']);
Route::delete('/reports/{ReporID}', [ModeratorController::class, 'deleteReport']);
Route::put('/reports/{ReporID}/accept', [ModeratorController::class, 'acceptReport']);
// analytic routes
Route::get('/analytics/likes', [AnalyticsController::class, 'getLikes']);
Route::get('/analytics/comments', [AnalyticsController::class, 'getComments']);
Route::get('/analytics/report', [AnalyticsController::class, 'analyticsReport']);
// routes for creating, updating, deleting user
Route::post('/', [UserController::class, 'createUser']);
Route::put('/{id}', [UserController::class, 'updateUser']);
Route::delete('/{id}', [UserController::class, 'deleteUser']);
