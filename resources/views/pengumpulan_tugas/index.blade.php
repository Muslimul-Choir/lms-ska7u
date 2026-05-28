<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Data Pengumpulan Tugas
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
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 font-semibold">Pengumpulan Tugas</span>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Alert Messages --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Search & Filter Bar --}}
            <form method="GET" action="{{ route('pengumpulan-tugas.index') }}" class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa, NIS, atau judul tugas..." class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-amber-400/30 focus:border-amber-400 transition bg-white">
                </div>
                
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-3">
                    <select name="status" class="border border-gray-200 rounded-lg text-sm py-2 px-3 focus:ring-amber-400/30 focus:border-amber-400 transition bg-white">
                        <option value="">Semua Status</option>
                        <option value="dinilai" {{ request('status') == 'dinilai' ? 'selected' : '' }}>Sudah Dinilai</option>
                        <option value="belum_dinilai" {{ request('status') == 'belum_dinilai' ? 'selected' : '' }}>Belum Dinilai</option>
                    </select>
                    
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Cari</button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('pengumpulan-tugas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2 rounded-lg text-sm font-semibold transition flex items-center justify-center" title="Reset Filter">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </a>
                    @endif
                </div>
            </form>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Siswa</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Tugas</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">File</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Waktu Kirim</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pengumpulanTugas as $item)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">{{ str_pad(($pengumpulanTugas->currentPage() - 1) * $pengumpulanTugas->perPage() + $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900 text-sm">{{ $item->siswa->nama_lengkap ?? 'Unknown' }}</div>
                                        <div class="text-xs text-gray-500">NIS: {{ $item->siswa->nis ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-800 text-sm">{{ $item->tugas->judul ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->tugas->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($item->file_url)
                                            @if(str_starts_with($item->file_url, 'http'))
                                                <a href="{{ $item->file_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 font-semibold text-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                    </svg>
                                                    Lihat Link
                                                </a>
                                            @else
                                                <a href="{{ route('pengumpulan-tugas.download', $item) }}" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-amber-700 font-semibold text-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    Unduh File
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-gray-300 text-xs">-</span>
                                        @endif
                                        @if($item->catatan)
                                            <div class="text-xs mt-1 text-gray-500 italic max-w-xs truncate" title="{{ $item->catatan }}">"{{ $item->catatan }}"</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($item->penilaian)
                                            <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border-emerald-200">
                                                Dinilai: {{ number_format($item->penilaian->nilai, 1) }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border-amber-200">
                                                Belum Dinilai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 text-sm">
                                        {{ $item->created_at->format('d M Y') }}
                                        <div class="text-xs text-gray-500">{{ $item->created_at->format('H:i') }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                                        <p class="text-sm font-semibold">Belum ada data pengumpulan tugas</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($pengumpulanTugas->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $pengumpulanTugas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
