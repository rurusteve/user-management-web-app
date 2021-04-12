<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\{LoginController, EmailVerificationController, PasswordResetController, UsersController};


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
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::prefix('users')->name('users.')->group(function () {
    Route::get('all', [UsersController::class, 'index'])->name('index');
    Route::post('add', [UsersController::class, 'create'])->name('create');
    Route::get('detail/{id}', [UsersController::class, 'show'])->name('show');
    Route::put('edit/{id}', [UsersController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [UsersController::class, 'destroy'])->name('destroy');
});
