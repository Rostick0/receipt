<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OkvedController;
use App\Http\Controllers\Api\ReceiptUploaderController;
use App\Http\Controllers\Telegram\ReceiptUploaderController as TelegramReceiptUploaderController;
use App\Http\Controllers\Telegram\UserTelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => [
        'api',
    ],

], function () {
    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::post('login', [AuthController::class, 'login']);

        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::get('me', [AuthController::class, 'me']);
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::apiResource('receipt-upload', ReceiptUploaderController::class)->only(['store']);
    });

    Route::apiResource('receipt-upload', ReceiptUploaderController::class)->only(['show']);

    Route::get('okved', [OkvedController::class, 'index']);

    Route::group([
        'prefix' => 'telegram',
        'middleware' => 'telegram.token'
    ], function () {
        Route::apiResource('user', UserTelegramController::class)->only(['store', 'destroy']);

        Route::apiResource('receipt-upload', TelegramReceiptUploaderController::class)->only(['store']);
        Route::get('receipt-upload', [TelegramReceiptUploaderController::class, 'me']);

        // Route::post('receipt-upload', [ReceiptUploaderController::class, 'store']);
    });
});
