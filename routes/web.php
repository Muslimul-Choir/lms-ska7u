<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\TingkatanController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\JamBelajarController;
use App\Models\Absensi;
use App\Models\Bagian;
use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\JadwalBelajar;
use App\Models\JamBelajar;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Penilaian;
use App\Models\Pertemuan;
use App\Models\PengumpulanTugas;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\Tugas;
use App\Models\Tingkatan;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $counts = [
        'users' => User::count(),
        'bagian' => Bagian::count(),
        'jurusan' => Jurusan::count(),
        'semester' => Semester::count(),
        'tahun_ajaran' => TahunAjaran::count(),
        'tingkatan' => Tingkatan::count(),
        'mapel' => Mapel::count(),
        'jam_belajar' => JamBelajar::count(),
        'guru' => Guru::count(),
        'kelas' => Kelas::count(),
        'siswa' => Siswa::count(),
        'materi' => Materi::count(),
        'pertemuan' => Pertemuan::count(),
        'tugas' => Tugas::count(),
        'pengumpulan_tugas' => PengumpulanTugas::count(),
        'penilaian' => Penilaian::count(),
        'absensi' => Absensi::count(),
        'guru_mapel' => GuruMapel::count(),
        'jadwal_belajar' => JadwalBelajar::count(),
    ];

    return view('dashboard', compact('counts'));
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

    // Mapel Routes
    Route::get('mapel/trash', [MapelController::class, 'trash'])->name('mapel.trash');
    Route::patch('mapel/trash/{id}/restore', [MapelController::class, 'restore'])->name('mapel.restore');
    Route::delete('mapel/trash/{id}/force-delete', [MapelController::class, 'forceDelete'])->name('mapel.force-delete');
    Route::resource('mapel', MapelController::class);

    // Jam Belajar Routes
    Route::get('jambelajar/trash', [JamBelajarController::class, 'trash'])->name('jambelajar.trash');
    Route::patch('jambelajar/trash/{id}/restore', [JamBelajarController::class, 'restore'])->name('jambelajar.restore');
    Route::delete('jambelajar/trash/{id}/force-delete', [JamBelajarController::class, 'forceDelete'])->name('jambelajar.force-delete');
    Route::resource('jambelajar', JamBelajarController::class);
});

require __DIR__.'/auth.php';