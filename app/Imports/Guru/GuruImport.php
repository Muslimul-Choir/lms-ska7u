<?php

namespace App\Imports\Guru;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GuruImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading, SkipsOnError, SkipsOnFailure, SkipsEmptyRows
{
    use SkipsErrors;
    use SkipsFailures;

    /** Semua guru yang berhasil diproses (baru + restore) [['email'=>…, 'password'=>…]] */
    public array $imported = [];

    /** Guru lama (soft-deleted) yang di-restore [['email'=>…]] */
    public array $restored = [];

    /**
     * Baris yang di-skip beserta alasan.
     * [['row' => N, 'email' => '…', 'reason' => '…']]
     */
    public array $skipped = [];

    /**
     * Nomor baris global dalam file (bukan per-chunk).
     * Baris 1 = heading, data mulai dari 2.
     * Tidak di-reset antar chunk karena WithChunkReading
     * memanggil collection() berkali-kali secara berurutan.
     */
    private int $rowIndex = 1;

    // ─────────────────────────────────────────────────────────────────────────
    // Chunk size — 500 baris per chunk, sweet-spot untuk memory
    // ─────────────────────────────────────────────────────────────────────────
    public function chunkSize(): int
    {
        return 500;
    }

    public function headingRow(): int
    {
        return 1;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Validasi kolom wajib (Maatwebsite level)
    // ─────────────────────────────────────────────────────────────────────────
    public function rules(): array
    {
        return [
            '*.nama_lengkap' => ['required', 'string'],
            '*.email'        => ['required', 'email'],
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            '*.nama_lengkap' => 'Nama Lengkap',
            '*.email'        => 'Email',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            '*.nama_lengkap.required' => 'Baris :index, kolom :attribute wajib diisi.',
            '*.nama_lengkap.string'   => 'Baris :index, kolom :attribute harus berupa teks.',

            '*.email.required'        => 'Baris :index, kolom :attribute wajib diisi.',
            '*.email.email'           => 'Baris :index, kolom :attribute tidak valid.',
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Proses tiap chunk
    // ─────────────────────────────────────────────────────────────────────────
    public function collection(Collection $rows): void
    {
        // ── 1. Normalise & validasi ringan per baris ──────────────────────────
        $valid  = [];
        $emails = [];

        foreach ($rows as $row) {
            $this->rowIndex++;

            $data = $this->normaliseRow($row->toArray());

            if ($data === null) {
                continue;
            }

            $valid[]  = $data;
            $emails[] = $data['email'];
        }

        if (empty($valid)) {
            return;
        }

        // ── 2. Batch lookup — satu query per tabel per chunk ──────────────────
        $existingUsers = User::whereIn('email', $emails)
            ->pluck('email')
            ->flip()
            ->all();

        $existingGuru = Guru::withTrashed()
            ->with(['user' => fn($q) => $q->withTrashed()]) // eager load hindari N+1 saat restore
            ->whereIn('email', $emails)
            ->get()
            ->keyBy('email');

        // ── 3. Proses setiap baris valid ──────────────────────────────────────
        foreach ($valid as $data) {
            $email = $data['email'];

            try {
                // Email ada di User tapi TIDAK ada di Guru (aktif maupun trashed)
                // → email dipakai role lain (siswa, admin, dll)
                if (isset($existingUsers[$email]) && !isset($existingGuru[$email])) {
                    $this->addSkipped($data['row'], $email, 'Email sudah digunakan oleh akun non-guru');
                    continue;
                }

                /** @var Guru|null $guru */
                $guru = $existingGuru[$email] ?? null;

                if ($guru) {
                    if ($guru->trashed()) {
                        $this->restoreGuru($guru, $data);
                    } else {
                        $this->addSkipped($data['row'], $email, 'Guru dengan email ini sudah ada');
                    }
                } else {
                    $this->createGuru($data);
                }
            } catch (\Throwable $e) {
                Log::error('[GuruImport] Gagal proses baris', [
                    'row'   => $data['row'],
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
                $this->addSkipped($data['row'], $email, 'Kesalahan sistem: ' . $e->getMessage());
            }
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helper: normalise & validasi satu baris
    // Return array data siap pakai, atau null jika harus skip
    // ─────────────────────────────────────────────────────────────────────────
    private function normaliseRow(array $row): ?array
    {
        $email          = isset($row['email'])           ? trim((string) $row['email'])           : '';
        $namaLengkap    = isset($row['nama_lengkap'])    ? trim((string) $row['nama_lengkap'])    : '';
        $statusPengajar = isset($row['status_pengajar']) ? trim((string) $row['status_pengajar']) : 'pengajar';

        // Validasi kolom wajib
        if ($email === '') {
            $this->addSkipped($this->rowIndex, '-', 'Kolom email kosong');
            return null;
        }
        if ($namaLengkap === '') {
            $this->addSkipped($this->rowIndex, $email, 'Kolom nama_lengkap kosong');
            return null;
        }

        // Validasi format email dasar
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addSkipped($this->rowIndex, $email, 'Format email tidak valid');
            return null;
        }

        // Validasi & fallback status_pengajar
        $statusValid = ['pengajar', 'walikelas', 'keduanya'];
        if (!in_array(strtolower($statusPengajar), $statusValid, true)) {
            $statusPengajar = 'pengajar';
        }

        return [
            'row'            => $this->rowIndex,
            'email'          => $email,
            'nama_lengkap'   => $namaLengkap,
            'status_pengajar'=> strtolower($statusPengajar),
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helper: buat guru baru
    // Password di-generate di luar transaction agar DB lock tidak terlalu lama
    // ─────────────────────────────────────────────────────────────────────────
    private function createGuru(array $data): void
    {
        $plainPassword = Str::random(6) . rand(100, 999);

        DB::transaction(function () use ($data, $plainPassword) {
            $user = User::create([
                'name'              => $data['nama_lengkap'],
                'email'             => $data['email'],
                'password'          => Hash::make($plainPassword),
                'role'              => 'guru',
                'email_verified_at' => now(),
            ]);

            Guru::create([
                'id_user'         => $user->id,
                'nama_lengkap'    => $data['nama_lengkap'],
                'email'           => $data['email'],
                'status_pengajar' => $data['status_pengajar'],
            ]);

            $this->imported[] = [
                'email'    => $data['email'],
                'password' => $plainPassword,
            ];
        });
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helper: restore guru yang pernah di-delete
    // ─────────────────────────────────────────────────────────────────────────
    private function restoreGuru(Guru $guru, array $data): void
    {
        DB::transaction(function () use ($guru, $data) {
            $guru->restore();

            // Gunakan relasi yang sudah di-eager load, fallback query jika belum
            $user = $guru->relationLoaded('user')
                ? $guru->user  // ambil dari cache relasi, 0 query tambahan
                : $guru->user()->withTrashed()->first();

            if ($user?->trashed()) {
                $user->restore();
            }

            // Update data terkini
            $guru->update([
                'nama_lengkap'    => $data['nama_lengkap'],
                'status_pengajar' => $data['status_pengajar'],
            ]);

            $user?->update(['name' => $data['nama_lengkap']]);

            $this->imported[] = [
                'email'    => $data['email'],
                'password' => null, // password lama tetap dipakai
            ];

            $this->restored[] = [
                'email' => $data['email'],
            ];
        });
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helper: catat baris yang di-skip
    // ─────────────────────────────────────────────────────────────────────────
    private function addSkipped(int $row, string $email, string $reason): void
    {
        $this->skipped[] = [
            'row'    => $row,
            'email'  => $email,
            'reason' => $reason,
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Summary methods — panggil dari controller setelah import selesai
    // ─────────────────────────────────────────────────────────────────────────

    /** Jumlah guru baru yang berhasil dibuat (tidak termasuk restore) */
    public function totalCreated(): int
    {
        return count($this->imported) - count($this->restored);
    }

    /** Jumlah guru yang di-restore */
    public function totalRestored(): int
    {
        return count($this->restored);
    }

    /** Jumlah baris yang di-skip */
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