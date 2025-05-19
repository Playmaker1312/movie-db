<?php

use App\Models\Movie;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

// Route::get('/', function () {
//     return view('welcome');
// });

    Route::get('/', [MovieController::class, 'homepage'])->name('homepage');
