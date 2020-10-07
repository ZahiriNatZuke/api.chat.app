<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [ApiAuthController::class, 'register'])->name('register.auth.api');
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login.auth.api');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', [ApiAuthController::class, 'logout'])->name('logout.auth.api');
        Route::get('/user', [ApiAuthController::class, 'user'])->name('user.auth.api');
    });
});
Route::middleware('auth:sanctum')->prefix('message')->group(function () {
    Route::post('/send-public-msg', [MessageController::class, 'sendPublicMsg'])->name('sendPublicMsg.message.api');
    Route::post('/send-direct-msg', [MessageController::class, 'sendDirectMsg'])->name('sendDirectMsg.message.api');
    Route::post('/delete-msg', [MessageController::class, 'deleteMsg'])->name('deleteMsg.message.api');
});
