<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Rekap Pengumpulan Tugas
                </h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">
                    Konten & Evaluasi
                </p>
            </div>
        </div>
    </x-slot>

    <x-slot name="breadcrumb">
        <a href="{{ route('dashboard') }}" class="text-amber-600 hover:text-amber-700 transition">Dashboard</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        @if($source === 'penilaian')
            <a href="{{ route('penilaian.index') }}" class="text-amber-600 hover:text-amber-700 transition">Penilaian</a>
        @else
            <a href="{{ route('tugas.index') }}" class="text-amber-600 hover:text-amber-700 transition">Tugas</a>
        @endif
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-600 font-semibold">Rekap Pengumpulan</span>
    </x-slot>

    <style>
        @media print {

            /* Hide navigation, header, breadcrumb, and action buttons when printing */
            nav,
            header,
            .breadcrumb,
            button,
            a[href*="tugas.index"],
            .aksi-cell {
                display: none !important;
            }

            /* Adjust layout for print */
            body {
                background: white !important;
            }

            .py-7 {
                padding: 0 !important;
            }

            .bg-gray-50 {
                background: white !important;
            }

            /* Ensure table fits on page */
            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            /* Add page header */
            @page {
                margin: 2cm;
            }
        }
    </style>

    <div class="bg-gray-50 min-h-screen" x-data="penilaianModal()">
        <div class="max-w-7xl mx-auto space-y-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">

                    @if (session('success'))
                        <div
                            class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm mb-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div
                            class="flex items-center justify-between px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm mb-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mb-5 flex items-center justify-between gap-3">
                        @if($source === 'penilaian')
                            <a href="{{ route('penilaian.index') }}"
                                class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali ke Penilaian
                            </a>
                        @else
                            <a href="{{ route('tugas.index') }}"
                                class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali ke Daftar Tugas
                            </a>
                        @endif

                        <div class="flex items-center gap-2">
                            <!-- Print Button -->
                            <button onclick="window.print()"
                                class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 px-4 rounded-lg transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print
                            </button>

                            <!-- Export PDF Button -->
                            <a href="{{ route('tugas.rekap.export-pdf', $tugas) }}"
                                class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 px-4 rounded-lg transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export PDF
                            </a>
                        </div>
                    </div>

                    <!-- Task Info -->
                    <div class="mb-5 p-5 bg-amber-50 border border-amber-100 rounded-xl">
                        <h3 class="font-bold text-base text-gray-900 mb-3">{{ $tugas->judul }}</h3>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-gray-500 font-semibold">Mapel:</span>
                                <span class="text-gray-700">{{ $tugas->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-500 font-semibold">Tipe:</span>
                                <span
                                    class="px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full text-xs font-bold uppercase">{{ ucfirst($tugas->tipe_tugas) }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-500 font-semibold">Batas Waktu:</span>
                                <span
                                    class="text-gray-700">{{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics (Req 4.3) -->
                    <div class="grid grid-cols-3 gap-4 mb-5">
                        <div class="bg-blue-50 border border-blue-100 p-5 rounded-xl text-center">
                            <div class="text-3xl font-bold text-blue-700">{{ $statistik['total'] }}</div>
                            <div class="text-xs text-gray-600 mt-1 uppercase tracking-wider font-semibold">Total Siswa
                            </div>
                        </div>
                        <div class="bg-emerald-50 border border-emerald-100 p-5 rounded-xl text-center">
                            <div class="text-3xl font-bold text-emerald-700">{{ $statistik['sudah_mengumpulkan'] }}
                            </div>
                            <div class="text-xs text-gray-600 mt-1 uppercase tracking-wider font-semibold">Sudah
                                Mengumpulkan</div>
                        </div>
                        <div class="bg-purple-50 border border-purple-100 p-5 rounded-xl text-center">
                            <div class="text-3xl font-bold text-purple-700">{{ $statistik['sudah_dinilai'] }}</div>
                            <div class="text-xs text-gray-600 mt-1 uppercase tracking-wider font-semibold">Sudah
                                Dinilai</div>
                        </div>
                    </div>

                    @if (!$isCreator)
                        <div
                            class="p-4 mb-4 text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Hanya guru pembuat tugas yang dapat menilai pengumpulan.</span>
                        </div>
                    @endif

                    <!-- Student List Table (Req 2.1, 2.2, 3.1, 3.2) -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th
                                        class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                        Nama Siswa</th>
                                    <th
                                        class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                        Status Pengumpulan</th>
                                    <th
                                        class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                        File Lampiran</th>
                                    <th
                                        class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                        Status Penilaian</th>
                                    <th
                                        class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                        Nilai</th>
                                    @if ($isCreator)
                                        <th
                                            class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                            Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($rekapData as $index => $item)
                                    <tr class="hover:bg-amber-50/40 transition"
                                        data-siswa-id="{{ $item['siswa']->id }}"
                                        data-submission-id="{{ $item['submission']?->id }}">
                                        <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900 text-sm">
                                                {{ $item['siswa']->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500">{{ $item['siswa']->nis }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($item['submission'])
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border-emerald-200">
                                                    Sudah Mengumpulkan
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-red-50 text-red-700 border-red-200">
                                                    Belum Mengumpulkan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            @if ($item['submission'] && $item['submission']->file_url)
                                                @php
                                                    $fileUrl = $item['submission']->file_url;
                                                    $isUrl = str_starts_with($fileUrl, 'http');
                                                    $filePath = $isUrl ? $fileUrl : asset('storage/' . $fileUrl);
                                                    $extension = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));
                                                    
                                                    // Determine file type
                                                    $fileIcon = '📄';
                                                    $bgColor = 'bg-blue-50';
                                                    $textColor = 'text-blue-700';
                                                    $borderColor = 'border-blue-200';
                                                    
                                                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                        $fileIcon = '🖼️';
                                                        $bgColor = 'bg-green-50';
                                                        $textColor = 'text-green-700';
                                                        $borderColor = 'border-green-200';
                                                    } elseif ($extension === 'pdf') {
                                                        $fileIcon = '📑';
                                                        $bgColor = 'bg-amber-50';
                                                        $textColor = 'text-amber-700';
                                                        $borderColor = 'border-amber-200';
                                                    } elseif (in_array($extension, ['doc', 'docx'])) {
                                                        $fileIcon = '📝';
                                                    } elseif (in_array($extension, ['zip', 'rar'])) {
                                                        $fileIcon = '📦';
                                                    }
                                                @endphp
                                                
                                                <div class="flex flex-col gap-2">
                                                    {{-- File info badge --}}
                                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 {{ $bgColor }} {{ $borderColor }} border rounded-lg w-fit">
                                                        <span class="text-lg">{{ $fileIcon }}</span>
                                                        <span class="font-semibold text-xs {{ $textColor }}">
                                                            {{ strtoupper($extension) }}
                                                        </span>
                                                    </div>
                                                    
                                                    {{-- Action buttons --}}
                                                    <div class="flex items-center gap-2">
                                                        @if ($isUrl)
                                                            <a href="{{ $fileUrl }}" target="_blank"
                                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-xs font-semibold transition-colors">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                                </svg>
                                                                Buka
                                                            </a>
                                                        @else
                                                            <button onclick="previewFile('{{ $filePath }}', '{{ $extension }}', '{{ basename($fileUrl) }}')"
                                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-500 hover:bg-emerald-600 text-white rounded-md text-xs font-semibold transition-colors">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                                Preview
                                                            </button>
                                                            <a href="{{ route('pengumpulan-tugas.download', $item['submission']) }}"
                                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-md text-xs font-semibold transition-colors">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                </svg>
                                                                Unduh
                                                            </a>
                                                        @endif
                                                    </div>
                                                    
                                                    {{-- Catatan siswa --}}
                                                    @if ($item['submission']->catatan)
                                                        <div class="mt-1 px-2 py-1 bg-gray-50 border border-gray-200 rounded text-xs text-gray-600 italic">
                                                            💬 "{{ Str::limit($item['submission']->catatan, 50) }}"
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-gray-300 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 status-cell">
                                            @if ($item['penilaian'])
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border-purple-200">
                                                    Sudah Dinilai
                                                </span>
                                            @elseif($item['submission'])
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border-amber-200">
                                                    Menunggu Dinilai
                                                </span>
                                            @else
                                                <span class="text-gray-300 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 nilai-cell">
                                            @if ($item['penilaian'])
                                                <span
                                                    class="font-bold text-purple-700 text-sm">{{ number_format($item['penilaian']->nilai, 1) }}</span>
                                            @else
                                                <span class="text-gray-300 text-xs">-</span>
                                            @endif
                                        </td>
                                        @if ($isCreator)
                                            <td class="px-6 py-4 text-center aksi-cell">
                                                @if ($item['submission'])
                                                    <button
                                                        @click="openModal({{ json_encode([
                                                            'id_pengumpulan_tugas' => $item['submission']->id,
                                                            'nama_siswa' => $item['siswa']->nama_lengkap,
                                                            'nilai' => $item['penilaian']->nilai ?? '',
                                                            'catatan_guru' => $item['penilaian']->catatan_guru ?? '',
                                                            'nilai_maksimal' => $tugas->nilai_maksimal,
                                                        ]) }})"
                                                        class="w-8 h-8 flex items-center justify-center {{ $item['penilaian'] ? 'bg-amber-50 hover:bg-amber-100 text-amber-600 border-amber-200' : 'bg-blue-50 hover:bg-blue-100 text-blue-600 border-blue-200' }} border rounded-lg transition mx-auto"
                                                        title="{{ $item['penilaian'] ? 'Edit Nilai' : 'Nilai' }}">
                                                        @if ($item['penilaian'])
                                                            <svg class="w-3.5 h-3.5" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24"
                                                                stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        @else
                                                            <svg class="w-3.5 h-3.5" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24"
                                                                stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                            </svg>
                                                        @endif
                                                    </button>
                                                @else
                                                    <span class="text-gray-300 text-xs">-</span>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Penilaian Modal (Req 3.3) -->
            <div x-show="showModal" x-cloak class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
                role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal()">
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Penilaian Tugas: <span x-text="currentData.nama_siswa"></span>
                            </h3>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nilai (Maksimal: <span x-text="currentData.nilai_maksimal"></span>)
                                </label>
                                <input type="number" x-model="currentData.nilai" :max="currentData.nilai_maksimal"
                                    min="0" step="0.1"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Masukkan nilai">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Guru
                                    (Opsional)</label>
                                <textarea x-model="currentData.catatan_guru" rows="4" maxlength="1000"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Tambahkan catatan untuk siswa..."></textarea>
                                <div class="text-xs text-gray-500 mt-1">
                                    <span x-text="(currentData.catatan_guru || '').length"></span>/1000 karakter
                                </div>
                            </div>

                            <div x-show="errorMessage" class="mb-4 p-3 text-sm text-red-700 bg-red-100 rounded-lg"
                                x-text="errorMessage"></div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button @click="submitPenilaian()" :disabled="loading"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                                <span x-show="!loading">Simpan Penilaian</span>
                                <span x-show="loading">Menyimpan...</span>
                            </button>
                            <button @click="closeModal()" :disabled="loading"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function previewFile(filePath, extension, fileName) {
                // Determine preview content based on file type
                let previewContent = '';
                
                if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(extension.toLowerCase())) {
                    // Image preview
                    previewContent = `
                        <div style="text-align:center;background:#f8faff;padding:20px;border-radius:12px;">
                            <img src="${filePath}" alt="${fileName}" style="max-width:100%;max-height:70vh;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                        </div>
                    `;
                } else if (extension.toLowerCase() === 'pdf') {
                    // PDF preview
                    previewContent = `
                        <iframe src="${filePath}#toolbar=0&navpanes=0&scrollbar=1" 
                                style="width:100%;height:70vh;border:none;border-radius:12px;background:#fff;">
                        </iframe>
                    `;
                } else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(extension.toLowerCase())) {
                    // Office documents - use Microsoft Office Online Viewer
                    const viewerUrl = `https://view.officeapps.live.com/op/view.aspx?src=${encodeURIComponent(filePath)}`;
                    previewContent = `
                        <iframe src="${viewerUrl}" 
                                style="width:100%;height:70vh;border:none;border-radius:12px;background:#fff;">
                        </iframe>
                    `;
                } else {
                    // Other files - show download option
                    previewContent = `
                        <div style="text-align:center;padding:40px;">
                            <svg style="width:64px;height:64px;margin:0 auto 16px;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <p style="color:#64748b;font-size:14px;margin-bottom:16px;">Preview tidak tersedia untuk tipe file ini</p>
                            <a href="${filePath}" download class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-semibold text-sm transition-colors" style="text-decoration:none;">
                                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download File
                            </a>
                        </div>
                    `;
                }
                
                // Show modal with preview
                Swal.fire({
                    title: fileName,
                    html: previewContent,
                    width: '90%',
                    showCloseButton: true,
                    showConfirmButton: false,
                    customClass: {
                        container: 'file-preview-modal',
                        popup: 'file-preview-popup'
                    },
                    didOpen: () => {
                        // Add custom styles
                        const style = document.createElement('style');
                        style.textContent = `
                            .file-preview-modal .swal2-popup {
                                padding: 20px !important;
                            }
                            .file-preview-modal .swal2-title {
                                font-size: 16px !important;
                                padding: 0 0 16px 0 !important;
                                border-bottom: 1px solid #e2e8f0;
                                margin-bottom: 16px;
                                color: #0f172a;
                            }
                            .file-preview-modal .swal2-html-container {
                                margin: 0 !important;
                                padding: 0 !important;
                            }
                        `;
                        document.head.appendChild(style);
                    }
                });
            }
            
            function penilaianModal() {
                return {
                    showModal: false,
                    loading: false,
                    errorMessage: '',
                    currentData: {
                        id_pengumpulan_tugas: null,
                        nama_siswa: '',
                        nilai: '',
                        catatan_guru: '',
                        nilai_maksimal: 100,
                    },

                    openModal(data) {
                        this.currentData = {
                            ...data
                        };
                        this.errorMessage = '';
                        this.showModal = true;
                    },

                    closeModal() {
                        this.showModal = false;
                        this.errorMessage = '';
                    },

                    async submitPenilaian() {
                        // Validation
                        if (!this.currentData.nilai || this.currentData.nilai === '') {
                            this.errorMessage = 'Nilai wajib diisi.';
                            return;
                        }

                        const nilai = parseFloat(this.currentData.nilai);
                        if (nilai < 0 || nilai > this.currentData.nilai_maksimal) {
                            this.errorMessage = `Nilai harus antara 0 dan ${this.currentData.nilai_maksimal}.`;
                            return;
                        }

                        // Confirmation for zero score (Req 3.5a)
                        if (nilai === 0) {
                            if (!confirm('Anda memberikan nilai 0. Apakah Anda yakin?')) {
                                return;
                            }
                        }

                        this.loading = true;
                        this.errorMessage = '';

                        try {
                            const response = await axios.post('{{ route('penilaian.quick-store') }}', {
                                id_pengumpulan_tugas: this.currentData.id_pengumpulan_tugas,
                                nilai: this.currentData.nilai,
                                catatan_guru: this.currentData.catatan_guru,
                            });

                            if (response.data.success) {
                                // Update DOM (Req 3.6)
                                const row = document.querySelector(
                                    `tr[data-submission-id="${this.currentData.id_pengumpulan_tugas}"]`);
                                if (row) {
                                    // Update status
                                    const statusCell = row.querySelector('.status-cell');
                                    statusCell.innerHTML =
                                        '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Sudah Dinilai</span>';

                                    // Update nilai
                                    const nilaiCell = row.querySelector('.nilai-cell');
                                    nilaiCell.innerHTML =
                                        `<span class="font-bold text-purple-700">${parseFloat(response.data.nilai).toFixed(1)}</span>`;

                                    // Update button to "Edit Nilai" (Req 3.7, 3.8)
                                    const aksiCell = row.querySelector('.aksi-cell button');
                                    if (aksiCell) {
                                        aksiCell.innerHTML =
                                            '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Edit Nilai';
                                        aksiCell.className =
                                            'text-blue-600 hover:text-blue-900 font-semibold inline-flex items-center gap-1';
                                    }
                                }

                                this.closeModal();

                                // Show success message
                                const successDiv = document.createElement('div');
                                successDiv.className =
                                    'flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm mb-4';
                                successDiv.innerHTML = `
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">${response.data.message}</span>
                            </div>
                        `;
                                document.querySelector('.bg-white.rounded-xl').prepend(successDiv);
                                setTimeout(() => successDiv.remove(), 3000);
                            }
                        } catch (error) {
                            if (error.response) {
                                this.errorMessage = error.response.data.message ||
                                    'Terjadi kesalahan saat menyimpan penilaian.';
                            } else {
                                this.errorMessage = 'Terjadi kesalahan jaringan.';
                            }
                        } finally {
                            this.loading = false;
                        }
                    }
                }
            }
        </script>
</x-app-layout>
