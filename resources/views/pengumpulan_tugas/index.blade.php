<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Data Pengumpulan Tugas
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Manajemen Tugas Siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            <nav class="flex text-[11px] font-medium text-slate-500 uppercase tracking-widest" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="hover:text-[#1B3A6B] transition-colors">Dashboard</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-slate-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            <span class="text-slate-400">Pengumpulan Tugas</span>
                        </div>
                    </li>
                </ol>
            </nav>

            {{-- Alert Messages --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-white to-slate-50">
                    <div class="relative max-w-md w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" placeholder="Cari siswa atau tugas..." class="block w-full pl-9 pr-3 py-2 border border-slate-200 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition bg-white shadow-sm">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0F2145] text-white">
                                <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider border-b border-[#1B3A6B] w-12">#</th>
                                <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider border-b border-[#1B3A6B]">Siswa</th>
                                <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider border-b border-[#1B3A6B]">Tugas</th>
                                <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider border-b border-[#1B3A6B]">File</th>
                                <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider border-b border-[#1B3A6B]">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-[11px] font-medium text-slate-600">
                            @forelse($pengumpulanTugas as $item)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-5 py-3.5">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3.5">
                                        <div class="font-bold text-[#0F2145]">{{ $item->siswa->nama_lengkap ?? 'Unknown' }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $item->siswa->nisn ?? '-' }}</div>
                                    </td>
                                    <td class="px-5 py-3.5 text-slate-700">
                                        <div class="font-bold">{{ $item->tugas->judul ?? '-' }}</div>
                                        <div class="text-[10px] text-slate-400">Pertemuan {{ $item->tugas->pertemuan->nomor_pertemuan ?? '-' }}</div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if($item->file_url)
                                            <a href="{{ asset('storage/' . $item->file_url) }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-[#1B3A6B]/10 hover:bg-[#1B3A6B]/20 text-[#1B3A6B] rounded-md transition font-semibold">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-slate-400 italic">Tidak ada file</span>
                                        @endif
                                        @if($item->catatan)
                                            <div class="text-[10px] mt-1 text-slate-500 max-w-xs truncate" title="{{ $item->catatan }}">"{{ $item->catatan }}"</div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        {{ $item->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <svg class="w-10 h-10 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                            <p class="text-[11px] font-semibold uppercase tracking-widest">Belum ada data pengumpulan tugas</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>