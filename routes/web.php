<?php

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


Route::group(['middleware' => 'auth:sanctum', 'prefix'=>'tasks', 'as'=>'tasks.'], function () {
   Route::get('/tasks', [TaskController::class, 'index'])->name('index');
   Route::get('/task/search', [TaskController::class, 'search'])->name('search');
    Route::post('/tasks', [TaskController::class, 'store'])->name('store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('show');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('update');
    Route::delete('/tasks/delete/{task}',[TaskController::class,'deleteTask'])->name('delete');
});
