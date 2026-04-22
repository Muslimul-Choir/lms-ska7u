<?php

namespace Database\Seeders;

use App\Models\Bagian;
use Illuminate\Database\Seeder;

class BagianSeeder extends Seeder
{
    
    public function run(): void
    {
        $bagians = [
            [
                'nama_bagian' => 'HRD',
                'keterangan'  => 'Mengelola sumber daya manusia dan ketenagakerjaan.',
            ],
            [
                'nama_bagian' => 'Keuangan',
                'keterangan'  => 'Mengelola anggaran, laporan keuangan, dan pembayaran.',
            ],
            [
                'nama_bagian' => 'IT',
                'keterangan'  => 'Mengelola infrastruktur teknologi informasi perusahaan.',
            ],
            [
                'nama_bagian' => 'Marketing',
                'keterangan'  => 'Mengelola pemasaran produk dan layanan perusahaan.',
            ],
            [
                'nama_bagian' => 'Operasional',
                'keterangan'  => 'Mengelola kegiatan operasional harian perusahaan.',
            ],
            [
                'nama_bagian' => 'Produksi',
                'keterangan'  => 'Bertanggung jawab atas proses produksi dan kualitas.',
            ],
            [
                'nama_bagian' => 'Logistik',
                'keterangan'  => 'Mengelola pengiriman, penerimaan, dan distribusi barang.',
            ],
            [
                'nama_bagian' => 'Legal',
                'keterangan'  => 'Menangani urusan hukum dan kepatuhan regulasi.',
            ],
        ];

        foreach ($bagians as $bagian) {
            Bagian::firstOrCreate(
                ['nama_bagian' => $bagian['nama_bagian']],
                ['keterangan'  => $bagian['keterangan']]
            );
        }

        $this->command->info('BagianSeeder: ' . count($bagians) . ' data berhasil di-seed.');
    }
}