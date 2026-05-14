<?php

namespace App\Imports\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Traits\GeneratesPasswordFromBirthDate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class SiswaImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading, SkipsOnError, SkipsOnFailure, SkipsEmptyRows
{
    use SkipsErrors;
    use SkipsFailures;
    use GeneratesPasswordFromBirthDate;
    public array $imported = [];
    public array $restored = [];
    public array $skipped = [];
 
    // ── Internal cache ────────────────────────────────────────────────────────

    /** @var Collection<int, Kelas>|null */
    private ?Collection $kelasCache = null;

    public function chunkSize(): int
    {
        return 500;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            '*.nama_lengkap' => ['required', 'string'],
            '*.email'        => ['required', 'email'],
            '*.kelas'        => ['required', 'string'],
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            '*.nama_lengkap' => 'Nama Lengkap',
            '*.email'        => 'Email',
            '*.kelas'        => 'Kelas',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            '*.nama_lengkap.required' => 'Baris :index, kolom :attribute wajib diisi.',
            '*.nama_lengkap.string'   => 'Baris :index, kolom :attribute harus berupa teks.',

            '*.email.required'        => 'Baris :index, kolom :attribute wajib diisi.',
            '*.email.email'           => 'Baris :index, kolom :attribute tidak valid.',

            '*.kelas.required'        => 'Baris :index, kolom :attribute wajib diisi.',
            '*.kelas.string'          => 'Baris :index, kolom :attribute harus berupa teks.',
        ];
    }

    /**
     * Nomor baris global dalam file (bukan per-chunk).
     * Baris 1 = heading, data mulai dari 2.
     * Tidak di-reset antar chunk karena WithChunkReading
     * memanggil collection() berkali-kali secara berurutan.
     */
    private int $rowIndex = 1;

    // ─────────────────────────────────────────────────────────────────────────
    // Proses tiap chunk
    // ─────────────────────────────────────────────────────────────────────────
    public function collection(Collection $rows): void
    {
        $kelasList = $this->getKelasCollection();

        $valid   = [];
        $emails  = [];

        foreach ($rows as $row) {
            $this->rowIndex++;

            $data = $this->normaliseRow($row->toArray());

            if ($data === null) {
                continue;
            }

            $kelas = $kelasList->firstWhere('nama_kelas', $data['nama_kelas']);
            if (!$kelas) {
                $this->addSkipped($this->rowIndex, $data['email'], "Kelas '{$data['nama_kelas']}' tidak ditemukan");
                continue;
            }

            $data['kelas_id'] = $kelas->id;
            $valid[]          = $data;
            $emails[]         = $data['email'];
        }

        if (empty($valid)) {
            return;
        }

        $existingUsers = User::whereIn('email', $emails)
            ->pluck('email')
            ->flip()
            ->all();

        $existingSiswa = Siswa::withTrashed()
            ->with(['User' => fn($q) => $q->withTrashed()])
            ->whereIn('email', $emails)
            ->get()
            ->keyBy('email');

        foreach ($valid as $data) {
            $email = $data['email'];

            try {
                // Jika email ada di User tapi TIDAK ada di Siswa (aktif maupun trashed)
                if (isset($existingUsers[$email]) && !isset($existingSiswa[$email])) {
                    $this->addSkipped($data['row'], $email, 'Email sudah digunakan oleh akun non-siswa');
                    continue;
                }

                /** @var Siswa|null $siswa */
                $siswa = $existingSiswa[$email] ?? null;

                if ($siswa) {
                    if ($siswa->trashed()) {
                        $this->restoreSiswa($siswa, $data);
                    } else {
                        $this->addSkipped($data['row'], $email, 'Siswa dengan email ini sudah ada');
                    }
                } else {
                    $this->createSiswa($data);
                }
            } catch (\Throwable $e) {
                Log::error('[SiswaImport] Gagal proses baris', [
                    'row'   => $data['row'],
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
                $this->addSkipped($data['row'], $email, 'Kesalahan sistem: ' . $e->getMessage());
            }
        }
    }

    private function normaliseRow(array $row): ?array
    {
        $email       = isset($row['email'])        ? trim((string) $row['email'])        : '';
        $namaLengkap = isset($row['nama_lengkap']) ? trim((string) $row['nama_lengkap']) : '';
        $namaKelas   = isset($row['kelas'])         ? trim((string) $row['kelas'])        : '';
        $agama       = isset($row['agama'])         ? trim((string) $row['agama'])        : 'Islam';

        // Validasi kolom wajib
        if ($email === '') {
            $this->addSkipped($this->rowIndex, '-', 'Kolom email kosong');
            return null;
        }
        if ($namaLengkap === '') {
            $this->addSkipped($this->rowIndex, $email, 'Kolom nama_lengkap kosong');
            return null;
        }
        if ($namaKelas === '') {
            $this->addSkipped($this->rowIndex, $email, 'Kolom kelas kosong');
            return null;
        }

        // Validasi format email dasar
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addSkipped($this->rowIndex, $email, 'Format email tidak valid');
            return null;
        }

        // Fallback agama
        $agamaValid = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        if (!in_array($agama, $agamaValid, true)) {
            $agama = 'Islam';
        }

        // Parse tanggal lahir
        $tanggalLahir = $this->parseTanggalLahir($row['tanggal_lahir'] ?? null);
        if (!$tanggalLahir) {
            $this->addSkipped($this->rowIndex, $email, 'Tanggal lahir tidak valid atau kosong');
            return null;
        }

        return [
            'row'          => $this->rowIndex,
            'email'        => $email,
            'nama_lengkap' => $namaLengkap,
            'nama_kelas'   => $namaKelas,
            'agama'        => $agama,
            'tanggal_lahir' => $tanggalLahir,
        ];
    }

    private function createSiswa(array $data): void
    {
        $plainPassword = $this->generatePasswordFromBirthDate($data['tanggal_lahir']);
        DB::transaction(function () use ($data, $plainPassword) {

            $user = User::create([
                'name'              => $data['nama_lengkap'],
                'email'             => $data['email'],
                'password'          => Hash::make($plainPassword),
                'role'              => 'siswa',
                'email_verified_at' => now(),
            ]);

            Siswa::create([
                'id_user'       => $user->id,
                'nama_lengkap'  => $data['nama_lengkap'],
                'email'         => $data['email'],
                'agama'         => $data['agama'],
                'id_kelas'      => $data['kelas_id'],
                'tanggal_lahir' => $data['tanggal_lahir']->toDateString(),
            ]);

            $this->imported[] = [
                'email'    => $data['email'],
                'password' => $plainPassword,
            ];
        });
    }

    private function restoreSiswa(Siswa $siswa, array $data): void
    {
        DB::transaction(function () use ($siswa, $data) {
            $siswa->restore();

            // Gunakan relasi yang sudah di-eager load, fallback query jika belum
            $user = $siswa->relationLoaded('User')
                ? $siswa->User  // ← ambil dari cache relasi, 0 query
                : $siswa->User()->withTrashed()->first();

            if ($user?->trashed()) {
                $user->restore();
            }

            // Update data terkini
            $siswa->update([
                'nama_lengkap'  => $data['nama_lengkap'],
                'agama'         => $data['agama'],
                'id_kelas'      => $data['kelas_id'],
                'tanggal_lahir' => $data['tanggal_lahir']->toDateString(),
            ]);

            $user?->update(['name' => $data['nama_lengkap']]);

            $this->imported[] = [
                'email'    => $data['email'],
                'password' => null,
            ];

            $this->restored[] = [
                'email' => $data['email'],
            ];
        });
    }

    private function addSkipped(int $row, string $email, string $reason): void
    {
        $this->skipped[] = [
            'row'    => $row,
            'email'  => $email,
            'reason' => $reason,
        ];
    }

    private function getKelasCollection(): Collection
    {
        if ($this->kelasCache === null) {
            $this->kelasCache = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->get();
        }

        return $this->kelasCache;
    }

    private function parseTanggalLahir(mixed $value): ?Carbon
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Angka serial Excel
        if (is_numeric($value)) {
            try {
                return Carbon::instance(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $value)
                )->startOfDay();
            } catch (\Exception) {
                return null;
            }
        }

        // Objek DateTime/Carbon (Maatwebsite parse otomatis)
        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value)->startOfDay();
        }

        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        // Format DD/MM/YYYY
        try {
            $parsed = Carbon::createFromFormat('d/m/Y', $value);
            if ($parsed && $parsed->format('d/m/Y') === $value) {
                return $parsed->startOfDay();
            }
        } catch (\Exception) {
            // tidak valid
        }

        return null;
    }
    public function totalCreated(): int
    {
        return count($this->imported) - count($this->restored);
    }

    public function totalRestored(): int
    {
        return count($this->restored);
    }

    public function totalSkipped(): int
    {
        return count($this->skipped);
    }

    /**
     * Summary lengkap untuk ditampilkan ke user.
     *
     * @return array{created: int, restored: int, skipped: int, skipped_details: array}
     */
    public function getSummary(): array
    {
        return [
            'created'         => $this->totalCreated(),
            'restored'        => $this->totalRestored(),
            'skipped'         => $this->totalSkipped(),
            'skipped_details' => $this->skipped,
        ];
    }
}
