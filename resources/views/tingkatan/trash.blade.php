<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Trash — Tingkatan
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">
                    Data Tingkatan Terhapus
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300">/</span>
                <span>Master Data</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-600 font-semibold">Trash Tingkatan</span>
            </nav>

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">
                            Data Tingkatan Terhapus
                        </h3>
                        <p class="text-blue-200 text-xs mt-0.5">
                            Data bisa dipulihkan atau dihapus permanen
                        </p>
                    </div>

                    <a href="{{ route('tingkatan.index') }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Data Utama
                    </a>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest w-12">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Nama Tingkatan</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Keterangan</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Dihapus Pada</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-44">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($tingkatans as $tingkatan)
                                <tr class="hover:bg-slate-50/70 transition">

                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ $loop->iteration + ($tingkatans->currentPage() - 1) * $tingkatans->perPage() }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-slate-500 line-through decoration-slate-300">
                                            {{ $tingkatan->nama_tingkatan }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-slate-400 text-sm">
                                        {{ $tingkatan->keterangan ?? '—' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 border border-red-100 rounded-lg">
                                            <svg class="w-3 h-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-red-500 text-xs font-medium">
                                                {{ $tingkatan->deleted_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('tingkatan.restore', $tingkatan->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-semibold rounded-lg transition">
                                                    Pulihkan
                                                </button>
                                            </form>

                                            {{-- Force Delete --}}
                                            <form action="{{ route('tingkatan.force-delete', $tingkatan->id) }}" method="POST"
                                                  onsubmit="return confirm('Hapus permanen? Data tidak bisa dipulihkan!')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                    Hapus Permanen
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 text-sm font-medium">Trash kosong</p>
                                            <p class="text-slate-300 text-xs">Tidak ada data tingkatan yang dihapus</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($tingkatans->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                        {{ $tingkatans->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>