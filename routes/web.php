<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\TingkatanController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\JamBelajarController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\DashboardController;
use App\Models\Bagian;
use App\Models\Jurusan;
use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Models\Tingkatan;
use App\Models\Mapel;
use App\Models\JamBelajar;
use App\Models\Kelas;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bagian Routes
    Route::resource('bagian', BagianController::class);
    Route::bind('bagian', function ($value) { return Bagian::withTrashed()->findOrFail($value); });
    Route::get('bagian/trash', [BagianController::class, 'trash'])->name('bagian.trash');
    Route::patch('bagian/trash/{bagian}/restore', [BagianController::class, 'restore'])->name('bagian.restore');
    Route::delete('bagian/trash/{bagian}/force-delete', [BagianController::class, 'forceDelete'])->name('bagian.force-delete');

    // Jurusan Routes
    Route::resource('jurusan', JurusanController::class);
    Route::bind('jurusan', function ($value) { return Jurusan::withTrashed()->findOrFail($value); });
    Route::get('jurusan/trash', [JurusanController::class, 'trash'])->name('jurusan.trash');
    Route::patch('jurusan/trash/{jurusan}/restore', [JurusanController::class, 'restore'])->name('jurusan.restore');
    Route::delete('jurusan/trash/{jurusan}/force-delete', [JurusanController::class, 'forceDelete'])->name('jurusan.force-delete');

    // Semester Routes
    Route::resource('semester', SemesterController::class);
    Route::bind('semester', function ($value) { return Semester::withTrashed()->findOrFail($value); });
    Route::get('semester/trash', [SemesterController::class, 'trash'])->name('semester.trash');
    Route::patch('semester/trash/{semester}/restore', [SemesterController::class, 'restore'])->name('semester.restore');
    Route::delete('semester/trash/{semester}/force-delete', [SemesterController::class, 'forceDelete'])->name('semester.force-delete');

    // Tahun Ajaran Routes
    Route::resource('tahunajaran', TahunAjaranController::class);
    Route::bind('tahunajaran', function ($value) { return TahunAjaran::withTrashed()->findOrFail($value); });
    Route::get('tahunajaran/trash', [TahunAjaranController::class, 'trash'])->name('tahunajaran.trash');
    Route::patch('tahunajaran/trash/{tahunajaran}/restore', [TahunAjaranController::class, 'restore'])->name('tahunajaran.restore');
    Route::delete('tahunajaran/trash/{tahunajaran}/force-delete', [TahunAjaranController::class, 'forceDelete'])->name('tahunajaran.force-delete');

    // Tingkatan Routes
    Route::resource('tingkatan', TingkatanController::class);
    Route::bind('tingkatan', function ($value) { return Tingkatan::withTrashed()->findOrFail($value); });
    Route::get('tingkatan/trash', [TingkatanController::class, 'trash'])->name('tingkatan.trash');
    Route::patch('tingkatan/trash/{tingkatan}/restore', [TingkatanController::class, 'restore'])->name('tingkatan.restore');
    Route::delete('tingkatan/trash/{tingkatan}/force-delete', [TingkatanController::class, 'forceDelete'])->name('tingkatan.force-delete');

    // Mapel Routes
    Route::resource('mapel', MapelController::class);
    Route::bind('mapel', function ($value) { return Mapel::withTrashed()->findOrFail($value); });
    Route::get('mapel/trash', [MapelController::class, 'trash'])->name('mapel.trash');
    Route::patch('mapel/trash/{mapel}/restore', [MapelController::class, 'restore'])->name('mapel.restore');
    Route::delete('mapel/trash/{mapel}/force-delete', [MapelController::class, 'forceDelete'])->name('mapel.force-delete');

    // Jam Belajar Routes
    Route::resource('jambelajar', JamBelajarController::class);
    Route::bind('jambelajar', function ($value) { return JamBelajar::withTrashed()->findOrFail($value); });
    Route::get('jambelajar/trash', [JamBelajarController::class, 'trash'])->name('jambelajar.trash');
    Route::patch('jambelajar/trash/{jambelajar}/restore', [JamBelajarController::class, 'restore'])->name('jambelajar.restore');
    Route::delete('jambelajar/trash/{jambelajar}/force-delete', [JamBelajarController::class, 'forceDelete'])->name('jambelajar.force-delete');
  
   // Kelas Routes
    Route::prefix('kelas')->name('kelas.')->controller(KelasController::class)->group(function () {
        Route::get('/',          [KelasController::class, 'index'])->name('index');
        Route::post('/',         [KelasController::class, 'store'])->name('store');
        Route::get('/{kelas}/edit', [KelasController::class, 'edit'])->name('edit');
        Route::put('/{kelas}',   [KelasController::class, 'update'])->name('update');
        Route::delete('/{kelas}', [KelasController::class, 'destroy'])->name('destroy');

        // trash routes
        Route::bind('kelas', function ($value) { return Kelas::withTrashed()->findOrFail($value); });
        Route::get('/trash',           [KelasController::class, 'trash'])->name('trash');
        Route::patch('/{kelas}/restore',  [KelasController::class, 'restore'])->name('restore');
        Route::delete('/{kelas}/force',   [KelasController::class, 'forceDelete'])->name('force-delete');
    });
});

require __DIR__.'/auth.php';
  
