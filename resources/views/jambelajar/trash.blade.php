<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-red-700 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Trash — Jam Belajar
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Data Terhapus Sementara</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-[#f0f4f8] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300">/</span>
                <span>Master Data</span>
                <span class="text-slate-300">/</span>
                <a href="{{ route('jambelajar.index') }}" class="hover:text-[#1B3A6B] transition">Jam Belajar</a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-600 font-semibold">Trash</span>
            </nav>

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Warning Banner --}}
            <div class="flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-sm shadow-sm">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-red-700 text-xs font-medium leading-relaxed">
                    Data dalam trash telah dihapus sementara. Gunakan <span class="font-bold">Pulihkan</span> untuk mengembalikan,
                    atau <span class="font-bold">Hapus Permanen</span> untuk menghapus selamanya tanpa bisa dipulihkan.
                </p>
            </div>

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4
                            border-b border-slate-100 bg-gradient-to-r from-[#6B1A1A] to-[#B91C1C]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Data Jam Belajar Terhapus</h3>
                        <p class="text-red-200 text-xs mt-0.5">Daftar record yang telah dipindahkan ke trash</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Filter Tingkatan --}}
                        <form method="GET" action="{{ route('jambelajar.trash') }}" class="flex items-center gap-2">
                            <div class="relative">
                                <select name="tingkatan"
                                        onchange="this.form.submit()"
                                        class="appearance-none pl-3 pr-8 py-2 text-xs font-medium rounded-lg
                                               focus:outline-none focus:ring-2 focus:ring-white/30
                                               transition cursor-pointer
                                               {{ $filterTingkatan ? 'bg-white text-[#B91C1C] border border-white/60' : 'bg-white/15 text-white border border-white/20' }}">
                                    <option value="" class="text-slate-700">Semua Tingkatan</option>
                                    @foreach($tingkatanList as $tingkatan)
                                        <option value="{{ $tingkatan->id }}"
                                                class="text-slate-700"
                                            {{ $filterTingkatan == $tingkatan->id ? 'selected' : '' }}>
                                            {{ $tingkatan->nama_tingkatan }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                                    <svg class="w-3.5 h-3.5 {{ $filterTingkatan ? 'text-[#B91C1C]' : 'text-white/70' }}"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Reset filter --}}
                            @if($filterTingkatan)
                                <a href="{{ route('jambelajar.trash') }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-2 text-xs font-medium
                                          bg-white/20 hover:bg-white/30 text-white rounded-lg transition"
                                   title="Reset filter">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif
                        </form>

                        {{-- Kembali --}}
                        <a href="{{ route('jambelajar.index') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20
                                  text-white text-xs font-medium rounded-lg border border-white/20 transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Data Utama
                        </a>

                    </div>
                </div>

                {{-- Filter badge info --}}
                @if($filterTingkatan)
                    @php $namaTingkatanFilter = $tingkatanList->firstWhere('id', $filterTingkatan)?->nama_tingkatan; @endphp
                    <div class="px-6 py-2.5 bg-red-50 border-b border-red-100 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                        </svg>
                        <span class="text-xs text-red-600 font-medium">
                            Menampilkan tingkatan: <span class="font-bold">{{ $namaTingkatanFilter }}</span>
                        </span>
                    </div>
                @endif

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest w-12">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Tingkatan</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Jam Mulai</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Jam Selesai</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Dihapus Pada</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-52">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($jamBelajars as $jamBelajar)
                                <tr class="hover:bg-red-50/40 transition group">

                                    {{-- No --}}
                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($jamBelajars->currentPage() - 1) * $jamBelajars->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Tingkatan --}}
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md
                                                     bg-slate-100 text-slate-500 text-xs font-semibold
                                                     line-through decoration-red-300">
                                            {{ $jamBelajar->tingkatan?->nama_tingkatan ?? '—' }}
                                        </span>
                                    </td>

                                    {{-- Jam Mulai --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-md bg-red-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-red-400 text-[10px] font-bold">
                                                    {{ \Carbon\Carbon::parse($jamBelajar->jam_mulai)->format('H:i') }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-slate-500 text-sm line-through decoration-red-300">
                                                {{ \Carbon\Carbon::parse($jamBelajar->jam_mulai)->format('H:i') }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Jam Selesai --}}
                                    <td class="px-6 py-4 text-slate-400 text-sm line-through decoration-red-300">
                                        {{ \Carbon\Carbon::parse($jamBelajar->jam_selesai)->format('H:i') }}
                                    </td>

                                    {{-- Deleted At --}}
                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center gap-1.5 px-2 py-1
                                                    bg-red-50 border border-red-100 rounded-md">
                                            <svg class="w-3 h-3 text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-red-500 text-[11px] font-medium whitespace-nowrap">
                                                {{ $jamBelajar->deleted_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Restore --}}
                                            <form action="{{ route('jambelajar.restore', $jamBelajar->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5
                                                               bg-emerald-50 hover:bg-emerald-100
                                                               text-emerald-700 border border-emerald-200
                                                               text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                    </svg>
                                                    Pulihkan
                                                </button>
                                            </form>

                                            {{-- Force Delete --}}
                                            <form action="{{ route('jambelajar.force-delete', $jamBelajar->id) }}" method="POST"
                                                  onsubmit="return confirm('Hapus permanen? Data tidak bisa dipulihkan!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5
                                                               bg-red-50 hover:bg-red-100
                                                               text-red-600 border border-red-200
                                                               text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus Permanen
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 text-sm font-medium">
                                                {{ $filterTingkatan ? 'Tidak ada data terhapus untuk tingkatan ini' : 'Trash kosong' }}
                                            </p>
                                            <p class="text-slate-300 text-xs">
                                                {{ $filterTingkatan ? 'Coba pilih tingkatan lain atau reset filter' : 'Tidak ada data jam belajar yang dihapus sementara' }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($jamBelajars->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-slate-500">
                            Menampilkan
                            <span class="font-semibold text-slate-700">{{ $jamBelajars->firstItem() }}–{{ $jamBelajars->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $jamBelajars->total() }}</span>
                            entri
                        </p>
                        {{ $jamBelajars->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>