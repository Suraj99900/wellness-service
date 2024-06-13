<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoCategoryController;
use App\http\Controllers\AttachmentController;

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
    Route::get('videos-category/{id}', [VideoController::class, 'fetchAllVideoDataByCategoryId']);

    // Fetch all videos with pagination
    Route::get('videos/paginated', [VideoController::class, 'fetchAllWithPagination']);

    // Search videos by title
    Route::get('videos/search', [VideoController::class, 'searchByTitle']);

    // Update video by ID
    Route::put('video/{id}', [VideoController::class, 'update']);

    // Delete video by ID
    Route::delete('video/{id}', [VideoController::class, 'destroy']);

    // Stream video
    Route::get('stream/{id}', [VideoController::class, 'stream']);
    Route::get('thumbnail/{id}', [VideoController::class, 'thumbnailImages']);

    // Add a new video category
    Route::post('video-category', [VideoCategoryController::class, 'addCategory']);

    // Get all video categories
    Route::get('video-categories', [VideoCategoryController::class, 'getAllCategories']);

    // Get a single video category by ID
    Route::get('video-category/{id}', [VideoCategoryController::class, 'getCategoryById']);

    // Update a video category by ID
    Route::put('video-category/{id}', [VideoCategoryController::class, 'updateCategory']);

    // Delete a video category by ID
    Route::delete('video-category/{id}', [VideoCategoryController::class, 'deleteCategory']);

    // Attachment route
    Route::post('attachment',[AttachmentController::class,'addAttchment']);
    Route::get('video-attachment/{id}',[AttachmentController::class,'fetchAllAttachmentByVideoId']);
    Route::delete('attachment/{id}',[AttachmentController::class,'removedAttchment']);

});
