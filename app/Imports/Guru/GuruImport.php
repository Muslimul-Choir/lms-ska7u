<?php

namespace App\Imports\Guru;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class GuruImport implements ToCollection, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    // Simpan password plain agar bisa dikirim email (opsional)
    public array $imported = [];

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                // Normalize keys to lowercase for case-insensitive matching
                $row = array_change_key_case($row->toArray(), CASE_LOWER);

                $email           = trim($row['email'] ?? '');
                $namaLengkap     = trim($row['nama_lengkap'] ?? '');
                $statusPengajar  = trim($row['status_pengajar'] ?? '');

                // Validate required fields
                if (empty($namaLengkap) || empty($email)) {
                    // Skip invalid rows
                    continue;
                }

                $statusPengajar = in_array(strtolower($statusPengajar), ['pengajar', 'walikelas', 'keduanya'])
                    ? $statusPengajar
                    : 'pengajar';

                // ── Cek apakah email sudah ada (aktif atau di trash) 
                $existingGuru = Guru::withTrashed()->where('email', $email)->first();

                if ($existingGuru) {
                    // Jika ada di trash → restore + update data
                    if ($existingGuru->trashed()) {
                        $existingGuru->restore();
                        $existingGuru->user()->withTrashed()->restore();

                        $existingGuru->update([
                            'nama_lengkap'    => $namaLengkap,
                            'status_pengajar' => $statusPengajar,
                        ]);

                        $existingGuru->user()->withTrashed()->first()?->update([
                            'name' => $namaLengkap,
                        ]);
                    }

                    // Jika aktif → skip (sudah ada, tidak perlu apa-apa)
                    continue;
                }

                // ── Data baru → buat user + guru ─────────────────────────
                $plainPassword = Str::random(6) . rand(100, 999);

                $user = User::create([
                    'name'              => $namaLengkap,
                    'email'             => $email,
                    'password'          => Hash::make($plainPassword),
                    'role'              => 'guru',
                    'email_verified_at' => now(),
                ]);

                Guru::create([
                    'id_user'         => $user->id,
                    'nama_lengkap'    => $namaLengkap,
                    'email'           => $email,
                    'status_pengajar' => $statusPengajar,
                ]);

                $this->imported[] = [
                    'email'    => $email,
                    'password' => $plainPassword,
                ];
            }
        });
    }

    public function headingRow(): int
    {
        return 1;
    }
}
