<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GuruMapelController;
use App\Http\Controllers\JadwalBelajarController;
use App\Http\Controllers\JamBelajarController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\TingkatanController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\UserController;
use App\Models\Bagian;
use App\Models\GuruMapel;
use App\Models\JadwalBelajar;
use App\Models\JamBelajar;
use App\Models\Jurusan;
use App\Models\Mapel;
use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Models\Tingkatan;
use App\Models\Pertemuan;
use App\Models\Absensi;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::bind() harus di luar middleware group agar terdaftar secara global
Route::bind('bagian',         fn($v) => Bagian::withTrashed()->findOrFail($v));
Route::bind('guru_mapel',     fn($v) => GuruMapel::withTrashed()->findOrFail($v));
Route::bind('jurusan',        fn($v) => Jurusan::withTrashed()->findOrFail($v));
Route::bind('semester',       fn($v) => Semester::withTrashed()->findOrFail($v));
Route::bind('tahunajaran',    fn($v) => TahunAjaran::withTrashed()->findOrFail($v));
Route::bind('tingkatan',      fn($v) => Tingkatan::withTrashed()->findOrFail($v));
Route::bind('mapel',          fn($v) => Mapel::withTrashed()->findOrFail($v));
Route::bind('jambelajar',     fn($v) => JamBelajar::withTrashed()->findOrFail($v));
Route::bind('jadwalbelajar', fn($v) => JadwalBelajar::withTrashed()->findOrFail($v));
Route::bind('pertemuan', fn($v) => Pertemuan::withTrashed()->findOrFail($v));
Route::bind('absensi', fn($v) => Absensi::withTrashed()->findOrFail($v));

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // users
    Route::get('users/trash',                [UserController::class, 'trash'])->name('users.trash');
    Route::patch('users/restore-all',        [UserController::class, 'restoreAll'])->name('users.restoreAll');
    Route::delete('users/force-delete-all',  [UserController::class, 'forceDeleteAll'])->name('users.forceDeleteAll');

    Route::resource('users', UserController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    Route::patch('users/{id}/restore',       [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');

    // Bagian Routes
    Route::get('bagian/trash', [BagianController::class, 'trash'])->name('bagian.trash');
    Route::patch('bagian/trash/{bagian}/restore', [BagianController::class, 'restore'])->name('bagian.restore');
    Route::delete('bagian/trash/{bagian}/force-delete', [BagianController::class, 'forceDelete'])->name('bagian.force-delete');
    Route::resource('bagian', BagianController::class);

    // Jurusan Routes
    Route::get('jurusan/trash', [JurusanController::class, 'trash'])->name('jurusan.trash');
    Route::patch('jurusan/trash/{jurusan}/restore', [JurusanController::class, 'restore'])->name('jurusan.restore');
    Route::delete('jurusan/trash/{jurusan}/force-delete', [JurusanController::class, 'forceDelete'])->name('jurusan.force-delete');
    Route::resource('jurusan', JurusanController::class);

    // Semester Routes
    Route::get('semester/trash', [SemesterController::class, 'trash'])->name('semester.trash');
    Route::patch('semester/trash/{semester}/restore', [SemesterController::class, 'restore'])->name('semester.restore');
    Route::delete('semester/trash/{semester}/force-delete', [SemesterController::class, 'forceDelete'])->name('semester.force-delete');
    Route::resource('semester', SemesterController::class);

    // Tahun Ajaran Routes
    Route::get('tahunajaran/trash', [TahunAjaranController::class, 'trash'])->name('tahunajaran.trash');
    Route::patch('tahunajaran/trash/{tahunajaran}/restore', [TahunAjaranController::class, 'restore'])->name('tahunajaran.restore');
    Route::delete('tahunajaran/trash/{tahunajaran}/force-delete', [TahunAjaranController::class, 'forceDelete'])->name('tahunajaran.force-delete');
    Route::resource('tahunajaran', TahunAjaranController::class);

    // Tingkatan Routes
    Route::get('tingkatan/trash', [TingkatanController::class, 'trash'])->name('tingkatan.trash');
    Route::patch('tingkatan/trash/{tingkatan}/restore', [TingkatanController::class, 'restore'])->name('tingkatan.restore');
    Route::delete('tingkatan/trash/{tingkatan}/force-delete', [TingkatanController::class, 'forceDelete'])->name('tingkatan.force-delete');
    Route::resource('tingkatan', TingkatanController::class);

    // Mapel Routes
    Route::get('mapel/trash', [MapelController::class, 'trash'])->name('mapel.trash');
    Route::patch('mapel/trash/{mapel}/restore', [MapelController::class, 'restore'])->name('mapel.restore');
    Route::delete('mapel/trash/{mapel}/force-delete', [MapelController::class, 'forceDelete'])->name('mapel.force-delete');
    Route::resource('mapel', MapelController::class);

    // Jam Belajar Routes
    Route::get('jambelajar/trash', [JamBelajarController::class, 'trash'])->name('jambelajar.trash');
    Route::patch('jambelajar/trash/{jambelajar}/restore', [JamBelajarController::class, 'restore'])->name('jambelajar.restore');
    Route::delete('jambelajar/trash/{jambelajar}/force-delete', [JamBelajarController::class, 'forceDelete'])->name('jambelajar.force-delete');
    Route::resource('jambelajar', JamBelajarController::class);

    // Guru Mapel Routes
    Route::get('guru_mapel/trash', [GuruMapelController::class, 'trash'])->name('guru_mapel.trash');
    Route::patch('guru_mapel/trash/{guru_mapel}/restore', [GuruMapelController::class, 'restore'])->name('guru_mapel.restore');
    Route::delete('guru_mapel/trash/{guru_mapel}/force-delete', [GuruMapelController::class, 'forceDelete'])->name('guru_mapel.force-delete');
    Route::resource('guru_mapel', GuruMapelController::class);

    // Kelas Routes
    Route::prefix('kelas')->name('kelas.')->controller(KelasController::class)->group(function () {
        Route::get('/trash',           'trash')->name('trash');
        Route::patch('/{id}/restore',  'restore')->name('restore');
        Route::delete('/{id}/force',   'forceDelete')->name('force-delete');

        Route::get('/',                'index')->name('index');
        Route::post('/',               'store')->name('store');
        Route::get('/{kelas}/edit',    'edit')->name('edit');
        Route::put('/{kelas}',         'update')->name('update');
        Route::delete('/{kelas}',      'destroy')->name('destroy');
    });

    // Guru Routes
    Route::prefix('guru')->name('guru.')->controller(GuruController::class)->group(function () {
        Route::get('/export',                  'export')->name('export');
        Route::post('/import',                 'import')->name('import');
        Route::post('/send-email-all',         'sendEmailAll')->name('sendEmailAll');

        Route::get('/trash',                   'trash')->name('trash');
        Route::post('/trash/restore-all',      'restoreAll')->name('restoreAll');
        Route::post('/trash/force-delete-all', 'forceDeleteAll')->name('forceDeleteAll');
        Route::post('/trash/{id}/restore',     'restore')->name('restore');
        Route::delete('/trash/{id}/force',     'forceDelete')->name('forceDelete');

        Route::get('/',                        'index')->name('index');
        Route::post('/',                       'store')->name('store');
        Route::put('/{guru}',                  'update')->name('update');
        Route::delete('/{guru}',               'destroy')->name('destroy');
        Route::post('/{guru}/send-email',      'sendEmail')->name('sendEmail');
    });

    Route::prefix('siswa')->name('siswa.')->controller(SiswaController::class)->group(function () {

        Route::get('/',                        'index')->name('index');
        Route::post('/',                       'store')->name('store');
        Route::get('/export',                  'export')->name('export');
        Route::post('/import',                 'import')->name('import');
        Route::post('/send-email-all',         'sendEmailAll')->name('sendEmailAll');

        // Trash
        Route::get('/trash',                   'trash')->name('trash');
        Route::post('/trash/restore-all',      'restoreAll')->name('restoreAll');
        Route::post('/trash/force-delete-all', 'forceDeleteAll')->name('forceDeleteAll');
        Route::post('/trash/{id}/restore',     'restore')->name('restore');
        Route::delete('/trash/{id}/force',     'forceDelete')->name('forceDelete');

        // Wildcard (model binding) — paling bawah
        Route::put('/{siswa}',                 'update')->name('update');
        Route::delete('/{siswa}',              'destroy')->name('destroy');
        Route::post('/{siswa}/send-email',     'sendEmail')->name('sendEmail');
    });

    // Jadwal Belajar Routes
    Route::prefix('jadwalbelajar')->name('jadwalbelajar.')->controller(JadwalBelajarController::class)->group(function () {
        Route::get('/trash',                    'trash')->name('trash');
        Route::patch('/trash/{id}/restore',     'restore')->name('restore');
        Route::delete('/trash/{id}/force',      'forceDelete')->name('force-delete');

        Route::get('/',                         'index')->name('index');
        Route::post('/',                        'store')->name('store');
        Route::get('/{jadwalbelajar}/edit',    'edit')->name('edit');
        Route::put('/{jadwalbelajar}',         'update')->name('update');
        Route::delete('/{jadwalbelajar}',      'destroy')->name('destroy');
    });

    // Pertemuan Routes
    Route::prefix('pertemuan')->name('pertemuan.')->controller(PertemuanController::class)->group(function () {
        Route::get('/trash',                     'trash')->name('trash');
        Route::patch('/trash/{id}/restore',      'restore')->name('restore');
        Route::delete('/trash/{id}/force',       'forceDelete')->name('force-delete');

        Route::get('/',                          'index')->name('index');
        Route::post('/',                         'store')->name('store');
        Route::get('/{pertemuan}/edit',          'edit')->name('edit');
        Route::put('/{pertemuan}',               'update')->name('update');
        Route::delete('/{pertemuan}',            'destroy')->name('destroy');
    });

    // Absensi Routes
    Route::prefix('absensi')->name('absensi.')->controller(AbsensiController::class)->group(function () {
        Route::get('/trash',                     'trash')->name('trash');
        Route::patch('/trash/{id}/restore',      'restore')->name('restore');
        Route::delete('/trash/{id}/force',       'forceDelete')->name('force-delete');

        Route::get('/',                          'index')->name('index');
        Route::post('/',                         'store')->name('store');
        Route::get('/{absensi}/edit',          'edit')->name('edit');
        Route::put('/{absensi}',               'update')->name('update');
        Route::delete('/{absensi}',            'destroy')->name('destroy');
    });

    // Ruang Belajar (Lesson Viewer) Routes
    Route::get('/ruang-belajar/{jadwalbelajar}/{materi?}', [\App\Http\Controllers\RuangBelajarController::class, 'show'])->name('ruang-belajar.show');
    Route::post('/ruang-belajar/{materi}/mark-done', [\App\Http\Controllers\RuangBelajarController::class, 'markAsDone'])->name('ruang-belajar.mark-done');

    // Admin Routes for LMS Features
    Route::resource('materi', \App\Http\Controllers\MateriController::class);
    Route::resource('tugas', \App\Http\Controllers\TugasController::class);
    Route::resource('pengumpulan-tugas', \App\Http\Controllers\PengumpulanTugasController::class)->only(['index']);
    Route::resource('penilaian', \App\Http\Controllers\PenilaianController::class)->only(['index']);
    Route::resource('activity-log', \App\Http\Controllers\ActivityLogController::class)->only(['index']);
});

require __DIR__ . '/auth.php';
