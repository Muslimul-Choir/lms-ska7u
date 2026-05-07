<?php

namespace App\Imports\Guru;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GuruImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsEmptyRows
{
    use SkipsErrors;

    public array $imported = [];
    public array $restored = [];

    public function model(array $row)
    {
        // Ambil hanya kolom yang dibutuhkan, abaikan kolom lain (No, dsb.)
        $email          = isset($row['email'])          ? trim((string) $row['email'])          : '';
        $namaLengkap    = isset($row['nama_lengkap'])   ? trim((string) $row['nama_lengkap'])   : '';
        $statusPengajar = isset($row['status_pengajar']) ? trim((string) $row['status_pengajar']) : 'pengajar';

        // Skip baris jika kolom wajib kosong
        if ($email === '' || $namaLengkap === '') {
            return null;
        }

        // Validasi & fallback status_pengajar
        $statusValid = ['pengajar', 'walikelas', 'keduanya'];
        if (!in_array(strtolower($statusPengajar), $statusValid)) {
            $statusPengajar = 'pengajar';
        }

        // Cek email sudah ada (aktif atau trash)
        $existingGuru = Guru::withTrashed()->where('email', $email)->first();

        if ($existingGuru) {
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

                $this->imported[] = ['email' => $email, 'password' => null];
                $this->restored[] = ['email' => $email];
            }

            // Jika aktif → skip
            return null;
        }

        // Data baru
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