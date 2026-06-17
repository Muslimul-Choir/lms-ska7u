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
                    Manajemen Kuis
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
        <span class="text-gray-600 font-semibold">Kuis</span>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            
            {{-- Notifications --}}
            @if(session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center justify-between px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-5">
                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Daftar Kuis</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Kelola kuis dan evaluasi pembelajaran siswa</p>
                    </div>
                    <div class="flex items-center gap-2 font-medium">
                        {{-- Tombol Arsip --}}
                        <a href="{{ route('kuis.trash') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Arsip
                            @if(isset($trashCount) && $trashCount > 0)
                                <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold leading-none ml-1">{{ $trashCount }}</span>
                            @endif
                        </a>

                        {{-- Tombol Tambah --}}
                        @if (Auth::user()->role === 'guru')
                        <a href="{{ route('kuis.create') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Kuis
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Search & Filter Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <form method="GET" action="{{ route('kuis.index') }}" class="flex flex-wrap items-center gap-2">
                        <div class="relative flex-1 min-w-[180px] max-w-xs">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kuis..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>

                        <select name="status" onchange="this.form.submit()"
                            class="rounded-xl border min-w-[130px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>

                        <button type="submit"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>
                        @if (request('search') || request('status'))
                            <a href="{{ route('kuis.index') }}"
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

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                <th class="px-6 py-3 text-left w-12">#</th>
                                <th class="px-6 py-3 text-left">Judul Kuis</th>
                                <th class="px-6 py-3 text-left">Mapel</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-center">Soal</th>
                                <th class="px-6 py-3 text-left">Durasi</th>
                                <th class="px-6 py-3 text-left">Batas Waktu</th>
                                <th class="px-6 py-3 text-center w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @forelse($kuisList as $kuis)
                            <tr class="hover:bg-amber-50/40 transition-colors">
                                <td class="px-6 py-4 text-[11px] font-mono text-slate-400">
                                    {{ str_pad($loop->iteration + ($kuisList->currentPage() - 1) * $kuisList->perPage(), 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900 text-sm">{{ $kuis->judul }}</div>
                                    @if($kuis->deskripsi)
                                        <div class="text-xs text-gray-500 mt-1">{{ Str::limit($kuis->deskripsi, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700">
                                    {{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusLabel = $kuis->getStatusLabelAttribute();
                                        $isReleased = $kuis->isReleased();
                                        $isAccessible = $kuis->isAccessible();
                                        $isExpired = $kuis->isExpired();
                                        $isActive = $kuis->isActive();
                                    @endphp
                                    
                                    @if($statusLabel === 'Belum Dijadwalkan' || $kuis->status === 'draft')
                                        <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold uppercase bg-gray-100 text-gray-700 border-gray-200">
                                            {{ $statusLabel === 'Belum Dijadwalkan' ? 'Draft' : 'Draft' }}
                                        </span>
                                    @elseif($statusLabel === 'Belum Dirilis')
                                        <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border-blue-200">
                                            Terjadwal
                                        </span>
                                    @elseif($statusLabel === 'Tersedia')
                                        <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold uppercase bg-emerald-50 text-emerald-700 border-emerald-200">
                                            Tersedia
                                        </span>
                                    @elseif($statusLabel === 'Belum Dimulai')
                                        <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold uppercase bg-amber-50 text-amber-700 border-amber-200">
                                            Dirilis
                                        </span>
                                    @elseif($statusLabel === 'Berakhir' || $kuis->status === 'closed')
                                        <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold uppercase bg-red-50 text-red-700 border-red-200">
                                            Berakhir
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold uppercase bg-gray-100 text-gray-700 border-gray-200">
                                            {{ $statusLabel }}
                                        </span>
                                    @endif
                                    
                                    {{-- Show release time if scheduled --}}
                                    @if($kuis->waktu_rilis && !$isReleased)
                                        <div class="text-[9px] text-gray-400 mt-1">
                                            Rilis: {{ \Carbon\Carbon::parse($kuis->waktu_rilis)->format('d/m H:i') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-50 text-amber-600 font-bold border border-amber-100 text-xs">{{ $kuis->soal_kuis_count }}</span>
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-gray-700">
                                     {{ $kuis->durasi }} menit
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600">
                                    <div class="font-medium"> {{ \Carbon\Carbon::parse($kuis->batas_mulai)->format('d M Y') }}</div>
                                    <div class="text-[10px] text-gray-400 mt-0.5">s/d {{ \Carbon\Carbon::parse($kuis->batas_selesai)->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('kuis.show', $kuis) }}" 
                                            class="w-8 h-8 flex items-center justify-center bg-blue-50 hover:bg-blue-100 text-blue-500 border border-blue-200 rounded-lg transition" 
                                            title="Lihat Hasil">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('soal_kuis.index', $kuis) }}" 
                                            class="w-8 h-8 flex items-center justify-center bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-200 rounded-lg transition" 
                                            title="Kelola Soal">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                            </svg>
                                        </a>
                                        @if (Auth::user()->role === 'guru')
                                        <a href="{{ route('kuis.edit', $kuis) }}" 
                                            class="w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition" 
                                            title="Edit">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        @endif
                                        <form action="{{ route('kuis.destroy', $kuis) }}" method="POST" class="inline" onsubmit="return handleDelete(event)">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition" 
                                                title="Hapus">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center text-gray-400">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                            </svg>
                                        </div>
                                        @if(request('search') || request('status'))
                                            <p class="font-semibold text-sm">Tidak ada kuis yang sesuai dengan pencarian.</p>
                                        @else
                                            <p class="font-semibold text-sm">Belum ada kuis.</p>
                                            <a href="{{ route('kuis.create') }}" class="text-amber-600 hover:text-amber-700 font-bold text-xs mt-1">Buat kuis pertama</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($kuisList->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Menampilkan
                            <span class="font-semibold text-gray-700">{{ $kuisList->firstItem() }}–{{ $kuisList->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $kuisList->total() }}</span>
                            entri
                        </p>
                        {{ $kuisList->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<x-alerts.success />
<x-alerts.confirm-delete />

@push('scripts')
    <script>
        function handleDelete(event) {
            event.preventDefault();
            showConfirmDelete(true).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
            return false;
        }
    </script>
@endpush
