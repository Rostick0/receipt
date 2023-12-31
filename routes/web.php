<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', [ReceiptController::class, 'index']);

Route::group(['middleware' => 'guest'], function ($router) {
    Route::view('/login', 'pages.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::view('/register', 'pages.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::resource('receipt', ReceiptController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
Route::resource('product', ProductController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);

Route::resource('okved', OkvedController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'admin'], function () {
        // Route::resource('okved', OkvedController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    });

    // Route::resource('receipt', ReceiptController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);;

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
