<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            {{-- Icon --}}
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Trash — Semester
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Data Semester Terhapus</p>
            </div>
        </div>
    </x-slot>

    {{-- Body --}}
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300">/</span>
                <span>Master Data</span>
                <span class="text-slate-300">/</span>
                <a href="{{ route('semester.index') }}" class="hover:text-[#1B3A6B] transition">Semester</a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-600 font-semibold">Trash</span>
            </nav>

            {{-- Alert --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700">
                        ✕
                    </button>
                </div>
            @endif

            {{-- Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Data Semester Terhapus</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Data yang dihapus dapat dipulihkan atau dihapus permanen</p>
                    </div>
                    <a href="{{ route('semester.index') }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition">
                        ← Data Utama
                    </a>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest w-12">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Nama Semester</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Dihapus Pada</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-48">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($semesters as $semester)
                                <tr class="hover:bg-slate-50/70 transition">

                                    {{-- No --}}
                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($semesters->currentPage() - 1) * $semesters->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Nama --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-md bg-red-50 flex items-center justify-center">
                                                <span class="text-red-400 text-[10px] font-bold uppercase">
                                                    {{ substr($semester->nama_semester, 0, 2) }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-slate-500 text-sm line-through">
                                                {{ $semester->nama_semester }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Deleted --}}
                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 border border-red-100 rounded-lg">
                                            <svg class="w-3 h-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/>
                                            </svg>
                                            <span class="text-red-500 text-xs font-medium">
                                                {{ $semester->deleted_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('semester.restore', $semester->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-semibold rounded-lg transition">
                                                    Pulihkan
                                                </button>
                                            </form>

                                            {{-- Delete --}}
                                            <form action="{{ route('semester.force-delete', $semester->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus permanen?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                    Hapus Permanen
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                                🗑️
                                            </div>
                                            <p class="text-slate-400 text-sm font-medium">Trash kosong</p>
                                            <p class="text-slate-300 text-xs">Tidak ada data semester yang dihapus</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($semesters->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                        <p class="text-xs text-slate-500">
                            Menampilkan
                            <span class="font-semibold text-slate-700">{{ $semesters->firstItem() }}–{{ $semesters->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $semesters->total() }}</span>
                        </p>
                        {{ $semesters->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>