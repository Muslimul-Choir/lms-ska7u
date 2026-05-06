<?php

namespace App\Exports\Siswa;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Siswa::with(['Kelas.Tingkatan', 'Kelas.Jurusan', 'Kelas.Bagian'])->get();
    }

    public function headings(): array
    {
        return ['No', 'Nama Lengkap', 'Email', 'Tanggal Lahir', 'Agama', 'Kelas', 'Dibuat'];
    }

    public function map($siswa): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $siswa->nama_lengkap,
            $siswa->email,
            $siswa->tanggal_lahir->format('d/m/Y'),
            $siswa->agama,
            $siswa->Kelas?->nama_kelas ?? '-',
            $siswa->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF4F46E7']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
