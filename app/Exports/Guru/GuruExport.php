<?php

namespace App\Exports\Guru;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuruExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
     public function collection()
    {
        return Guru::withTrashed(false)->get();
    }
 
    public function headings(): array
    {
        return ['No', 'Nama Lengkap', 'Email', 'Status Pengajar', 'Dibuat'];
    }
 
    public function map($guru): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $guru->nama_lengkap,
            $guru->email,
            ucfirst($guru->status_pengajar),
            $guru->created_at->format('d/m/Y'),
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
