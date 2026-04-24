<?php

namespace App\Imports\Guru;

use App\Models\Guru;
use App\Models\User;
// use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class GuruImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    // Simpan password plain agar bisa dikirim email (opsional)
    public array $imported = [];

    public function model(array $row)
    {
        $email           = trim($row['email']);
        $namaLengkap     = trim($row['nama_lengkap']);
        $statusPengajar  = in_array($row['status_pengajar'] ?? '', ['pengajar', 'walikelas', 'keduanya'])
            ? $row['status_pengajar']
            : 'pengajar';

        // ── Cek apakah email sudah ada (aktif atau di trash) ──────
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
            return null;
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

        $this->imported[] = [
            'email'    => $email,
            'password' => $plainPassword,
        ];

        return new Guru([
            'id_user'         => $user->id,
            'nama_lengkap'    => $namaLengkap,
            'email'           => $email,
            'status_pengajar' => $statusPengajar,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string'],
            'email'        => ['required', 'email'],
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}
