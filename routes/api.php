<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BugController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;

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

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{id}', [ProjectController::class, 'show']);
// Route::get('/projects/{id}/bugs', [ProjectController::class, 'bugs']);
Route::get('/projects/search/{name}', [ProjectController::class, 'search']);

Route::post('/bugs', [BugController::class, 'store']);
Route::put('/bugs/{id}', [BugController::class, 'update']);
Route::delete('/bugs/{id}', [BugController::class, 'destroy']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class], 'destroy');
});

// If you want to protect individual routes
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
