<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ProfessorController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\AnnouncementController;

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
Route::middleware('auth:sanctum')->get('/professor', function (Request $request) {
    return $request->professor();
});



//User Routes
Route::apiResource('users', UserController::class);
Route::post('users/login',[UserController::class, 'login']);

Route::post('/users/course',[UserController::class, 'attach']);
Route::post('/users/course/detach',[UserController::class, 'detach']);
Route::post('/users/forgottenPasswordValidation',[UserController::class, 'forgottenPasswordValidation']);


//Professor Routes
Route::apiResource('professors', ProfessorController::class)/* ->middleware(Authenticate::class) */;
Route::post('professors/login',[ProfessorController::class, 'login']);


//Course Routes
Route::apiResource('courses', CourseController::class);
Route::post('/courses/users',[CourseController::class, 'users']);


//Unit Routes
Route::apiResource('units', UnitController::class);
Route::post('/uploadsByUser',[UnitController::class, 'getUploadsByUser']);
Route::post('/postUpload',[UnitController::class, 'postUpload']);

//Message Routes
Route::apiResource('messages', MessageController::class);
Route::post('/messages/forum',[MessageController::class, 'getMessagesByForum']);

//Event Routes
Route::apiResource('events', EventController::class);
Route::post('/events/user',[EventController::class, 'getEventsByUser']);

//Announcement Routes
Route::apiResource('announcements', AnnouncementController::class);
Route::post('/announcements/course',[AnnouncementController::class, 'getAnnouncementsByCourse']);






