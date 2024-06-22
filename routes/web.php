<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StudioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/update-phone', [ProfileController::class, 'updatePhone'])->name('profile.update-phone');
});

require __DIR__ . '/auth.php';


// User Routes
Route::middleware(['auth', 'userMiddleware', 'verified'])->group(function () {

    Route::get('daftarstudio', [UserController::class, 'daftar'])->name('daftarstudio');
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('studios/{id}', [UserController::class, 'show'])->name('studios.show');
    Route::post('/studios/{studioId}/book', [StudioController::class, 'book'])->name('studios.book');
});

// Admin Routes
Route::middleware(['auth', 'adminMiddleware'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/studios', [StudioController::class, 'store'])->name('studios.store');
    Route::post('/studios/{studioId}/time-slots', [StudioController::class, 'storeTime'])->name('studios.time-slots.store');
    Route::get('/admin/after-input', [StudioController::class, 'index'])->name('studios.afterinput');
    Route::get('/studios/{id}/edit', [StudioController::class, 'edit'])->name('studios.edit');
    Route::put('/studios/{id}', [StudioController::class, 'update'])->name('studios.update');
    Route::delete('/studios/{id}', [StudioController::class, 'destroy'])->name('studios.destroy');
    Route::resource('studios', StudioController::class);
});
