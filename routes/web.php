<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TvShowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/tv-shows', [TvShowController::class, 'index'])->name('tvshows.index');
Route::get('/tv-shows/{id}', [TvShowController::class, 'show'])->name('tvshows.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites/check', [FavoriteController::class, 'check'])->name('favorites.check');
    Route::middleware(['is_admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
});

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::prefix('comments')->group(function () {
    Route::get('/', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
});

require __DIR__.'/auth.php';
