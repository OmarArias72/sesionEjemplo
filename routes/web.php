<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Panel de ADMINISTRADOR
Route::middleware(['auth', CheckRole::class . ':administrador'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin-dashboard');
    })->name('admin-dashboard');
});

// Panel de USUARIO ESTÁNDAR
Route::middleware(['auth', CheckRole::class . ':usuario_estandar'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user-dashboard');
    })->name('user-dashboard');
});

require __DIR__.'/auth.php';
