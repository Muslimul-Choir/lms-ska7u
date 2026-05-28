<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Pengumpulan Tugas - {{ $tugas->judul }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #f59e0b;
        }
        
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 14pt;
            color: #6b7280;
            font-weight: normal;
            margin-bottom: 3px;
        }
        
        .header .date {
            font-size: 9pt;
            color: #9ca3af;
            margin-top: 5px;
        }
        
        .info-section {
            background-color: #fffbeb;
            border: 1px solid #fcd34d;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
        }
        
        .info-section h3 {
            font-size: 12pt;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #6b7280;
            padding: 3px 10px 3px 0;
            width: 30%;
        }
        
        .info-value {
            display: table-cell;
            color: #1f2937;
            padding: 3px 0;
        }
        
        .statistics {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        
        .stat-box {
            display: table-cell;
            text-align: center;
            padding: 12px;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }
        
        .stat-box.blue {
            background-color: #eff6ff;
            border-color: #bfdbfe;
        }
        
        .stat-box.green {
            background-color: #ecfdf5;
            border-color: #a7f3d0;
        }
        
        .stat-box.purple {
            background-color: #f5f3ff;
            border-color: #ddd6fe;
        }
        
        .stat-number {
            font-size: 24pt;
            font-weight: bold;
            display: block;
            margin-bottom: 3px;
        }
        
        .stat-box.blue .stat-number {
            color: #1e40af;
        }
        
        .stat-box.green .stat-number {
            color: #047857;
        }
        
        .stat-box.purple .stat-number {
            color: #6d28d9;
        }
        
        .stat-label {
            font-size: 8pt;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        table.data-table thead {
            background-color: #f9fafb;
        }
        
        table.data-table th {
            padding: 8px 6px;
            text-align: left;
            font-size: 8pt;
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            border-bottom: 2px solid #e5e7eb;
            letter-spacing: 0.5px;
        }
        
        table.data-table td {
            padding: 8px 6px;
            font-size: 9pt;
            border-bottom: 1px solid #f3f4f6;
        }
        
        table.data-table tbody tr:hover {
            background-color: #fffbeb;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .badge.success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .badge.danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .badge.warning {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }
        
        .badge.purple {
            background-color: #ede9fe;
            color: #5b21b6;
            border: 1px solid #c4b5fd;
        }
        
        .badge.amber {
            background-color: #fef3c7;
            color: #78350f;
            border: 1px solid #fcd34d;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 8pt;
            color: #9ca3af;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #9ca3af;
            font-style: italic;
        }
        
        .nilai-cell {
            font-weight: bold;
            color: #6d28d9;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Rekap Pengumpulan Tugas</h1>
        <h2>{{ $tugas->judul }}</h2>
        <div class="date">Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB</div>
    </div>

    <!-- Task Information -->
    <div class="info-section">
        <h3>Informasi Tugas</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Mata Pelajaran:</div>
                <div class="info-value">{{ $tugas->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Kelas:</div>
                <div class="info-value">{{ $tugas->GuruMapel?->Kelas?->nama_kelas ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Guru:</div>
                <div class="info-value">{{ $tugas->Guru?->nama_lengkap ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tipe Tugas:</div>
                <div class="info-value">{{ ucfirst($tugas->tipe_tugas) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Batas Waktu:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d F Y, H:i') }} WIB</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nilai Maksimal:</div>
                <div class="info-value">{{ $tugas->nilai_maksimal }}</div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <table class="statistics">
        <tr>
            <td class="stat-box blue">
                <span class="stat-number">{{ $statistik['total'] }}</span>
                <span class="stat-label">Total Siswa</span>
            </td>
            <td class="stat-box green">
                <span class="stat-number">{{ $statistik['sudah_mengumpulkan'] }}</span>
                <span class="stat-label">Sudah Mengumpulkan</span>
            </td>
            <td class="stat-box purple">
                <span class="stat-number">{{ $statistik['sudah_dinilai'] }}</span>
                <span class="stat-label">Sudah Dinilai</span>
            </td>
        </tr>
    </table>

    <!-- Student List -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Nama Siswa</th>
                <th style="width: 12%;">NIS</th>
                <th style="width: 18%;">Status Pengumpulan</th>
                <th style="width: 18%;">Status Penilaian</th>
                <th style="width: 10%;">Nilai</th>
                <th style="width: 12%;">Waktu Pengumpulan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapData as $index => $item)
            <tr>
                <td style="text-align: center; color: #9ca3af;">{{ $index + 1 }}</td>
                <td style="font-weight: 600;">{{ $item['siswa']->nama_lengkap }}</td>
                <td style="color: #6b7280;">{{ $item['siswa']->nis }}</td>
                <td>
                    @if($item['submission'])
                        <span class="badge success">Sudah Mengumpulkan</span>
                    @else
                        <span class="badge danger">Belum Mengumpulkan</span>
                    @endif
                </td>
                <td>
                    @if($item['penilaian'])
                        <span class="badge purple">Sudah Dinilai</span>
                    @elseif($item['submission'])
                        <span class="badge amber">Menunggu Dinilai</span>
                    @else
                        <span style="color: #d1d5db;">-</span>
                    @endif
                </td>
                <td class="nilai-cell">
                    @if($item['penilaian'])
                        {{ number_format($item['penilaian']->nilai, 1) }}
                    @else
                        <span style="color: #d1d5db;">-</span>
                    @endif
                </td>
                <td style="font-size: 8pt; color: #6b7280;">
                    @if($item['submission'])
                        {{ \Carbon\Carbon::parse($item['submission']->created_at)->format('d/m/Y H:i') }}
                    @else
                        <span style="color: #d1d5db;">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="no-data">Tidak ada data siswa</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh LMS SKA7U</p>
        <p>© {{ date('Y') }} LMS SKA7U - Sistem Manajemen Pembelajaran</p>
    </div>
</body>
</html>
