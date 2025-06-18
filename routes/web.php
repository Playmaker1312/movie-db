<?php

use App\Models\Movie;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [MovieController::class, 'homepage'])->name('homepage');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes that require CRUD permission
Route::middleware(['auth', 'crud.permission'])->group(function () {
    // Movie CRUD routes
    Route::get('/create-movies', [MovieController::class, 'create'])->name('create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/movies/{id}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{id}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/movies/{id}', [MovieController::class, 'destroy'])->name('movies.destroy');
    
    // Category CRUD routes
    Route::resource('categories', CategoryController::class);
});

// Public routes (no CRUD permission required)
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
