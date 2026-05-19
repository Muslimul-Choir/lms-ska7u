<?php

namespace App\Exports\Guru;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuruExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return Guru::select([
            'id',
            'nama_lengkap',
            'email',
            'status_pengajar',
            'created_at'
        ]);
    }
    
 
    public function headings(): array
    {
        return ['No', 'Nama Lengkap', 'Email', 'Status Pengajar', 'Dibuat'];
    }
 
    private int $no = 0;
    public function map($guru): array
    {
        $this->no++;
        return [
            $this->no,
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
