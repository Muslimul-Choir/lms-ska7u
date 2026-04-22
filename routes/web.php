<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\SemesterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bagian Routes
    Route::get('bagian/trash', [BagianController::class, 'trash'])->name('bagian.trash');
    Route::patch('bagian/trash/{id}/restore', [BagianController::class, 'restore'])->name('bagian.restore');
    Route::delete('bagian/trash/{id}/force-delete', [BagianController::class, 'forceDelete'])->name('bagian.force-delete');
    Route::resource('bagian', BagianController::class);

    // Jurusan Routes
    Route::get('jurusan/trash', [JurusanController::class, 'trash'])->name('jurusan.trash');
    Route::patch('jurusan/trash/{id}/restore', [JurusanController::class, 'restore'])->name('jurusan.restore');
    Route::delete('jurusan/trash/{id}/force-delete', [JurusanController::class, 'forceDelete'])->name('jurusan.force-delete');
    Route::resource('jurusan', JurusanController::class);

    // Semester Routes
    Route::get('semester/trash', [SemesterController::class, 'trash'])->name('semester.trash');
    Route::patch('semester/trash/{id}/restore', [SemesterController::class, 'restore'])->name('semester.restore');
    Route::delete('semester/trash/{id}/force-delete', [SemesterController::class, 'forceDelete'])->name('semester.force-delete');
    Route::resource('semester', SemesterController::class);
});

require __DIR__.'/auth.php';