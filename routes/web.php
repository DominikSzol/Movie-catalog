<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Rating;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('movies.index');
});


Route::get('top', [MovieController::class, 'top'])->name('movies.top');

Route::get('restore/{id}', [MovieController::class, 'restore'])->name('movies.restore');

Route::resource('movies', MovieController::class);

Route::resource('ratings', RatingController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
