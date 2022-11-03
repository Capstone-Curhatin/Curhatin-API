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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::get('request_otp', [UserController::class, 'requestOtp']);
Route::post('verify_otp', [UserController::class, 'verifyOtp']);

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('fetch', [UserController::class, 'fetch']);

    // category
    Route::get('getAllCategory', [CategoryController::class, 'getAllCategory']);

    // story
    Route::post('createStory', [StoryController::class, 'createStory']);
    Route::get('getAllStory', [StoryController::class, 'getAllStory']);
});
