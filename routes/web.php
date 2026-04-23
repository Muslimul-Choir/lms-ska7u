<?php

use App\Http\Controllers\BagianController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\TingkatanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
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

    // Tahun Ajaran Routes
    Route::get('tahunajaran/trash', [TahunAjaranController::class, 'trash'])->name('tahunajaran.trash');
    Route::patch('tahunajaran/trash/{id}/restore', [TahunAjaranController::class, 'restore'])->name('tahunajaran.restore');
    Route::delete('tahunajaran/trash/{id}/force-delete', [TahunAjaranController::class, 'forceDelete'])->name('tahunajaran.force-delete');
    Route::resource('tahunajaran', TahunAjaranController::class);

    // Tingkatan Routes
    Route::get('tingkatan/trash', [TingkatanController::class, 'trash'])->name('tingkatan.trash');
    Route::patch('tingkatan/trash/{id}/restore', [TingkatanController::class, 'restore'])->name('tingkatan.restore');
    Route::delete('tingkatan/trash/{id}/force-delete', [TingkatanController::class, 'forceDelete'])->name('tingkatan.force-delete');
    Route::resource('tingkatan', TingkatanController::class);

    // mapel 
    Route::resource('mapel', MapelController::class);

    // kelas
    Route::prefix('kelas')->name('kelas.')->controller(KelasController::class)->group(function () {
    Route::get('/',          [KelasController::class, 'index'])->name('index');
    Route::post('/',         [KelasController::class, 'store'])->name('store');
    Route::get('/{kelas}/edit', [KelasController::class, 'edit'])->name('edit');   
    Route::put('/{kelas}',   [KelasController::class, 'update'])->name('update');
    Route::delete('/{kelas}',[KelasController::class, 'destroy'])->name('destroy');
 
    // trash routes
    Route::get('/trash',           [KelasController::class, 'trash'])->name('trash');
    Route::patch('/{id}/restore',  [KelasController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force',   [KelasController::class, 'forceDelete'])->name('force-delete');
    });
});

require __DIR__.'/auth.php';