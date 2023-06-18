<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/levels', [\App\Http\Controllers\LevelController::class, 'index'])->middleware(['auth', 'verified'])->name('levels');
Route::get('/dashboard/levels/toevoegen', [\App\Http\Controllers\LevelController::class, 'create'])->middleware(['auth', 'verified'])->name('addLevel');
Route::post('/dashboard/levels', [\App\Http\Controllers\LevelController::class, 'store'])->middleware(['auth', 'verified'])->name('storeLevel');
Route::get('/dashboard/levels/{level}/bewerken', [\App\Http\Controllers\LevelController::class, 'edit'])->middleware(['auth', 'verified'])->name('editLevel');
Route::put('/dashboard/levels/{level}', [\App\Http\Controllers\LevelController::class, 'save'])->middleware(['auth', 'verified'])->name('saveLevel');
Route::delete('/dashboard/levels/{level}', [\App\Http\Controllers\LevelController::class, 'destroy'])->middleware(['auth', 'verified'])->name('deleteLevel');

Route::get('/dashboard/varianten', [\App\Http\Controllers\VariantController::class, 'index'])->middleware(['auth', 'verified'])->name('variants');
Route::get('/dashboard/varianten/toevoegen', [\App\Http\Controllers\VariantController::class, 'create'])->middleware(['auth', 'verified'])->name('addVariant');
Route::get('/dashboard/varianten/{variant}/bewerken', [\App\Http\Controllers\VariantController::class, 'edit'])->middleware(['auth', 'verified'])->name('editVariant');
Route::put('/dashboard/varianten/{variant}', [\App\Http\Controllers\VariantController::class, 'save'])->middleware(['auth', 'verified'])->name('saveVariant');
Route::delete('/dashboard/varianten/{variant}', [\App\Http\Controllers\VariantController::class, 'destroy'])->middleware(['auth', 'verified'])->name('deleteVariant');
Route::post('/dashboard/varianten', [\App\Http\Controllers\VariantController::class, 'store'])->middleware(['auth', 'verified'])->name('storeVariant');

Route::get('/dashboard/hints', [\App\Http\Controllers\HintController::class, 'index'])->middleware(['auth', 'verified'])->name('hints');
Route::get('/dashboard/hints/toevoegen', [\App\Http\Controllers\HintController::class, 'create'])->middleware(['auth', 'verified'])->name('addHint');
Route::post('/dashboard/hints', [\App\Http\Controllers\HintController::class, 'store'])->middleware(['auth', 'verified'])->name('storeHint');
Route::get('/dashboard/hints/{hint}/bewerken', [\App\Http\Controllers\HintController::class, 'edit'])->middleware(['auth', 'verified'])->name('editHint');
Route::put('/dashboard/hints/{hint}', [\App\Http\Controllers\HintController::class, 'save'])->middleware(['auth', 'verified'])->name('saveHint');
Route::delete('/dashboard/hints/{hint}', [\App\Http\Controllers\HintController::class, 'destroy'])->middleware(['auth', 'verified'])->name('deleteHint');

Route::get('/dashboard/users', [\App\Http\Controllers\UserController::class, 'index'])->middleware(['auth', 'verified'])->name('users');
Route::get('/dashboard/users/toevoegen', [\App\Http\Controllers\UserController::class, 'create'])->middleware(['auth', 'verified'])->name('addUser');
Route::post('/dashboard/users', [\App\Http\Controllers\UserController::class, 'store'])->middleware(['auth', 'verified'])->name('storeUser');
Route::delete('/dashboard/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->middleware(['auth', 'verified'])->name('deleteUser');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
