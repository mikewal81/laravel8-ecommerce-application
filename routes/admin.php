<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['prefix' => 'admin'], function() {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login.post');
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

   /* Route::group(['middleware' => ['auth:admin']], function() {
        Route::get('/', function() {
            return view('admin.dashboard.index');
        })->name('admin.dashboard');
    }); */

    Route::get('/', function() {
        return view('admin.dashboard.index');
    })->name('admin.dashboard');
    Route::group(['prefix' => 'settings'], function() {
        Route::get('/', [SettingController::class, 'index'])->name('admin.settings');
        Route::post('/', [SettingController::class, 'update'])->name('admin.settings.update');
    });
    Route::group(['prefix' => 'categories'], function() {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::post('/update', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::get('/{id}/delete', [CategoryController::class, 'delete'])->name('admin.categories.delete');
        Route::get('/deleted', [CategoryController::class, 'deleted'])->name('admin.categories.deleted');
        Route::get('/{id}/restore', [CategoryController::class, 'restore'])->name('admin.categories.restore');
        Route::get('/{id}/delete-permanently', [CategoryController::class, 'permanentDelete'])->name('admin.categories.permanentDelete');
    });
});
