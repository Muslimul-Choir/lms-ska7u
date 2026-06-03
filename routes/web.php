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
use App\Models\Kuis;
use App\Models\SoalKuis;
use App\Models\HasilKuis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 🧪 Testing Routes - DEVELOPMENT ONLY
if (config('app.debug')) {
    Route::get('/test-email', function () {
        return view('test-email');
    })->name('test-email');

    Route::post('/test-email-send', function (\Illuminate\Http\Request $request) {
        try {
            $email = $request->input('email');
            $password = $request->input('password', '12345678');

            \Illuminate\Support\Facades\Log::info("Testing email send to: $email");
            \Illuminate\Support\Facades\Log::info("Mail config: " . json_encode([
                'mailer' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'from' => config('mail.from.address'),
            ]));

            $testSiswa = new \App\Models\Siswa();
            $testSiswa->nama_lengkap = 'Test User';
            $testSiswa->email = $email;

            \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\Siswa\KirimAkunSiswa($testSiswa, $password));

            \Illuminate\Support\Facades\Log::info("Email test sent successfully to: $email");

            return response()->json([
                'status' => 'success',
                'message' => "✅ Email test berhasil dikirim ke: $email",
                'check_spam' => 'Silakan cek folder Spam/Junk email Anda'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Email test failed: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => "❌ Gagal mengirim email: " . $e->getMessage(),
                'details' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    })->name('test-email-send');
}

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
Route::bind('kuis', fn($v) => Kuis::withTrashed()->findOrFail($v));
Route::bind('soal', fn($v) => SoalKuis::withTrashed()->findOrFail($v));
Route::bind('hasil', fn($v) => HasilKuis::withTrashed()->findOrFail($v));

// ============================================================
// 👤 ADMIN/GURU ROUTES - Protected with Role Middleware
// ============================================================
Route::middleware(['auth', 'verified', 'role:super_admin,admin,guru'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    Route::patch('bagian/trash/restore-all', [BagianController::class, 'restoreAll'])->name('bagian.restoreAll');
    Route::delete('bagian/trash/force-delete-all', [BagianController::class, 'forceDeleteAll'])->name('bagian.forceDeleteAll');
    Route::resource('bagian', BagianController::class);

    // Jurusan Routes
    Route::get('jurusan/trash', [JurusanController::class, 'trash'])->name('jurusan.trash');
    Route::patch('jurusan/trash/{jurusan}/restore', [JurusanController::class, 'restore'])->name('jurusan.restore');
    Route::delete('jurusan/trash/{jurusan}/force-delete', [JurusanController::class, 'forceDelete'])->name('jurusan.force-delete');
    Route::patch('jurusan/trash/restore-all', [JurusanController::class, 'restoreAll'])->name('jurusan.restoreAll');
    Route::delete('jurusan/trash/force-delete-all', [JurusanController::class, 'forceDeleteAll'])->name('jurusan.forceDeleteAll');
    Route::resource('jurusan', JurusanController::class);

    // Semester Routes
    Route::get('semester/trash', [SemesterController::class, 'trash'])->name('semester.trash');
    Route::patch('semester/trash/{semester}/restore', [SemesterController::class, 'restore'])->name('semester.restore');
    Route::delete('semester/trash/{semester}/force-delete', [SemesterController::class, 'forceDelete'])->name('semester.force-delete');
    Route::patch('semester/trash/restore-all', [SemesterController::class, 'restoreAll'])->name('semester.restoreAll');
    Route::delete('semester/trash/force-delete-all', [SemesterController::class, 'forceDeleteAll'])->name('semester.forceDeleteAll');
    Route::resource('semester', SemesterController::class);

    // Tahun Ajaran Routes
    Route::get('tahunajaran/trash', [TahunAjaranController::class, 'trash'])->name('tahunajaran.trash');
    Route::patch('tahunajaran/trash/{tahunajaran}/restore', [TahunAjaranController::class, 'restore'])->name('tahunajaran.restore');
    Route::delete('tahunajaran/trash/{tahunajaran}/force-delete', [TahunAjaranController::class, 'forceDelete'])->name('tahunajaran.force-delete');
    Route::patch('tahunajaran/trash/restore-all', [TahunAjaranController::class, 'restoreAll'])->name('tahunajaran.restoreAll');
    Route::delete('tahunajaran/trash/force-delete-all', [TahunAjaranController::class, 'forceDeleteAll'])->name('tahunajaran.forceDeleteAll');
    Route::resource('tahunajaran', TahunAjaranController::class);

    // Tingkatan Routes
    Route::get('tingkatan/trash', [TingkatanController::class, 'trash'])->name('tingkatan.trash');
    Route::patch('tingkatan/trash/{tingkatan}/restore', [TingkatanController::class, 'restore'])->name('tingkatan.restore');
    Route::delete('tingkatan/trash/{tingkatan}/force-delete', [TingkatanController::class, 'forceDelete'])->name('tingkatan.force-delete');
    Route::patch('tingkatan/trash/restore-all', [TingkatanController::class, 'restoreAll'])->name('tingkatan.restoreAll');
    Route::delete('tingkatan/trash/force-delete-all', [TingkatanController::class, 'forceDeleteAll'])->name('tingkatan.forceDeleteAll');
    Route::resource('tingkatan', TingkatanController::class);

    // Mapel Routes
    Route::get('mapel/trash', [MapelController::class, 'trash'])->name('mapel.trash');
    Route::patch('mapel/trash/restore-all', [MapelController::class, 'restoreAll'])->name('mapel.restoreAll');
    Route::delete('mapel/trash/force-delete-all', [MapelController::class, 'forceDeleteAll'])->name('mapel.forceDeleteAll');
    Route::patch('mapel/trash/{mapel}/restore', [MapelController::class, 'restore'])->name('mapel.restore');
    Route::delete('mapel/trash/{mapel}/force-delete', [MapelController::class, 'forceDelete'])->name('mapel.force-delete');
    Route::resource('mapel', MapelController::class);

    // Jam Belajar Routes
    Route::get('jambelajar/trash', [JamBelajarController::class, 'trash'])->name('jambelajar.trash');
    Route::patch('jambelajar/trash/{jambelajar}/restore', [JamBelajarController::class, 'restore'])->name('jambelajar.restore');
    Route::delete('jambelajar/trash/{jambelajar}/force-delete', [JamBelajarController::class, 'forceDelete'])->name('jambelajar.force-delete');
    Route::patch('jambelajar/trash/restore-all', [JamBelajarController::class, 'restoreAll'])->name('jambelajar.restoreAll');
    Route::delete('jambelajar/trash/force-delete-all', [JamBelajarController::class, 'forceDeleteAll'])->name('jambelajar.forceDeleteAll');
    Route::resource('jambelajar', JamBelajarController::class);

    // Guru Mapel Routes
    Route::get('guru_mapel/trash', [GuruMapelController::class, 'trash'])->name('guru_mapel.trash');
    Route::patch('guru_mapel/trash/{guru_mapel}/restore', [GuruMapelController::class, 'restore'])->name('guru_mapel.restore');
    Route::delete('guru_mapel/trash/{guru_mapel}/force-delete', [GuruMapelController::class, 'forceDelete'])->name('guru_mapel.force-delete');
    Route::patch('guru_mapel/trash/restore-all', [GuruMapelController::class, 'restoreAll'])->name('guru_mapel.restoreAll');
    Route::delete('guru_mapel/trash/force-delete-all', [GuruMapelController::class, 'forceDeleteAll'])->name('guru_mapel.forceDeleteAll');
    Route::resource('guru_mapel', GuruMapelController::class)->except(['show']);

    // Kelas Routes
    Route::prefix('kelas')->name('kelas.')->controller(KelasController::class)->group(function () {
    Route::get('/trash',           'trash')->name('trash');
    Route::patch('/trash/{kelas}/restore', 'restore')->name('restore')->withTrashed();
    Route::delete('/trash/{kelas}/force', 'forceDelete')->name('force-delete')->withTrashed();
    Route::patch('/restore-all',        [KelasController::class, 'restoreAll'])->name('restoreAll');
    Route::delete('/force-delete-all',  [KelasController::class, 'forceDeleteAll'])->name('forceDeleteAll');

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
        Route::patch('/trash/restore-all',      'restoreAll')->name('restoreAll');
        Route::post('/trash/force-delete-all', 'forceDeleteAll')->name('forceDeleteAll');
        Route::patch('/trash/{id}/restore',     'restore')->name('restore');
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

        Route::put('/{siswa}',                 'update')->name('update');
        Route::delete('/{siswa}',              'destroy')->name('destroy');
        Route::post('/{siswa}/send-email',     'sendEmail')->name('sendEmail');
    });

        // Jadwal Belajar Routes
        Route::prefix('jadwalbelajar')->name('jadwalbelajar.')->controller(JadwalBelajarController::class)->group(function () {
        Route::get('/trash', 'trash')->name('trash');
        Route::patch('/trash/{jadwalbelajar}/restore', 'restore')->withTrashed()->name('restore');
        Route::delete('/trash/{jadwalbelajar}/force', 'forceDelete')->withTrashed()->name('force-delete');
        Route::patch('/trash/restore-all', 'restoreAll')->name('restoreAll');
        Route::delete('/trash/force-delete-all', 'forceDeleteAll')->name('forceDeleteAll');
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{jadwalbelajar}', 'update')->name('update');
        Route::delete('/{jadwalbelajar}', 'destroy')->name('destroy');
    });

    // Pertemuan Routes
    Route::prefix('pertemuan')->name('pertemuan.')->controller(PertemuanController::class)->group(function () {
        Route::get('/trash',                     'trash')->name('trash');
        Route::patch('/trash/{id}/restore',      'restore')->name('restore');
        Route::delete('/trash/{id}/force',       'forceDelete')->name('force-delete');

        Route::get('/',                          'index')->name('index');
        Route::get('/create',                    'create')->name('create');
        Route::post('/',                         'store')->name('store');
        Route::get('/{pertemuan}',               'show')->name('show');
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

    // Pengumpulan Tugas - Rekap & Download (Task 4.1)
    Route::get('/tugas/{tugas}/rekap', [\App\Http\Controllers\PengumpulanTugasController::class, 'rekap'])->name('tugas.rekap');
    Route::get('/tugas/{tugas}/rekap/export-pdf', [\App\Http\Controllers\PengumpulanTugasController::class, 'exportPdf'])->name('tugas.rekap.export-pdf');
    Route::get('/pengumpulan-tugas/{pengumpulanTugas}/download', [\App\Http\Controllers\PengumpulanTugasController::class, 'download'])->name('pengumpulan-tugas.download');

    // Penilaian - Quick Store via AJAX (Task 5.2)
    Route::post('/penilaian/quick-store', [\App\Http\Controllers\PenilaianController::class, 'quickStore'])->name('penilaian.quick-store');

    // Kuis Routes (Task 7.2)
    Route::prefix('kuis')->name('kuis.')->controller(\App\Http\Controllers\KuisController::class)->group(function () {
        Route::get('/trash',                     'trash')->name('trash');
        Route::patch('/trash/{id}/restore',      'restore')->name('restore');
        Route::delete('/trash/{id}/force',       'forceDelete')->name('force-delete');

        Route::get('/',                          'index')->name('index');
        Route::get('/create',                    'create')->name('create');
        Route::post('/',                         'store')->name('store');
        Route::get('/{kuis}',                    'show')->name('show');
        Route::get('/{kuis}/edit',               'edit')->name('edit');
        Route::put('/{kuis}',                    'update')->name('update');
        Route::delete('/{kuis}',                 'destroy')->name('destroy');
    });

    // Soal Kuis Routes (Task 8.2) - Nested under kuis
    Route::prefix('kuis/{kuis}/soal')->name('soal_kuis.')->controller(\App\Http\Controllers\SoalKuisController::class)->group(function () {
        Route::get('/',                          'index')->name('index');
        Route::post('/',                         'store')->name('store');
        Route::get('/{soal}/edit',               'edit')->name('edit');
        Route::put('/{soal}',                    'update')->name('update');
        Route::delete('/{soal}',                 'destroy')->name('destroy');
    });

    // Hasil Kuis Routes (Task 9.3) - Nested under kuis
    Route::get('/kuis/{kuis}/hasil/{hasil}', [\App\Http\Controllers\HasilKuisController::class, 'show'])->name('hasil_kuis.show');
});

// ============================================================
// 👨‍🎓 STUDENT ROUTES - Protected with Student Role Middleware
// ============================================================
Route::middleware(['auth', 'verified', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [\App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('siswa.dashboard');

    // Materi & Mapel
    Route::get('/siswa/materi', [\App\Http\Controllers\Siswa\SiswaMateriController::class, 'index'])->name('siswa.materi.index');
    Route::get('/siswa/materi/mapel/{id_mapel}', [\App\Http\Controllers\Siswa\SiswaMateriController::class, 'showMapel'])->name('siswa.materi.mapel');
    Route::get('/siswa/materi/{id}', [\App\Http\Controllers\Siswa\SiswaMateriController::class, 'showMateri'])->name('siswa.materi.show');

    // Tugas
    Route::get('/siswa/tugas', [\App\Http\Controllers\Siswa\SiswaTugasController::class, 'index'])->name('siswa.tugas.index');
    Route::get('/siswa/tugas/{id}', [\App\Http\Controllers\Siswa\SiswaTugasController::class, 'show'])->name('siswa.tugas.show');
    Route::post('/siswa/tugas/{id}/submit', [\App\Http\Controllers\Siswa\SiswaTugasController::class, 'store'])->name('siswa.tugas.store');

    // Kuis
    Route::get('/siswa/kuis', [\App\Http\Controllers\Siswa\SiswaKuisController::class, 'index'])->name('siswa.kuis.index');
    Route::get('/siswa/kuis/{kuis}', [\App\Http\Controllers\Siswa\SiswaKuisController::class, 'show'])->name('siswa.kuis.show');
    Route::post('/siswa/kuis/{kuis}/mulai', [\App\Http\Controllers\Siswa\SiswaKuisController::class, 'mulai'])->name('siswa.kuis.mulai');
    Route::get('/siswa/kuis/{kuis}/kerjakan', [\App\Http\Controllers\Siswa\SiswaKuisController::class, 'kerjakan'])->name('siswa.kuis.kerjakan');
    Route::post('/siswa/kuis/{kuis}/submit', [\App\Http\Controllers\Siswa\SiswaKuisController::class, 'submit'])->name('siswa.kuis.submit');
    Route::get('/siswa/kuis/{kuis}/hasil', [\App\Http\Controllers\Siswa\SiswaKuisController::class, 'hasil'])->name('siswa.kuis.hasil');

    // Absensi
    Route::get('/siswa/absensi', [\App\Http\Controllers\Siswa\SiswaAbsensiController::class, 'index'])->name('siswa.absensi.index');

    // Jadwal Belajar
    Route::get('/siswa/jadwal', [\App\Http\Controllers\Siswa\SiswaJadwalController::class, 'index'])->name('siswa.jadwal.index');

    // Pertemuan
    Route::get('/siswa/pertemuan', [\App\Http\Controllers\Siswa\SiswaPertemuanController::class, 'index'])->name('siswa.pertemuan.index');
    Route::get('/siswa/pertemuan/{id}', [\App\Http\Controllers\Siswa\SiswaPertemuanController::class, 'show'])->name('siswa.pertemuan.show');

    // Profil Siswa
    Route::get('/siswa/profil', [\App\Http\Controllers\Siswa\SiswaProfileController::class, 'show'])->name('siswa.profil');
    Route::put('/siswa/profil/password', [\App\Http\Controllers\Siswa\SiswaProfileController::class, 'updatePassword'])->name('siswa.profil.password');
});

require __DIR__ . '/auth.php';
