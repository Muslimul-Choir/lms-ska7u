<?php

namespace App\Imports\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Traits\GeneratesPasswordFromBirthDate;
use Carbon\Carbon;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;
    use GeneratesPasswordFromBirthDate;

    public array $imported = [];

    public function model(array $row)
    {
        $email        = trim($row['email']);
        $namaLengkap  = trim($row['nama_lengkap']);
        $agama        = trim($row['agama'] ?? 'Islam');
        $namaKelas    = trim($row['kelas'] ?? '');

        // Validasi agama
        $agamaValid = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        if (!in_array($agama, $agamaValid)) {
            $agama = 'Islam';
        }

        // Cari kelas berdasarkan nama_kelas (menggunakan accessor)
        $allKelas = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->get();
        $kelas = $allKelas->firstWhere('nama_kelas', $namaKelas);
        if (!$kelas) return null; // skip jika kelas tidak ditemukan

        // Cek email sudah ada (aktif atau trash)
        $existingSiswa = Siswa::withTrashed()->where('email', $email)->first();

        if ($existingSiswa) {
            if ($existingSiswa->trashed()) {
                // Restore + update data
                $existingSiswa->restore();
                $existingSiswa->User()->withTrashed()->restore();

                $tanggalLahirRestore = $this->parseTanggalLahir($row['tanggal_lahir'] ?? null);

                $existingSiswa->update([
                    'nama_lengkap'  => $namaLengkap,
                    'agama'         => $agama,
                    'id_kelas'      => $kelas->id,
                    'tanggal_lahir' => $tanggalLahirRestore?->toDateString(),
                ]);

                $existingSiswa->User()->withTrashed()->first()?->update([
                    'name' => $namaLengkap,
                ]);
            }
            // Jika aktif → skip
            return null;
        }

        // Data baru
        $tanggalLahir  = $this->parseTanggalLahir($row['tanggal_lahir'] ?? null);
        $plainPassword = $tanggalLahir
            ? $this->generatePasswordFromBirthDate($tanggalLahir)
            : Str::random(6) . rand(100, 999); // fallback jika tanggal kosong

        $user = User::create([
            'name'              => $namaLengkap,
            'email'             => $email,
            'password'          => Hash::make($plainPassword),
            'role'              => 'siswa',
            'email_verified_at' => now(),
        ]);

        $this->imported[] = [
            'email'    => $email,
            'password' => $plainPassword,
        ];

        return new Siswa([
            'id_user'        => $user->id,
            'nama_lengkap'   => $namaLengkap,
            'email'          => $email,
            'agama'          => $agama,
            'id_kelas'       => $kelas->id,
            'tanggal_lahir'  => $tanggalLahir?->toDateString(),
        ]);
    }

    private function parseTanggalLahir(mixed $value): ?Carbon
{
    if (empty($value)) return null;

    // Angka serial Excel (otomatis dikonversi Excel saat kolom bertipe Date)
    if (is_numeric($value)) {
        return Carbon::instance(
            \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $value)
        )->startOfDay();
    }

    $value = trim((string) $value);
    if ($value === '') return null;

    try {
        return Carbon::createFromFormat('d/m/Y', $value)->startOfDay();
    } catch (\Exception) {
        return null;
    }
}

    public function rules(): array
    {
        return [
            'nama_lengkap'  => ['required', 'string'],
            'email'         => ['required', 'email'],
            'kelas'         => ['required', 'string'],
            'tanggal_lahir' => ['required'],
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}
