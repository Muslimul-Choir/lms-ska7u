<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Guru Mapel</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Master</p>
            </div>
        </div>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-gray-400 font-medium">
                <a href="#" class="text-amber-600 hover:text-amber-700 transition">Dashboard</a>
                <span class="text-gray-300">/</span>
                <span>Master Data</span>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600 font-semibold">Guru Mapel</span>
            </nav>

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <span class="w-1 h-5 rounded-full bg-amber-500 inline-block"></span>
                            Daftar Guru Mapel
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5 ml-3">Kelola penugasan guru ke mata pelajaran</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('guru_mapel.trash') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Tempat Sampah
                        </a>
                        <button type="button" onclick="openCreateModal()"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Guru Mapel
                        </button>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <div class="flex items-center gap-2 max-w-sm">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" value="{{ request('search') }}"
                                   placeholder="Cari nama mapel atau guru..."
                                   onkeypress="if(event.key==='Enter') doSearch()"
                                   class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>
                        <button type="button" onclick="doSearch()"
                                class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>
                        @if(request('search'))
                            <button type="button" onclick="window.location.href='{{ route('guru_mapel.index') }}'"
                                    class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium rounded-xl transition">
                                Reset
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest w-12">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Mapel</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Guru</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Kelas</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Semester</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($guruMapels as $guruMapel)
                                <tr class="hover:bg-amber-50/40 transition">

                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($guruMapels->currentPage() - 1) * $guruMapels->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Mapel --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-amber-600 text-[10px] font-bold uppercase">
                                                    {{ substr($guruMapel->Mapel->nama_mapel ?? '-', 0, 2) }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-gray-800 text-sm">{{ $guruMapel->Mapel->nama_mapel ?? '-' }}</span>
                                        </div>
                                    </td>

                                    {{-- Guru --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-gray-500 text-[10px] font-bold uppercase">
                                                    {{ substr($guruMapel->Guru->nama_lengkap ?? '-', 0, 2) }}
                                                </span>
                                            </div>
                                            <span class="text-gray-700 text-sm font-medium">{{ $guruMapel->Guru->nama_lengkap ?? '-' }}</span>
                                        </div>
                                    </td>

                                    {{-- Kelas --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $namaKelas = trim(
                                                ($guruMapel->Kelas->Tingkatan->nama_tingkatan ?? '') . ' ' .
                                                ($guruMapel->Kelas->Jurusan->nama_jurusan ?? '') . ' ' .
                                                ($guruMapel->Kelas->Bagian->nama_bagian ?? '')
                                            );
                                        @endphp
                                        @if($namaKelas)
                                            <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-lg">
                                                {{ $namaKelas }}
                                            </span>
                                        @else
                                            <span class="text-gray-300 text-xs">—</span>
                                        @endif
                                    </td>

                                    {{-- Semester --}}
                                    <td class="px-6 py-4">
                                        @if($guruMapel->Semester->nama_semester ?? null)
                                            <span class="inline-flex items-center px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg">
                                                {{ $guruMapel->Semester->nama_semester }}
                                            </span>
                                        @else
                                            <span class="text-gray-300 text-xs">—</span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Detail (Modal) --}}
                                            <button type="button"
                                                    onclick="openDetailModal(
                                                        '{{ $guruMapel->Mapel->nama_mapel ?? '-' }}',
                                                        '{{ $guruMapel->Guru->nama_lengkap ?? '-' }}',
                                                        '{{ trim(($guruMapel->Kelas->Tingkatan->nama_tingkatan ?? '') . ' - ' . ($guruMapel->Kelas->Jurusan->nama_jurusan ?? '') . ' - ' . ($guruMapel->Kelas->Bagian->nama_bagian ?? '')) }}',
                                                        '{{ $guruMapel->Semester->nama_semester ?? '-' }}',
                                                        '{{ $guruMapel->created_at->format('d F Y, H:i') }}',
                                                        '{{ $guruMapel->updated_at->format('d F Y, H:i') }}'
                                                    )"
                                                    class="w-8 h-8 flex items-center justify-center bg-blue-50 hover:bg-blue-100 text-blue-500 border border-blue-200 rounded-lg transition"
                                                    title="Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </button>

                                            {{-- Edit --}}
                                            <button type="button"
                                                    onclick="openEditModal(
                                                        '{{ $guruMapel->id }}',
                                                        '{{ $guruMapel->id_mapel }}',
                                                        '{{ $guruMapel->id_guru }}',
                                                        '{{ $guruMapel->id_kelas }}',
                                                        '{{ $guruMapel->id_semester }}'
                                                    )"
                                                    class="w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition"
                                                    title="Edit">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>

                                            {{-- Hapus --}}
                                            <form action="{{ route('guru_mapel.destroy', $guruMapel) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus penugasan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition"
                                                        title="Hapus">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">Belum ada data guru mapel</p>
                                            <p class="text-gray-300 text-xs">Klik <span class="font-semibold text-gray-400">+ Tambah Guru Mapel</span> untuk mulai menambahkan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($guruMapels->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Menampilkan
                            <span class="font-semibold text-gray-700">{{ $guruMapels->firstItem() }}–{{ $guruMapels->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $guruMapels->total() }}</span>
                            entri
                        </p>
                        {{ $guruMapels->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('guru_mapel.modal-create')
    @include('guru_mapel.modal-edit')

    {{-- ===================== MODAL DETAIL ===================== --}}
    <div id="detailModal"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display:none !important;">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" style="position:absolute; inset:0; background:rgba(45,8,16,0.55); backdrop-filter:blur(4px);"
             onclick="closeDetailModal()"></div>

        {{-- Modal Box --}}
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200 animate-fade-in">

            {{-- Header --}}
            <div class="px-6 py-5 flex items-center justify-between relative overflow-hidden"
                 style="background: linear-gradient(135deg, #6B1A2B 0%, #4A0F1E 55%, #2D0810 100%);">
                {{-- Decorative circles --}}
                <div class="absolute w-36 h-36 rounded-full border border-amber-500/20 -top-12 right-6 pointer-events-none"></div>
                <div class="absolute w-20 h-20 rounded-full border border-amber-500/10 top-4 right-24 pointer-events-none"></div>

                <div class="flex items-center gap-3 relative">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background: rgba(232,147,10,0.2);">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="#F5A623" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-base leading-none">Informasi Penugasan</h3>
                        <p class="text-white/50 text-xs mt-1">Detail lengkap guru mata pelajaran</p>
                    </div>
                </div>

                <button type="button" onclick="closeDetailModal()"
                        class="relative w-8 h-8 flex items-center justify-center rounded-lg text-white/70 hover:text-white hover:bg-white/10 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Gold accent bar --}}
            <div class="h-0.5" style="background: linear-gradient(90deg,#E8930A,#F5A623,#E8930A);"></div>

            {{-- Body --}}
            <div class="px-6 py-5 space-y-4">

                {{-- Mata Pelajaran --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Mata Pelajaran</label>
                    <div class="flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl min-h-[42px]">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span id="detail-mapel" class="font-semibold text-gray-800 text-sm"></span>
                    </div>
                </div>

                {{-- Guru --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Guru</label>
                    <div class="flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl min-h-[42px]">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span id="detail-guru" class="font-semibold text-gray-800 text-sm"></span>
                    </div>
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Kelas</label>
                    <div class="flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl min-h-[42px]">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span id="detail-kelas" class="font-semibold text-gray-800 text-sm"></span>
                    </div>
                </div>

                {{-- Semester --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Semester</label>
                    <div class="flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl min-h-[42px]">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span id="detail-semester" class="font-semibold text-gray-800 text-sm"></span>
                    </div>
                </div>

                {{-- Timestamps --}}
                <div class="grid grid-cols-2 gap-3 p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                    <div>
                        <p class="text-[10.5px] font-bold text-gray-400 uppercase tracking-wider mb-1">Dibuat Pada</p>
                        <p id="detail-created" class="text-sm font-semibold text-gray-700"></p>
                    </div>
                    <div>
                        <p class="text-[10.5px] font-bold text-gray-400 uppercase tracking-wider mb-1">Diupdate Pada</p>
                        <p id="detail-updated" class="text-sm font-semibold text-gray-700"></p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 pb-5 flex justify-end border-t border-gray-100 pt-4">
                <button type="button" onclick="closeDetailModal()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl transition shadow-sm"
                        style="background: linear-gradient(135deg, #6B1A2B, #9B3045);">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tutup Detail
                </button>
            </div>
        </div>
    </div>
    {{-- =================== END MODAL DETAIL =================== --}}

    <script>
        function doSearch() {
            var q = document.getElementById('searchInput').value;
            window.location.href = '{{ route('guru_mapel.index') }}?search=' + encodeURIComponent(q);
        }

        function openDetailModal(mapel, guru, kelas, semester, created, updated) {
            document.getElementById('detail-mapel').textContent    = mapel;
            document.getElementById('detail-guru').textContent     = guru;
            document.getElementById('detail-kelas').textContent    = kelas;
            document.getElementById('detail-semester').textContent = semester;
            document.getElementById('detail-created').textContent  = created;
            document.getElementById('detail-updated').textContent  = updated;

            var modal = document.getElementById('detailModal');
            modal.style.setProperty('display', 'flex', 'important');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModal() {
            var modal = document.getElementById('detailModal');
            modal.style.setProperty('display', 'none', 'important');
            document.body.style.overflow = '';
        }

        // Tutup modal saat tekan Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDetailModal();
        });
    </script>
</x-app-layout>