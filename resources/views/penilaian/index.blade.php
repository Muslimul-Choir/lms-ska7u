<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                    </path>
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Data Penilaian
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
        <span class="text-gray-600 font-semibold">Penilaian</span>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- Alert Messages --}}
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

            {{-- Info Card --}}
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base font-bold text-gray-900 mb-2">Kelola Penilaian Tugas</h3>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            Halaman ini menampilkan daftar tugas yang sudah dipublish beserta statistik pengumpulan dan penilaian. 
                            Klik tombol <strong class="text-amber-600">"Lihat Rekap & Nilai"</strong> untuk melihat detail pengumpulan siswa dan memberikan penilaian.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-5">
                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Daftar Penilaian Tugas</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Kelola dan berikan nilai pada tugas yang dikumpulkan siswa</p>
                    </div>
                    <div class="flex items-center gap-2">
                        {{-- Tombol Arsip --}}
                        <a href="{{ route('penilaian.trash') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Arsip
                            @if(isset($trashCount) && $trashCount > 0)
                                <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold leading-none ml-1">{{ $trashCount }}</span>
                            @endif
                        </a>
                    </div>
                </div>

                {{-- Search & Filter Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <form method="GET" action="{{ route('penilaian.index') }}" class="flex flex-wrap items-center gap-2">
                        <div class="relative flex-1 min-w-[180px] max-w-xs">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tugas..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>
                        @if (request('search'))
                            <a href="{{ route('penilaian.index') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                </svg>
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    #</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Judul Tugas</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Mapel</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Total Siswa</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Dikumpulkan</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Dinilai</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Pending</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($tugasList as $tugas)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($tugasList->currentPage() - 1) * $tugasList->perPage(), 2, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900 text-sm">{{ $tugas->judul }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            Pertemuan {{ $tugas->Pertemuan->nomor_pertemuan ?? '-' }}
                                            @if($tugas->batas_waktu)
                                                • Deadline: {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d/m/Y H:i') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-700 text-sm">
                                            {{ $tugas->GuruMapel->Mapel->nama_mapel ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-700 font-bold text-sm">
                                            {{ $tugas->stats->total_siswa }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold text-sm">
                                                {{ $tugas->stats->total_submissions }}
                                            </span>
                                            @if($tugas->stats->total_siswa > 0)
                                                <span class="text-[10px] text-gray-500 font-semibold">
                                                    {{ round(($tugas->stats->total_submissions / $tugas->stats->total_siswa) * 100) }}%
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm">
                                                {{ $tugas->stats->total_graded }}
                                            </span>
                                            @if($tugas->stats->total_submissions > 0)
                                                <span class="text-[10px] text-gray-500 font-semibold">
                                                    {{ round(($tugas->stats->total_graded / $tugas->stats->total_submissions) * 100) }}%
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-amber-100 text-amber-700 font-bold text-sm">
                                            {{ $tugas->stats->pending_grade }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('tugas.rekap', ['tugas' => $tugas, 'source' => 'penilaian']) }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg transition-all shadow-sm text-xs">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                            Lihat Rekap & Nilai
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center text-gray-400">
                                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                        <p class="text-sm font-semibold">Belum ada tugas yang dipublish</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($tugasList->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $tugasList->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<x-alerts.success />
