<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FolderController;
use App\Http\Controllers\Api\FolderReceiptController;
use App\Http\Controllers\Api\OkvedController;
use App\Http\Controllers\Api\ReceiptController;
use App\Http\Controllers\Api\ReceiptUploaderController;
use App\Http\Controllers\Integration\ReceiptUploaderController as IntegrationReceiptUploaderController;
use App\Http\Controllers\Telegram\FolderController as TelegramFolderController;
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

Route::middleware('api')
    ->name('api.')
    ->group(function () {
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
            Route::post('receipt-upload', [ReceiptUploaderController::class, 'store'])->name('receipt-upload.site.store');

            Route::apiResource('folder', FolderController::class)->only(['index']);
            Route::apiResource('folder-receipt', FolderReceiptController::class)->only(['store', 'destroy']);
        });

        Route::apiResource('receipt', ReceiptController::class)->only(['index']);
        Route::apiResource('receipt-upload', ReceiptUploaderController::class)->only(['index', 'show']);

        Route::get('okved', [OkvedController::class, 'index']);

        Route::group([
            'prefix' => 'telegram',
            'middleware' => 'telegram.token'
        ], function () {
            Route::get('user/me/{telegram_user_id}', [UserTelegramController::class, 'me']);
            Route::apiResource('user', UserTelegramController::class)->only(['store', 'destroy']);

            Route::apiResource('receipt-upload', TelegramReceiptUploaderController::class)->only(['store']);
            Route::apiResource('folder', TelegramFolderController::class)->only(['store']);

            // Route::post('receipt-upload', [ReceiptUploaderController::class, 'store']);
        });

        Route::group([
            'prefix' => 'integration',
            'middleware' => 'integration.token'
        ], function () {
            Route::post('receipt-upload', [IntegrationReceiptUploaderController::class, 'store']);
        });
    });
