<?php

namespace App\Imports\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Traits\GeneratesPasswordFromBirthDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsEmptyRows
{
    use SkipsErrors;
    use GeneratesPasswordFromBirthDate;

    public array $imported = [];
    public array $restored = [];

    // Cache kelas agar tidak query DB setiap baris
    private ?object $kelasCache = null;

    private function getKelasCache(): object
    {
        if ($this->kelasCache === null) {
            $this->kelasCache = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->get();
        }
        return $this->kelasCache;
    }

    public function model(array $row)
    {
        // Ambil hanya kolom yang dibutuhkan, abaikan kolom lain (No, dsb.)
        $email       = isset($row['email'])       ? trim((string) $row['email'])       : '';
        $namaLengkap = isset($row['nama_lengkap']) ? trim((string) $row['nama_lengkap']) : '';
        $agama       = isset($row['agama'])        ? trim((string) $row['agama'])        : 'Islam';
        $namaKelas   = isset($row['kelas'])        ? trim((string) $row['kelas'])        : '';

        // Skip baris jika kolom wajib kosong (handle baris tidak lengkap)
        if ($email === '' || $namaLengkap === '' || $namaKelas === '') {
            return null;
        }

        // Validasi & fallback agama
        $agamaValid = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        if (!in_array($agama, $agamaValid)) {
            $agama = 'Islam';
        }

        // Cari kelas dari cache
        $kelas = $this->getKelasCache()->firstWhere('nama_kelas', $namaKelas);
        if (!$kelas) return null;

        // Parse tanggal lahir
        $tanggalLahir = $this->parseTanggalLahir($row['tanggal_lahir'] ?? null);
        if (!$tanggalLahir) return null; // skip jika tanggal tidak valid

        // Cek email sudah ada (aktif atau trash)
        $existingSiswa = Siswa::withTrashed()->where('email', $email)->first();

        if ($existingSiswa) {
            if ($existingSiswa->trashed()) {
                $existingSiswa->restore();
                $existingSiswa->User()->withTrashed()->restore();

                $existingSiswa->update([
                    'nama_lengkap'  => $namaLengkap,
                    'agama'         => $agama,
                    'id_kelas'      => $kelas->id,
                    'tanggal_lahir' => $tanggalLahir->toDateString(),
                ]);

                $existingSiswa->User()->withTrashed()->first()?->update([
                    'name' => $namaLengkap,
                ]);

                $this->imported[] = [
                    'email'    => $email,
                    'password' => null, 
                ];

                $this->restored[] = [
                    'email' => $email
                ];
            }
            // Jika aktif → skip
            return null;
        }

        // Buat data baru
        $plainPassword = $this->generatePasswordFromBirthDate($tanggalLahir);

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
            'id_user'       => $user->id,
            'nama_lengkap'  => $namaLengkap,
            'email'         => $email,
            'agama'         => $agama,
            'id_kelas'      => $kelas->id,
            'tanggal_lahir' => $tanggalLahir->toDateString(),
        ]);
    }

    private function parseTanggalLahir(mixed $value): ?Carbon
    {
        if ($value === null || $value === '') return null;

        // Angka serial Excel (kolom bertipe Date di Excel)
        if (is_numeric($value)) {
            try {
                return Carbon::instance(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $value)
                )->startOfDay();
            } catch (\Exception) {
                return null;
            }
        }

        // Jika sudah berupa objek DateTime/Carbon (kadang Maatwebsite parse otomatis)
        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value)->startOfDay();
        }

        $value = trim((string) $value);
        if ($value === '') return null;

        // Format DD/MM/YYYY
        try {
            $parsed = Carbon::createFromFormat('d/m/Y', $value);
            // Pastikan hasil parse benar-benar cocok (hindari false positive Carbon)
            if ($parsed && $parsed->format('d/m/Y') === $value) {
                return $parsed->startOfDay();
            }
        } catch (\Exception) {
            // lanjut
        }

        return null;
    }

    public function rules(): array
    {
        return [
            // Validasi hanya kolom yang relevan
            // Kolom lain seperti "no" diabaikan otomatis
            'nama_lengkap' => ['required', 'string'],
            'email'        => ['required', 'email'],
            'kelas'        => ['required', 'string'],
            // tanggal_lahir tidak divalidasi di sini karena
            // sudah di-handle manual di model() via parseTanggalLahir()
            // agar pesan error lebih terkontrol
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}
