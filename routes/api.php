<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ProfessorController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\EventController;

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


//Professor Routes
Route::apiResource('professors', ProfessorController::class);
Route::post('professors/login',[ProfessorController::class, 'login']);


//Course Routes
Route::apiResource('courses', CourseController::class);
Route::post('/courses/users',[CourseController::class, 'users']);


//Unit Routes
Route::apiResource('units', UnitController::class);
Route::get('/unitsByCourse/{courseId}',[UnitController::class, 'getUnitsByCourse']); //borrar¿?

//Message Routes
Route::apiResource('messages', MessageController::class);
Route::post('/messages/forum',[MessageController::class, 'getMessagesByForum']);

//Event Routes
Route::apiResource('events', EventController::class);
Route::post('/events/user',[EventController::class, 'getEventsByUser']);




