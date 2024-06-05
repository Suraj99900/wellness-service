<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\VideoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Root route
Route::get('/', function () {
    return view('welcome');
});

// API routes with middleware
Route::prefix('api')->middleware('ensure.token.is.valid')->group(function () {
    // User Register and Login
    Route::get('login', [UserController::class, 'login']);
    Route::post('users', [UserController::class, 'addUser']);

    Route::put('password', [UserController::class, 'updatePassword']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);

    // Email route
    Route::post('email', [EmailController::class, 'generateMail']);

    // Video upload
    Route::post('video', [VideoController::class, 'upload']);
    
    // Fetch video by ID
    Route::get('video/{id}', [VideoController::class, 'fetchById']);
    
    // Fetch all videos
    Route::get('videos', [VideoController::class, 'fetchAll']);
    
    // Fetch all videos with pagination
    Route::get('videos/paginated', [VideoController::class, 'fetchAllWithPagination']);
    
    // Search videos by title
    Route::get('videos/search', [VideoController::class, 'searchByTitle']);
    
    // Update video by ID
    Route::put('video/{id}', [VideoController::class, 'update']);
    
    // Delete video by ID
    Route::delete('video/{id}', [VideoController::class, 'destroy']);
    
    // Stream video
    Route::get('/stream/{id}', [VideoController::class, 'stream']);
});
