<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BugController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProjectUserController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
Route::get('/projects/search/{name}', [ProjectController::class, 'search']);

Route::get('/users/{id}', [UserController::class, 'show']);

Route::get('projects/{project_id}/users/{user_id}', [ProjectUserController::class, 'show']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class], 'destroy');

    Route::post('projects/{project_id}/users/{user_id}', [ProjectUserController::class, 'store']);
    Route::put('projects/{project_id}/users/{user_id}', [ProjectUserController::class, 'update']);
    Route::delete('projects/{project_id}/users/{user_id}', [ProjectUserController::class, 'destroy']);

    Route::post('/bugs', [BugController::class, 'store']);
    Route::put('/bugs/{id}', [BugController::class, 'update']);
    Route::delete('/bugs/{id}', [BugController::class, 'destroy']);
});

// If you want to protect individual routes
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
