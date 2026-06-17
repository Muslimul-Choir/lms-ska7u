<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Kuis;
use App\Models\Pertemuan;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\ContentExemption;
use App\Services\ContentReleaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduledContentTestSeeder extends Seeder
{
    protected $contentReleaseService;

    public function __construct(ContentReleaseService $contentReleaseService)
    {
        $this->contentReleaseService = $contentReleaseService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Creating test data for Scheduled Content Release & Attendance-Gated Access...');

        DB::beginTransaction();
        try {
            // Get first siswa for testing
            $siswa = Siswa::first();
            if (!$siswa) {
                $this->command->error('❌ No siswa found! Please run main seeder first.');
                return;
            }

            $this->command->info('👨‍ Testing with siswa: ' . $siswa->nama_lengkap);
            $this->command->info('   Kelas ID: ' . $siswa->id_kelas);

            // Get pertemuans for the siswa's class only
            $pertemuans = Pertemuan::whereHas('JadwalBelajar', function($q) use ($siswa) {
                $q->where('id_kelas', $siswa->id_kelas);
            })->with('JadwalBelajar')->take(5)->get();
            
            if ($pertemuans->isEmpty()) {
                $this->command->error('❌ No pertemuan found for siswa\'s class! Please run main seeder first.');
                return;
            }

            $this->command->info('📚 Found ' . $pertemuans->count() . ' pertemuan in siswa\'s class');

            // Use available pertemuans (cycle through if not enough)
            $count = $pertemuans->count();

            // Scenario 1: Materi with Auto Release (Already Released)
            $this->createAlreadyReleasedMateri($pertemuans->get(0 % $count));

            // Scenario 2: Materi Scheduled for Future (Not Yet Released)
            $this->createFutureMateri($pertemuans->get(min(1, $count - 1)));

            // Scenario 3: Materi Released Recently (Needs Attendance)
            $this->createRecentlyReleasedMateri($pertemuans->get(min(2, $count - 1) % $count), $siswa);

            // Scenario 4: Tugas with Different Deadlines
            if ($count > 0) {
                $this->createTugasScenarios($pertemuans->get(0));
            }

            // Scenario 5: Kuis with Attendance Gate
            if ($count > 0) {
                $this->createKuisWithAttendance($pertemuans->get(min(1, $count - 1)));
            }

            // Scenario 6: Content with Exemption
            $this->createExemptedContent($pertemuans->first(), $siswa);

            // Scenario 7: Attended Content (Already Marked)
            $this->createAttendedContent($pertemuans->get($count > 1 ? 1 : 0), $siswa);

            DB::commit();

            $this->command->info('');
            $this->command->info('✅ Test data created successfully!');
            $this->displaySummary();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Error: ' . $e->getMessage());
            $this->command->error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Scenario 1: Already Released Content
     */
    protected function createAlreadyReleasedMateri($pertemuan)
    {
        $this->command->info('📝 Creating already released materi...');

        $releaseTime = Carbon::now()->subHours(2); // Released 2 hours ago
        $batasAbsensi = $releaseTime->copy()->addHours(24);

        $materi = Materi::create([
            'id_pertemuan' => $pertemuan->id,
            'id_mapel' => $pertemuan->JadwalBelajar?->id_mapel,
            'id_guru_mapel' => $pertemuan->JadwalBelajar?->id_guru_mapel,
            'judul' => '[TEST] Materi Sudah Dirilis - Butuh Absensi',
            'deskripsi' => 'Materi ini sudah dirilis 2 jam yang lalu. Siswa harus absen untuk mengakses.',
            'tipe_materi' => 'dokumen',
            'file_url' => 'test/materi1.pdf',
            'waktu_rilis' => $releaseTime,
            'batas_absensi' => $batasAbsensi,
            'auto_release' => false,
        ]);

        $this->command->line("  ✓ Created: {$materi->judul}");
        $this->command->line("    Status: {$materi->status_label}");
        $this->command->line("    Released: {$releaseTime->format('d M Y H:i')}");
    }

    /**
     * Scenario 2: Future Release
     */
    protected function createFutureMateri($pertemuan)
    {
        $this->command->info('🔮 Creating future scheduled materi...');

        $releaseTime = Carbon::now()->addHours(2); // Will release in 2 hours
        $batasAbsensi = $releaseTime->copy()->addHours(24);

        $materi = Materi::create([
            'id_pertemuan' => $pertemuan->id,
            'id_mapel' => $pertemuan->JadwalBelajar?->id_mapel,
            'id_guru_mapel' => $pertemuan->JadwalBelajar?->id_guru_mapel,
            'judul' => '[TEST] Materi Akan Dirilis 2 Jam Lagi',
            'deskripsi' => 'Materi ini terjadwal untuk dirilis 2 jam dari sekarang. Siswa belum bisa melihatnya.',
            'tipe_materi' => 'video',
            'file_url' => 'test/video1.mp4',
            'waktu_rilis' => $releaseTime,
            'batas_absensi' => $batasAbsensi,
            'auto_release' => false,
        ]);

        $this->command->line("  ✓ Created: {$materi->judul}");
        $this->command->line("    Status: {$materi->status_label}");
        $this->command->line("    Will release at: {$releaseTime->format('d M Y H:i')}");
    }

    /**
     * Scenario 3: Recently Released (Needs Attendance)
     */
    protected function createRecentlyReleasedMateri($pertemuan, $siswa)
    {
        $this->command->info(' Creating recently released materi (needs attendance)...');

        $releaseTime = Carbon::now()->subMinutes(30); // Released 30 minutes ago
        $batasAbsensi = $releaseTime->copy()->addHours(2); // 2 hours deadline

        $materi = Materi::create([
            'id_pertemuan' => $pertemuan->id,
            'id_mapel' => $pertemuan->JadwalBelajar?->id_mapel,
            'id_guru_mapel' => $pertemuan->JadwalBelajar?->id_guru_mapel,
            'judul' => '[TEST] Materi Baru Dirilis - Deadline 2 Jam',
            'deskripsi' => 'Dirilis 30 menit lalu. Batas absensi 2 jam dari rilis.',
            'tipe_materi' => 'link',
            'file_url' => 'https://example.com/materi',
            'waktu_rilis' => $releaseTime,
            'batas_absensi' => $batasAbsensi,
            'auto_release' => false,
        ]);

        $this->command->line("  ✓ Created: {$materi->judul}");
        $this->command->line("    Status: {$materi->status_label}");
        $this->command->line("    Attendance deadline: {$batasAbsensi->format('d M Y H:i')}");
        $this->command->line("    Time remaining: {$batasAbsensi->diffForHumans()}");
    }

    /**
     * Scenario 4: Tugas with Different Deadlines
     */
    protected function createTugasScenarios($pertemuan)
    {
        $this->command->info('📝 Creating tugas with various deadlines...');

        // Tugas 1: Released, attendance deadline soon
        $releaseTime1 = Carbon::now()->subHour();
        $tugas1 = Tugas::create([
            'id_pertemuan' => $pertemuan->id,
            'id_mapel' => $pertemuan->JadwalBelajar?->id_mapel,
            'id_guru_mapel' => $pertemuan->JadwalBelajar?->id_guru_mapel,
            'id_guru' => $pertemuan->id_guru,
            'judul' => '[TEST] Tugas - Absensi Deadline 1 Jam',
            'deskripsi' => 'Tugas dengan batas absensi 1 jam dari sekarang',
            'tipe_tugas' => 'individu',
            'tipe_file' => 'dokumen',
            'batas_waktu' => Carbon::now()->addDays(3),
            'nilai_maksimal' => 100,
            'status' => 'published',
            'waktu_rilis' => $releaseTime1,
            'batas_absensi' => Carbon::now()->addHour(),
            'auto_release' => false,
        ]);

        $this->command->line("  ✓ Created: {$tugas1->judul}");
        $this->command->line("    Attendance deadline: " . Carbon::now()->addHour()->format('H:i'));

        // Tugas 2: Will release tomorrow
        $releaseTime2 = Carbon::tomorrow()->setTime(8, 0);
        $tugas2 = Tugas::create([
            'id_pertemuan' => $pertemuan->id,
            'id_mapel' => $pertemuan->JadwalBelajar?->id_mapel,
            'id_guru_mapel' => $pertemuan->JadwalBelajar?->id_guru_mapel,
            'id_guru' => $pertemuan->id_guru,
            'judul' => '[TEST] Tugas - Besok Pagi Jam 08:00',
            'deskripsi' => 'Tugas akan dirilis besok pagi',
            'tipe_tugas' => 'kelompok',
            'tipe_file' => 'tanpa',
            'batas_waktu' => $releaseTime2->copy()->addDays(7),
            'nilai_maksimal' => 100,
            'status' => 'draft',
            'waktu_rilis' => $releaseTime2,
            'batas_absensi' => $releaseTime2->copy()->addHours(24),
            'auto_release' => false,
        ]);

        $this->command->line("  ✓ Created: {$tugas2->judul}");
        $this->command->line("    Will release: {$releaseTime2->format('d M Y H:i')}");
    }

    /**
     * Scenario 5: Kuis with Attendance
     */
    protected function createKuisWithAttendance($pertemuan)
    {
        $this->command->info('📊 Creating kuis with attendance requirement...');

        $releaseTime = Carbon::now()->subMinutes(15); // Released 15 minutes ago
        $batasAbsensi = Carbon::now()->addMinutes(45); // 1 hour total deadline

        $kuis = Kuis::create([
            'id_pertemuan' => $pertemuan->id,
            'id_guru_mapel' => $pertemuan->JadwalBelajar?->id_guru_mapel,
            'id_guru' => $pertemuan->id_guru,
            'judul' => '[TEST] Kuis - Absensi Wajib',
            'deskripsi' => 'Kuis dengan batas absensi ketat (45 menit lagi)',
            'durasi' => 30,
            'nilai_maksimal' => 100,
            'batas_mulai' => $releaseTime,
            'batas_selesai' => $releaseTime->copy()->addHours(2),
            'status' => 'published',
            'waktu_rilis' => $releaseTime,
            'batas_absensi' => $batasAbsensi,
            'auto_release' => false,
        ]);

        $this->command->line("  ✓ Created: {$kuis->judul}");
        $this->command->line("    Status: {$kuis->status_label}");
        $this->command->line("    Attendance deadline: {$batasAbsensi->diffForHumans()}");
    }

    /**
     * Scenario 6: Content with Exemption
     */
    protected function createExemptedContent($pertemuan, $siswa)
    {
        $this->command->info('🎫 Creating exempted content...');

        $releaseTime = Carbon::now()->subHour();
        $materi = Materi::create([
            'id_pertemuan' => $pertemuan->id,
            'id_mapel' => $pertemuan->JadwalBelajar?->id_mapel,
            'id_guru_mapel' => $pertemuan->JadwalBelajar?->id_guru_mapel,
            'judul' => '[TEST] Materi dengan Exemption',
            'deskripsi' => 'Materi ini memiliki exemption untuk siswa tertentu',
            'tipe_materi' => 'dokumen',
            'file_url' => 'test/exempted.pdf',
            'waktu_rilis' => $releaseTime,
            'batas_absensi' => $releaseTime->copy()->addHours(24),
            'auto_release' => false,
        ]);

        // Create exemption
        $exemption = ContentExemption::create([
            'id_siswa' => $siswa->id,
            'id_guru' => $pertemuan->id_guru,
            'tipe_konten' => 'materi',
            'id_konten' => $materi->id,
            'alasan' => 'Siswa sakit dengan surat dokter (TEST DATA)',
            'berlaku_hingga' => Carbon::now()->addWeek(),
        ]);

        $this->command->line("  ✓ Created: {$materi->judul}");
        $this->command->line("  ✓ Added exemption for: {$siswa->nama_lengkap}");
        $this->command->line("    Reason: {$exemption->alasan}");
        $this->command->line("    Valid until: {$exemption->berlaku_hingga->format('d M Y')}");
    }

    /**
     * Scenario 7: Already Attended Content
     */
    protected function createAttendedContent($pertemuan, $siswa)
    {
        $this->command->info('✅ Creating content with attendance already marked...');

        $releaseTime = Carbon::now()->subDays(1);
        $materi = Materi::create([
            'id_pertemuan' => $pertemuan->id,
            'id_mapel' => $pertemuan->JadwalBelajar?->id_mapel,
            'id_guru_mapel' => $pertemuan->JadwalBelajar?->id_guru_mapel,
            'judul' => '[TEST] Materi Sudah Diabsen',
            'deskripsi' => 'Siswa sudah absen untuk materi ini (tidak akan muncul modal)',
            'tipe_materi' => 'dokumen',
            'file_url' => 'test/attended.pdf',
            'waktu_rilis' => $releaseTime,
            'batas_absensi' => $releaseTime->copy()->addHours(24),
            'auto_release' => false,
        ]);

        // Mark attendance
        $waktuAbsen = $releaseTime->copy()->addMinutes(30);
        $absensi = Absensi::create([
            'id_pertemuan' => $pertemuan->id,
            'id_siswa' => $siswa->id,
            'tipe_konten' => 'materi',
            'id_konten' => $materi->id,
            'status' => 'hadir',
            'waktu_absen' => $waktuAbsen,
            'batas_waktu_absen' => $materi->batas_absensi,
            'status_keterlambatan' => 'tepat_waktu',
            'keterangan' => 'TEST DATA - Attended on time',
        ]);

        $this->command->line("  ✓ Created: {$materi->judul}");
        $this->command->line("  ✓ Attendance marked at: {$waktuAbsen->format('d M Y H:i')}");
        $this->command->line("    Status: {$absensi->status_keterlambatan}");
    }

    /**
     * Display summary
     */
    protected function displaySummary()
    {
        $this->command->info('');
        $this->command->info('📋 TEST DATA SUMMARY');
        $this->command->info('═══════════════════════════════════════════');
        
        $materis = Materi::where('judul', 'LIKE', '[TEST]%')->get();
        $tugas = Tugas::where('judul', 'LIKE', '[TEST]%')->get();
        $kuis = Kuis::where('judul', 'LIKE', '[TEST]%')->get();
        $exemptions = ContentExemption::where('alasan', 'LIKE', '%TEST DATA%')->count();
        $attendances = Absensi::where('keterangan', 'LIKE', '%TEST DATA%')->count();

        $this->command->table(
            ['Type', 'Count', 'Details'],
            [
                ['Materi', $materis->count(), implode(', ', $materis->pluck('status_label')->toArray())],
                ['Tugas', $tugas->count(), $tugas->count() . ' items created'],
                ['Kuis', $kuis->count(), $kuis->count() . ' items created'],
                ['Exemptions', $exemptions, $exemptions . ' active exemptions'],
                ['Attendances', $attendances, $attendances . ' marked'],
            ]
        );

        $this->command->info('');
        $this->command->info('🎯 TEST SCENARIOS CREATED:');
        $this->command->line('  1. ✅ Already released content (needs attendance)');
        $this->command->line('  2. 🔮 Future scheduled content (hidden from students)');
        $this->command->line('  3.  Recently released (tight deadline)');
        $this->command->line('  4. 📝 Tugas with various deadlines');
        $this->command->line('  5. 📊 Kuis with attendance gate');
        $this->command->line('  6. 🎫 Exempted content (skip attendance)');
        $this->command->line('  7. ✅ Already attended content (direct access)');
        
        $this->command->info('');
        $this->command->info('🧪 HOW TO TEST:');
        $this->command->line('  1. Login as siswa');
        $this->command->line('  2. Navigate to Materi page');
        $this->command->line('  3. Try accessing different test content');
        $this->command->line('  4. Observe different behaviors:');
        $this->command->line('     - Locked content (future release)');
        $this->command->line('     - Attendance modal (needs attendance)');
        $this->command->line('     - Direct access (exempted or already attended)');
        $this->command->line('  5. Mark attendance and see lateness calculation');
        $this->command->line('  6. Run: php artisan content:check-release');
        
        $this->command->info('');
        $this->command->info('✨ Test data ready for demo!');
    }
}
