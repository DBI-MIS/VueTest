<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function(){
Route::get('/todo', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/todo/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/todo', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/todo/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/todo/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/todo/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
