<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FolderReceiptController;
use App\Http\Controllers\OkvedController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'guest'], function ($router) {
    Route::view('/login', 'pages.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::view('/register', 'pages.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'admin'], function () {
        // Route::resource('okved', OkvedController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
        // Route::group(['prefix' => 'receipt'], function () {
        //     Route::get('/trash', [ReceiptController::class, 'trash'])->name('receipt.trash');
        //     Route::patch('/restore/{id}', [ReceiptController::class, 'restore'])->name('receipt.restore');
        //     Route::delete('/trash/{id}', [ReceiptController::class, 'forceDelete'])->name('receipt.forceDelete');
        // });
    });

    Route::get('/', [ReceiptController::class, 'index']);

    Route::group(['prefix' => 'receipt'], function () {
        Route::get('/trash', [ReceiptController::class, 'trash'])->name('receipt.trash');
        Route::patch('/restore/{id}', [ReceiptController::class, 'restore'])->name('receipt.restore');
        Route::delete('/trash/{id}', [ReceiptController::class, 'forceDelete'])->name('receipt.forceDelete');
        Route::delete('/trash-duplicate', [ReceiptController::class, 'removeDuplicate'])->name('receipt.removeDuplicate');
        Route::delete('/trash-clear', [ReceiptController::class, 'clearRemoved'])->name('receipt.clearRemoved');
        // clearTrash
    });
    Route::group(['prefix' => 'folder'], function () {
        Route::get('/trash', [FolderController::class, 'trash'])->name('folder.trash');
        Route::patch('/restore/{id}', [FolderController::class, 'restore'])->name('folder.restore');
        Route::delete('/trash/{id}', [FolderController::class, 'forceDelete'])->name('folder.forceDelete');
    });

    Route::resource('product', ProductController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('folder-receipt', FolderReceiptController::class)->only(['update']);

    Route::resources([
        'receipt' => ReceiptController::class,
        'okved' => OkvedController::class,
        'folder' => FolderController::class,
    ]);

    Route::delete('/folder-clear/{id}', [FolderController::class, 'clear'])->name('folder.clear');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
