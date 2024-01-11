<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OkvedController;
use App\Http\Controllers\Api\ReceiptUploaderController;
use App\Http\Controllers\UserTelegramController;
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


    // Route::get('receipt-upload/{id}', [ReceiptUploaderController::class, 'show']);
    // Route::post('receipt-upload', [ReceiptUploaderController::class, 'store']);
    Route::get('okved', [OkvedController::class, 'index']);

    Route::group([
        'prefix' => 'telegram'
    ], function () {
        Route::apiResource('user', UserTelegramController::class)->only(['store', 'show', 'destroy']);
    });
});
