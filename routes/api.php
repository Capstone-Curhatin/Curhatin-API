<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoryController;

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

// sanctum -> api
Route::middleware(['auth:sanctum'])->group(function (){
    // User
    Route::get('fetch', [UserController::class, 'fetch']);
    Route::post('update', [UserController::class, 'update']);
    Route::post('update_doctor', [UserController::class, 'updateDoctor']);
    Route::post('update_fcm', [UserController::class, 'updateFCMToken']);
    Route::post('logout', [UserController::class, 'logout']);

    // category
    Route::get('getAllCategory', [CategoryController::class, 'getAllCategory']);

    // story
    Route::post('createStory', [StoryController::class, 'createStory']);
    Route::get('getAllStory', [StoryController::class, 'getAllStory']);
    Route::get('getStoryByCategory', [StoryController::class, 'getStoryByCategory']);
    Route::get('getStoryByUser', [StoryController::class, 'getStoryByUser']);
    Route::delete('deleteStory', [StoryController::class, 'deleteStory']);
});

Route::withoutMiddleware('auth:api')->group(function() {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::get('request_otp', [UserController::class, 'requestOtp']);
    Route::post('verify_otp', [UserController::class, 'verifyOtp']);
    Route::post('new_password', [UserController::class, 'newPassword']);
    Route::post('user_verification', [UserController::class, 'userVerification']);

});
