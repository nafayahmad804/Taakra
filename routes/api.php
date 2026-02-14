<?php

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CompetitionController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/chat', [ChatController::class, 'sendMessage']);
    Route::get('/chat/history', [ChatController::class, 'getHistory']);
    Route::post('/chat/connect-support', [ChatController::class, 'connectToSupport']);

    Route::get('/competitions/calendar', [CompetitionController::class, 'calendar']);
});
