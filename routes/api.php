<?php

use App\Http\Controllers\ReceiptUploaderController;
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
    'middleware' => 'api',
], function () {
    Route::apiResource('receipt-upload', ReceiptUploaderController::class)->only(['show', 'store']);
    // Route::get('receipt-upload/{id}', [ReceiptUploaderController::class, 'show']);
    // Route::post('receipt-upload', [ReceiptUploaderController::class, 'store']);
});
