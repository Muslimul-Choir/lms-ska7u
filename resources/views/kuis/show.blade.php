<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Detail Kuis
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
        <a href="{{ route('kuis.index') }}" class="text-amber-600 hover:text-amber-700 transition">Kuis</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-600 font-semibold">Detail</span>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            @if (session('success'))
                <div
                    class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Kuis Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $kuis->judul }}</h3>
                            @if ($kuis->deskripsi)
                                <p class="text-gray-600 mb-4">{{ $kuis->deskripsi }}</p>
                            @endif
                        </div>
                        <div>
                            @if ($kuis->status === 'draft')
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700">Draft</span>
                            @elseif($kuis->status === 'published')
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full bg-emerald-100 text-emerald-700">Published</span>
                            @else
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-700">Closed</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Mata Pelajaran</div>
                            <div class="font-bold text-gray-900">{{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}
                            </div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Jumlah Soal</div>
                            <div class="font-bold text-gray-900">{{ $totalSoal }} Soal</div>
                        </div>
                        <div class="bg-amber-50 p-4 rounded-lg border border-amber-100">
                            <div class="text-sm text-gray-600 mb-1">Durasi</div>
                            <div class="font-bold text-gray-900">{{ $kuis->durasi }} Menit</div>
                        </div>
                        <div class="bg-emerald-50 p-4 rounded-lg border border-emerald-100">
                            <div class="text-sm text-gray-600 mb-1">Nilai Maksimal</div>
                            <div class="font-bold text-gray-900">{{ number_format($kuis->nilai_maksimal, 1) }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <div class="text-sm text-gray-600 mb-1">Batas Mulai</div>
                            <div class="font-semibold">
                                {{ \Carbon\Carbon::parse($kuis->batas_mulai)->format('d M Y, H:i') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600 mb-1">Batas Selesai</div>
                            <div class="font-semibold">
                                {{ \Carbon\Carbon::parse($kuis->batas_selesai)->format('d M Y, H:i') }}</div>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('kuis.index') }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-lg inline-flex items-center gap-2 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                        <a href="{{ route('soal_kuis.index', $kuis) }}"
                            class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 px-4 rounded-lg inline-flex items-center gap-2 shadow-sm transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Kelola Soal
                        </a>
                        <a href="{{ route('kuis.edit', $kuis) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 px-4 rounded-lg inline-flex items-center gap-2 shadow-sm transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Kuis
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Statistik Hasil Kuis
                    </h3>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg text-center border border-blue-100">
                            <div class="text-3xl font-bold text-blue-700">{{ $totalSiswa }}</div>
                            <div class="text-sm text-gray-600 mt-1">Siswa Mengerjakan</div>
                        </div>
                        <div class="bg-emerald-50 p-4 rounded-lg text-center border border-emerald-100">
                            <div class="text-3xl font-bold text-emerald-700">{{ number_format($rataRata, 1) }}</div>
                            <div class="text-sm text-gray-600 mt-1">Rata-rata Nilai</div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg text-center border border-purple-100">
                            <div class="text-3xl font-bold text-purple-700">{{ $totalSoal }}</div>
                            <div class="text-sm text-gray-600 mt-1">Total Soal</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Daftar Hasil Siswa
                    </h3>

                    @if ($kuis->HasilKuis->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Siswa</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nilai</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Benar/Salah</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Waktu Selesai</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($kuis->HasilKuis->sortByDesc('nilai') as $index => $hasil)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">
                                                    {{ $hasil->Siswa?->nama_lengkap ?? '-' }}</div>
                                                <div class="text-sm text-gray-500">{{ $hasil->Siswa?->nis ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="text-lg font-bold text-purple-700">{{ number_format($hasil->nilai, 1) }}</span>
                                                <span class="text-sm text-gray-500">/
                                                    {{ number_format($kuis->nilai_maksimal, 1) }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span
                                                    class="text-green-600 font-semibold inline-flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $hasil->jumlah_benar }}
                                                </span>
                                                <span class="text-gray-400 mx-1">/</span>
                                                <span
                                                    class="text-red-600 font-semibold inline-flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $totalSoal - $hasil->jumlah_benar }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $hasil->waktu_selesai ? \Carbon\Carbon::parse($hasil->waktu_selesai)->format('d M Y, H:i') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('hasil_kuis.show', [$kuis, $hasil]) }}"
                                                    class="text-blue-600 hover:text-blue-900 inline-flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            Belum ada siswa yang mengerjakan kuis ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
</x-app-layout>

<x-alerts.success />
