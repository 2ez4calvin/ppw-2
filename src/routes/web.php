<?php

use App\Http\Controllers\StudioController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/busca', [HomeController::class, 'busca'])->name('busca.global');
Route::get('/filmes/{id}', [MovieController::class, 'indexPublico'])->name('filmePublico');
Route::get('/pessoas/{id}', [PersonController::class, 'indexPublico'])->name('pessoaPublico');

Route::get('/filmes/{id}/avaliacoes', [ReviewController::class, 'publicIndex']);
Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/persons/buscar', [PersonController::class, 'buscar'])
    ->middleware('auth')
    ->name('persons.buscar');

Route::prefix('/admin')->middleware('auth')->group(function () {
    
    Route::resource('generos', GenreController::class);
    Route::resource('estudios', StudioController::class);
    Route::resource('pessoas', PersonController::class);
    Route::resource('filmes', MovieController::class);
    Route::resource('reviews', ReviewController::class);

    Route::get('/', function () {
        return view('admin');
    })->name('admin');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';