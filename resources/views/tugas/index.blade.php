<x-app-layout>
    @push('styles')
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Tugas Pembelajaran
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
        <span class="text-gray-600 font-semibold">Tugas</span>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5" x-data="{
            activePertemuan: null,
            modalTugas: false,
            modalEditTugas: false,
            editTugasData: {},
            tipeTugas: 'individu',
            tipeFile: 'dokumen',
            tipeTugasEdit: 'individu',
            tipeFileEdit: 'dokumen',
            autoRelease: true,
            autoReleaseEdit: false,
        
            togglePertemuan(id) {
                this.activePertemuan = this.activePertemuan === id ? null : id;
            },
        
            openEditTugas(tugas) {
                this.editTugasData = tugas;
                this.tipeTugasEdit = tugas.tipe_tugas;
                this.tipeFileEdit = tugas.tipe_file;
                this.autoReleaseEdit = tugas.auto_release || false;
                this.modalEditTugas = true;
            }
        }">

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

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-5">
                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Daftar Tugas</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Kelola tugas pembelajaran untuk setiap pertemuan</p>
                    </div>
                    @if (in_array(Auth::user()->guru?->status_pengajar, ['pengajar', 'keduanya']) ||
                                in_array(Auth::user()->role, ['super_admin', 'admin']))
                    <div class="flex items-center gap-2">
                        {{-- Tombol Arsip --}}
                        <a href="{{ route('tugas.trash') }}"
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
                        
                            <button @click="modalTugas = true"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Tugas
                            </button>
                        </div>
                        @endif
                </div>

                {{-- Search & Filter Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <form method="GET" action="{{ route('tugas.index') }}" class="flex flex-wrap items-center gap-2">
                        <div class="relative flex-1 min-w-[180px] max-w-xs">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul tugas..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>

                        <select name="filter_status"
                            class="rounded-xl border min-w-[130px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition">
                            <option value="semua" {{ request('filter_status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                            <option value="published" {{ request('filter_status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('filter_status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="closed" {{ request('filter_status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>

                        <select name="id_kelas"
                            class="rounded-xl border min-w-[150px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelasList as $k)
                                <option value="{{ $k->id }}" {{ request('id_kelas') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>
                        @if (request('q') || (request('filter_status') && request('filter_status') != 'semua') || request('id_kelas'))
                            <a href="{{ route('tugas.index') }}"
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
            </div>

            {{-- Accordion List by Pertemuan --}}
            <div class="space-y-4">
                @forelse($pertemuans as $pertemuan)
                    @php
                        $tugasList = $tugas->where('id_pertemuan', $pertemuan->id);
                        $hasContent = $tugasList->count() > 0;
                    @endphp

                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                        {{-- Header Accordion --}}
                        <div @click="togglePertemuan({{ $pertemuan->id }})"
                            class="flex items-center justify-between p-5 bg-gradient-to-r hover:from-amber-50 hover:to-white cursor-pointer transition select-none border-b border-gray-100 group">

                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 flex flex-col items-center justify-center shrink-0 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-widest leading-none mb-0.5">Pert</span>
                                    <span
                                        class="text-base sm:text-lg font-black leading-none">{{ $pertemuan->nomor_pertemuan }}</span>
                                </div>
                                <div>
                                    <h3
                                        class="font-bold text-gray-800 text-sm sm:text-base group-hover:text-amber-600 transition">
                                        Pertemuan Ke-{{ $pertemuan->nomor_pertemuan }}
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-1">
                                        @php
                                            $namaMapel =
                                                $pertemuan->jadwalBelajar?->guruMapel?->mapel?->nama_mapel ??
                                                $pertemuan->jadwalBelajar?->mapel?->nama_mapel;
                                            $namaKelas = $pertemuan->jadwalBelajar?->kelas?->nama_kelas;
                                        @endphp
                                        @if ($namaMapel)
                                            <span
                                                class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                                {{ $namaMapel }}
                                            </span>
                                        @endif
                                        @if ($namaKelas)
                                            <span
                                                class="inline-flex items-center gap-1 text-[10px] font-medium text-gray-500">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 7h18M3 12h18M3 17h18" />
                                                </svg>
                                                {{ $namaKelas }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <span
                                    class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500">
                                    {{ $tugasList->count() }} Tugas
                                </span>
                                <div
                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 group-hover:bg-amber-100 group-hover:text-amber-600 transition">
                                    <svg class="w-5 h-5 transform transition-transform duration-300"
                                        :class="{ 'rotate-180': activePertemuan === {{ $pertemuan->id }} }"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Body Accordion --}}
                        <div x-show="activePertemuan === {{ $pertemuan->id }}" x-transition.opacity class="bg-white">
                            @if (!$hasContent)
                                <div class="px-5 py-8 text-center text-sm text-gray-400">
                                    Belum ada tugas di pertemuan ini.
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-sm border-collapse">
                                        <thead>
                                            <tr
                                                class="bg-gray-50 border-b border-gray-200 text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                                <th class="px-5 py-3 w-10 text-center">#</th>
                                                <th class="px-5 py-3">Judul Tugas</th>
                                                <th class="px-5 py-3">Tipe</th>
                                                <th class="px-5 py-3">Batas Waktu</th>
                                                <th class="px-5 py-3">Status</th>
                                                <th class="px-5 py-3 text-center w-48">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 text-gray-600">
                                            @foreach ($tugasList as $t)
                                                <tr class="hover:bg-amber-50/40 transition group">
                                                    <td
                                                        class="px-5 py-4 text-[11px] font-mono text-slate-400 text-center align-top">
                                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                    </td>
                                                    <td class="px-5 py-4 align-top">
                                                        <div class="font-semibold text-gray-900 text-sm">
                                                            {{ $t->judul }}</div>
                                                        @if ($t->deskripsi)
                                                            <div class="text-xs text-gray-500 mt-1">
                                                                {{ Str::limit($t->deskripsi, 60) }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="px-5 py-4 align-top">
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold uppercase bg-amber-50 text-amber-700 border-amber-200">
                                                            {{ $t->tipe_tugas }}
                                                        </span>
                                                    </td>
                                                    <td class="px-5 py-4 align-top">
                                                        <div class="text-xs text-gray-700">
                                                            {{ \Carbon\Carbon::parse($t->batas_waktu)->format('d M Y') }}
                                                        </div>
                                                        <div class="text-[10px] text-gray-500">
                                                            {{ \Carbon\Carbon::parse($t->batas_waktu)->format('H:i') }}
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-4 align-top">
                                                        @if ($t->status === 'published')
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border-emerald-200">Published</span>
                                                        @elseif ($t->status === 'closed')
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-red-50 text-red-700 border-red-200">Closed</span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-gray-100 text-gray-700 border-gray-200">Draft</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-5 py-4 text-center align-top">
                                                        <div class="flex items-center justify-center gap-2">
                                                            <a href="{{ route('tugas.rekap', $t->id) }}"
                                                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 rounded-lg transition text-xs font-semibold"
                                                                title="Lihat Rekap & Nilai Siswa">
                                                                <svg class="w-3.5 h-3.5" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    stroke-width="2.5">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                                                </svg>
                                                                Nilai
                                                            </a>
                                                            @if (in_array(Auth::user()->guru?->status_pengajar, ['pengajar', 'keduanya']))
                                                                <button type="button"
                                                                    @click="openEditTugas({
                                                                    id: {{ $t->id }},
                                                                    judul: '{{ addslashes($t->judul) }}',
                                                                    deskripsi: '{{ addslashes($t->deskripsi ?? '') }}',
                                                                    tipe_tugas: '{{ $t->tipe_tugas }}',
                                                                    tipe_file: '{{ $t->tipe_file }}',
                                                                    id_pertemuan: {{ $t->id_pertemuan }},
                                                                    id_guru: {{ $t->id_guru }},
                                                                    batas_waktu: '{{ $t->batas_waktu->format('Y-m-d\TH:i') }}',
                                                                    nilai_maksimal: {{ $t->nilai_maksimal }},
                                                                    status: '{{ $t->status }}',
                                                                    allow_late: {{ $t->allow_late ? 'true' : 'false' }},
                                                                    file_url: '{{ $t->file_url ?? '' }}',
                                                                    waktu_rilis: '{{ $t->waktu_rilis ? $t->waktu_rilis->format('Y-m-d\TH:i') : '' }}',
                                                                    batas_absensi: '{{ $t->batas_absensi ? $t->batas_absensi->format('Y-m-d\TH:i') : '' }}',
                                                                    auto_release: {{ $t->auto_release ? 'true' : 'false' }}
                                                                })"
                                                                class="w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition"
                                                                title="Edit">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </button>
                                                            @endif
                                                            @if (in_array(Auth::user()->guru?->status_pengajar, ['pengajar', 'keduanya']) ||
                                                                    in_array(Auth::user()->role, ['super_admin', 'admin']))
                                                            <form action="{{ route('tugas.destroy', $t->id) }}" method="POST" class="inline" onsubmit="return handleDelete(event)">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition"
                                                                    title="Hapus">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-12 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Tugas</h3>
                        <p class="text-gray-500 mb-4">Klik tombol "Tambah Tugas" untuk membuat tugas baru</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($pertemuans->hasPages())
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-6 py-4">
                    {{ $pertemuans->links() }}
                </div>
            @endif

            {{-- Modal Create Tugas --}}
            <div x-show="modalTugas" x-cloak x-transition
                class="fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5">

                {{-- Overlay --}}
                <div @click="modalTugas = false" class="absolute inset-0 bg-[rgba(45,8,16,0.55)] backdrop-blur-[4px]">
                </div>

                {{-- Dialog --}}
                <div class="relative z-10 w-full max-w-lg max-h-[90vh] overflow-y-auto">
                    <div
                        class="bg-white rounded-[18px] shadow-[0_24px_60px_rgba(107,26,43,0.22),0_4px_16px_rgba(0,0,0,0.08)] overflow-hidden border border-[rgba(107,26,43,0.1)]">

                        {{-- Header --}}
                        <div class="px-6 py-[18px] flex items-center justify-between relative overflow-hidden sticky top-0 z-10"
                            style="background: linear-gradient(135deg,#6B1A2B 0%,#4A0F1E 55%,#2D0810 100%);">
                            <div
                                class="absolute w-[120px] h-[120px] rounded-full top-[-40px] right-[10px] border border-[rgba(232,147,10,0.2)] pointer-events-none">
                            </div>
                            <div
                                class="absolute w-[70px] h-[70px] rounded-full top-[10px] right-[70px] border border-[rgba(232,147,10,0.12)] pointer-events-none">
                            </div>

                            <div class="flex items-center gap-3 relative">
                                <div
                                    class="w-[38px] h-[38px] rounded-[10px] bg-[rgba(232,147,10,0.2)] flex items-center justify-center flex-shrink-0">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="#F5A623" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-[15px] m-0 mb-[2px]">Tambah Tugas</h3>
                                    <p class="text-[rgba(255,255,255,0.5)] text-[11px] m-0">Isi data tugas baru</p>
                                </div>
                            </div>

                            <button type="button" @click="modalTugas = false"
                                class="w-[30px] h-[30px] rounded-lg bg-[rgba(255,255,255,0.12)] hover:bg-[rgba(255,255,255,0.22)] border-none cursor-pointer flex items-center justify-center relative transition-all duration-200">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="#fff" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Gold accent bar --}}
                        <div class="h-[3px]" style="background: linear-gradient(90deg,#E8930A,#F5A623,#E8930A);">
                        </div>

                        {{-- Body --}}
                        <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data"
                            class="p-6 flex flex-col gap-[18px]"
                            x-data="{
                                selectedPertemuanId: '',
                                pertemuanData: @js($allPertemuan->keyBy('id')),
                                getPertemuanDate() {
                                    if (!this.selectedPertemuanId || !this.pertemuanData[this.selectedPertemuanId]) return '';
                                    const pertemuan = this.pertemuanData[this.selectedPertemuanId];
                                    return pertemuan.tanggal || '';
                                }
                            }">
                            @csrf

                            {{-- Pertemuan --}}
                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Pertemuan <span class="text-red-500">*</span>
                                </label>
                                <select name="id_pertemuan" x-model="selectedPertemuanId" required
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                    <option value="">-- Pilih Pertemuan --</option>
                                    @foreach ($allPertemuan as $p)
                                        <option value="{{ $p->id }}">
                                            Pertemuan {{ $p->nomor_pertemuan }} - 
                                            [{{ $p->jadwalBelajar?->kelas?->nama_kelas ?? 'Tanpa Kelas' }}] -
                                            {{ $p->jadwalBelajar?->guruMapel?->mapel?->nama_mapel ?? ($p->jadwalBelajar?->mapel?->nama_mapel ?? 'Tanpa Mapel') }}
                                            @if($p->tanggal)
                                                |  {{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}
                                            @endif
                                            @if($p->jadwalBelajar?->jamBelajar)
                                                |  {{ \Carbon\Carbon::parse($p->jadwalBelajar->jamBelajar->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($p->jadwalBelajar->jamBelajar->jam_selesai)->format('H:i') }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 italic">💡 Tugas akan ditampilkan hanya untuk siswa di
                                    kelas yang dipilih</p>
                            </div>

                            {{-- Guru --}}
                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Guru <span class="text-red-500">*</span>
                                </label>
                                <select name="id_guru" required
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach ($gurus as $g)
                                        <option value="{{ $g->id }}">{{ $g->user->name ?? 'Guru ' . $g->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Judul --}}
                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Judul Tugas <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="judul" required
                                    placeholder="Contoh: Analisis Struktur Data"
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                            </div>

                            {{-- Tipe Tugas & Tipe File --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Tipe Tugas <span class="text-red-500">*</span>
                                    </label>
                                    <select name="tipe_tugas" x-model="tipeTugas" required
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                        <option value="individu">Individu</option>
                                        <option value="kelompok">Kelompok</option>
                                    </select>
                                </div>

                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Tipe File <span class="text-red-500">*</span>
                                    </label>
                                    <select name="tipe_file" x-model="tipeFile" required
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                        <option value="tanpa">Tanpa File</option>
                                        <option value="dokumen">Dokumen/Gambar (PDF/DOC/JPG/PNG)</option>
                                        <option value="video">Video (MP4)</option>
                                        <option value="link">Link/URL</option>
                                    </select>
                                </div>
                            </div>

                            {{-- File Upload --}}
                            <div x-show="tipeFile !== 'tanpa' && tipeFile !== 'link'" class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    File Lampiran <span class="text-red-500">*</span>
                                </label>
                                <input type="file" name="file_url"
                                    :required="tipeFile !== 'tanpa' && tipeFile !== 'link'"
                                    :accept="tipeFile === 'video' ? '.mp4,.webm' : '.pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp'"
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                <p class="text-xs text-gray-500" x-show="tipeFile === 'dokumen'">Format: PDF, DOC, DOCX, JPG, PNG, GIF, WebP (Maks 100MB)</p>
                                <p class="text-xs text-gray-500" x-show="tipeFile === 'video'">Format: MP4, WebM (Maks 100MB)</p>
                            </div>

                            {{-- Link Input --}}
                            <div x-show="tipeFile === 'link'" class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Tautan (URL) <span class="text-red-500">*</span>
                                </label>
                                <input type="url" name="file_url" :required="tipeFile === 'link'"
                                    placeholder="https://..."
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                            </div>

                            {{-- Batas Waktu & Nilai Maksimal --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Batas Waktu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="datetime-local" name="batas_waktu" required
                                        :min="getPertemuanDate()"
                                        :disabled="!selectedPertemuanId"
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white disabled:opacity-50 disabled:cursor-not-allowed">
                                    <p class="text-xs text-gray-500 italic" x-show="!selectedPertemuanId">⚠️ Pilih pertemuan terlebih dahulu</p>
                                    <p class="text-xs text-gray-500 italic" x-show="selectedPertemuanId && getPertemuanDate()"> Minimal tanggal: <span x-text="new Date(getPertemuanDate()).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'})"></span></p>
                                </div>

                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Nilai Maksimal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="nilai_maksimal" value="100" required
                                        min="1" max="1000"
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                </div>
                            </div>

                            {{-- Allow Late --}}
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="allow_late" value="1" id="allow_late"
                                        class="w-4 h-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                    <label for="allow_late" class="text-sm text-gray-700 font-medium">Izinkan pengumpulan
                                        terlambat</label>
                                </div>
                                <div class="pl-6 text-xs text-gray-600 space-y-1">
                                    <p>✓ <strong>Dicentang:</strong> Siswa dapat mengumpulkan setelah batas waktu, nilai tetap dinilai guru</p>
                                    <p>✗ <strong>Tidak dicentang:</strong> Pengumpulan setelah batas waktu otomatis bernilai 0</p>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Deskripsi <span
                                        class="text-gray-400 font-normal normal-case tracking-normal">(opsional)</span>
                                </label>
                                <textarea name="deskripsi" rows="3"
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white"></textarea>
                            </div>

                            {{-- Scheduled Release Section --}}
                            <div class="border-t border-gray-200 pt-4 mt-2">
                                <h4 class="text-[12px] font-bold text-gray-700 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Pengaturan Waktu Rilis
                                </h4>

                                {{-- Auto Release Toggle --}}
                                <div class="flex items-start gap-3 mb-4 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                                    <input type="checkbox" name="auto_release" id="auto_release_create" value="1" x-model="autoRelease" checked
                                        class="mt-0.5 w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                                    <div class="flex-1">
                                        <label for="auto_release_create" class="text-[13px] font-semibold text-gray-700 cursor-pointer">
                                            Rilis Otomatis Sesuai Jadwal Pertemuan
                                        </label>
                                        <p class="text-[11px] text-gray-600 mt-0.5">
                                            Tugas akan otomatis dirilis sesuai waktu mulai jam belajar pertemuan yang dipilih
                                        </p>
                                    </div>
                                </div>

                                {{-- Manual Release Time --}}
                                <div x-show="!autoRelease" x-cloak class="space-y-3">
                                    <div class="flex flex-col gap-[7px]">
                                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                            Waktu Rilis Manual
                                        </label>
                                        <input type="datetime-local" name="waktu_rilis"
                                            class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                    </div>

                                    <div class="flex flex-col gap-[7px]">
                                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                            Batas Waktu Absensi <span class="text-gray-400 font-normal normal-case tracking-normal">(opsional)</span>
                                        </label>
                                        <input type="datetime-local" name="batas_absensi"
                                            class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                        <p class="text-xs text-gray-500">Default: 24 jam setelah waktu rilis</p>
                                    </div>
                                </div>
                            </div>
                            {{-- Footer --}}
                            <div class="flex items-center justify-end gap-[10px] pt-[6px] border-t border-gray-100">
                                <button type="button" @click="modalTugas = false"
                                    class="inline-flex items-center gap-[6px] px-5 py-[9px] text-[13.5px] font-semibold bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-[10px] cursor-pointer transition-all duration-200">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center gap-[6px] px-[22px] py-[9px] text-[13.5px] font-bold text-white border-none rounded-[10px] cursor-pointer transition-all duration-200 shadow-[0_2px_8px_rgba(107,26,43,0.25)] hover:opacity-90"
                                    style="background: linear-gradient(135deg,#6B1A2B,#9B3045);">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                                        <polyline points="17 21 17 13 7 13 7 21" />
                                        <polyline points="7 3 7 8 15 8" />
                                    </svg>
                                    Simpan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            {{-- Modal Edit Tugas --}}
            <div x-show="modalEditTugas" x-cloak x-transition
                class="fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5">

                <div @click="modalEditTugas = false"
                    class="absolute inset-0 bg-[rgba(45,8,16,0.55)] backdrop-blur-[4px]"></div>

                <div class="relative z-10 w-full max-w-lg max-h-[90vh] overflow-y-auto">
                    <div
                        class="bg-white rounded-[18px] shadow-[0_24px_60px_rgba(107,26,43,0.22),0_4px_16px_rgba(0,0,0,0.08)] overflow-hidden border border-[rgba(107,26,43,0.1)]">

                        <div class="px-6 py-[18px] flex items-center justify-between relative overflow-hidden sticky top-0 z-10"
                            style="background: linear-gradient(135deg,#6B1A2B 0%,#4A0F1E 55%,#2D0810 100%);">
                            <div
                                class="absolute w-[120px] h-[120px] rounded-full top-[-40px] right-[10px] border border-[rgba(232,147,10,0.2)] pointer-events-none">
                            </div>
                            <div
                                class="absolute w-[70px] h-[70px] rounded-full top-[10px] right-[70px] border border-[rgba(232,147,10,0.12)] pointer-events-none">
                            </div>

                            <div class="flex items-center gap-3 relative">
                                <div
                                    class="w-[38px] h-[38px] rounded-[10px] bg-[rgba(232,147,10,0.2)] flex items-center justify-center flex-shrink-0">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="#F5A623" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-[15px] m-0 mb-[2px]">Edit Tugas</h3>
                                    <p class="text-[rgba(255,255,255,0.5)] text-[11px] m-0">Ubah data tugas</p>
                                </div>
                            </div>

                            <button type="button" @click="modalEditTugas = false"
                                class="w-[30px] h-[30px] rounded-lg bg-[rgba(255,255,255,0.12)] hover:bg-[rgba(255,255,255,0.22)] border-none cursor-pointer flex items-center justify-center relative transition-all duration-200">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="#fff" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="h-[3px]" style="background: linear-gradient(90deg,#E8930A,#F5A623,#E8930A);">
                        </div>

                        <form :action="'/tugas/' + editTugasData.id" method="POST" enctype="multipart/form-data"
                            class="p-6 flex flex-col gap-[18px]"
                            x-data="{
                                pertemuanData: @js($allPertemuan->keyBy('id')),
                                getEditPertemuanDate() {
                                    if (!editTugasData.id_pertemuan || !this.pertemuanData[editTugasData.id_pertemuan]) return '';
                                    const pertemuan = this.pertemuanData[editTugasData.id_pertemuan];
                                    return pertemuan.tanggal || '';
                                }
                            }">
                            @csrf
                            @method('PUT')

                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Pertemuan <span class="text-red-500">*</span>
                                </label>
                                <select name="id_pertemuan" x-model="editTugasData.id_pertemuan" required
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                    <option value="">-- Pilih Pertemuan --</option>
                                    @foreach ($allPertemuan as $p)
                                        <option value="{{ $p->id }}">
                                            Pertemuan {{ $p->nomor_pertemuan }} - 
                                            [{{ $p->jadwalBelajar?->kelas?->nama_kelas ?? 'Tanpa Kelas' }}] -
                                            {{ $p->jadwalBelajar?->guruMapel?->mapel?->nama_mapel ?? ($p->jadwalBelajar?->mapel?->nama_mapel ?? 'Tanpa Mapel') }}
                                            @if($p->tanggal)
                                                |  {{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}
                                            @endif
                                            @if($p->jadwalBelajar?->jamBelajar)
                                                |  {{ \Carbon\Carbon::parse($p->jadwalBelajar->jamBelajar->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($p->jadwalBelajar->jamBelajar->jam_selesai)->format('H:i') }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 italic">💡 Tugas akan ditampilkan hanya untuk siswa di
                                    kelas yang dipilih</p>
                            </div>

                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Guru <span class="text-red-500">*</span>
                                </label>
                                <select name="id_guru" x-model="editTugasData.id_guru" required
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach ($gurus as $g)
                                        <option value="{{ $g->id }}">{{ $g->user->name ?? 'Guru ' . $g->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Judul Tugas <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="judul" x-model="editTugasData.judul" required
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Tipe Tugas <span class="text-red-500">*</span>
                                    </label>
                                    <select name="tipe_tugas" x-model="tipeTugasEdit" required
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                        <option value="individu">Individu</option>
                                        <option value="kelompok">Kelompok</option>
                                    </select>
                                </div>

                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Tipe File <span class="text-red-500">*</span>
                                    </label>
                                    <select name="tipe_file" x-model="tipeFileEdit" required
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                        <option value="tanpa">Tanpa File</option>
                                        <option value="dokumen">Dokumen/Gambar (PDF/DOC/JPG/PNG)</option>
                                        <option value="video">Video (MP4)</option>
                                        <option value="link">Link/URL</option>
                                    </select>
                                </div>
                            </div>

                            <div x-show="tipeFileEdit !== 'tanpa' && tipeFileEdit !== 'link'"
                                class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    File Lampiran <span
                                        class="text-gray-400 font-normal normal-case tracking-normal">(opsional -
                                        kosongkan jika tidak ingin mengubah)</span>
                                </label>
                                <input type="file" name="file_url"
                                    :disabled="tipeFileEdit === 'tanpa' || tipeFileEdit === 'link'"
                                    :accept="tipeFileEdit === 'video' ? '.mp4,.webm' : '.pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp'"
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                <p class="text-xs text-gray-500" x-show="tipeFileEdit === 'dokumen'">File saat ini: <span
                                        x-text="editTugasData.file_url ? editTugasData.file_url.split('/').pop() : 'Tidak ada'"></span> · Format: PDF, DOC, DOCX, JPG, PNG, GIF, WebP (Maks 100MB)
                                </p>
                                <p class="text-xs text-gray-500" x-show="tipeFileEdit === 'video'">File saat ini: <span
                                        x-text="editTugasData.file_url ? editTugasData.file_url.split('/').pop() : 'Tidak ada'"></span> · Format: MP4, WebM (Maks 100MB)
                                </p>
                            </div>

                            <div x-show="tipeFileEdit === 'link'" class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Tautan (URL) <span class="text-red-500">*</span>
                                </label>
                                <input type="url" name="file_url_link" x-model="editTugasData.file_url"
                                    :required="tipeFileEdit === 'link'"
                                    :disabled="tipeFileEdit !== 'link'"
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Batas Waktu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="datetime-local" name="batas_waktu"
                                        x-model="editTugasData.batas_waktu" required
                                        :min="getEditPertemuanDate()"
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                    <p class="text-xs text-gray-500 italic" x-show="editTugasData.id_pertemuan && getEditPertemuanDate()"> Minimal tanggal: <span x-text="new Date(getEditPertemuanDate()).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'})"></span></p>
                                </div>

                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Nilai Maksimal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="nilai_maksimal"
                                        x-model="editTugasData.nilai_maksimal" required min="1" max="1000"
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                </div>
                            </div>


                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="allow_late" value="1"
                                        x-model="editTugasData.allow_late"
                                        class="w-4 h-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                    <label class="text-sm text-gray-700 font-medium">Izinkan pengumpulan terlambat</label>
                                </div>
                                <div class="pl-6 text-xs text-gray-600 space-y-1">
                                    <p>✓ <strong>Dicentang:</strong> Siswa dapat mengumpulkan setelah batas waktu, nilai tetap dinilai guru</p>
                                    <p>✗ <strong>Tidak dicentang:</strong> Pengumpulan setelah batas waktu otomatis bernilai 0</p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Deskripsi <span
                                        class="text-gray-400 font-normal normal-case tracking-normal">(opsional)</span>
                                </label>
                                <textarea name="deskripsi" x-model="editTugasData.deskripsi" rows="3"
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white"></textarea>
                            </div>

                            {{-- Scheduled Release Section --}}
                            <div class="border-t border-gray-200 pt-4 mt-2">
                                <h4 class="text-[12px] font-bold text-gray-700 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Pengaturan Waktu Rilis
                                </h4>

                                {{-- Auto Release Toggle --}}
                                <div class="flex items-start gap-3 mb-4 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                                    <input type="checkbox" name="auto_release" id="auto_release_edit" value="1" x-model="autoReleaseEdit"
                                        class="mt-0.5 w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                                    <div class="flex-1">
                                        <label for="auto_release_edit" class="text-[13px] font-semibold text-gray-700 cursor-pointer">
                                            Rilis Otomatis Sesuai Jadwal Pertemuan
                                        </label>
                                        <p class="text-[11px] text-gray-600 mt-0.5">
                                            Tugas akan otomatis dirilis sesuai waktu mulai jam belajar pertemuan yang dipilih
                                        </p>
                                    </div>
                                </div>

                                {{-- Manual Release Time --}}
                                <div x-show="!autoReleaseEdit" x-cloak class="space-y-3">
                                    <div class="flex flex-col gap-[7px]">
                                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                            Waktu Rilis Manual
                                        </label>
                                        <input type="datetime-local" name="waktu_rilis" x-model="editTugasData.waktu_rilis"
                                            class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                    </div>

                                    <div class="flex flex-col gap-[7px]">
                                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                            Batas Waktu Absensi <span class="text-gray-400 font-normal normal-case tracking-normal">(opsional)</span>
                                        </label>
                                        <input type="datetime-local" name="batas_absensi" x-model="editTugasData.batas_absensi"
                                            class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                        <p class="text-xs text-gray-500">Default: 24 jam setelah waktu rilis</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-[10px] pt-[6px] border-t border-gray-100">
                                <button type="button" @click="modalEditTugas = false"
                                    class="inline-flex items-center gap-[6px] px-5 py-[9px] text-[13.5px] font-semibold bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-[10px] cursor-pointer transition-all duration-200">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center gap-[6px] px-[22px] py-[9px] text-[13.5px] font-bold text-white border-none rounded-[10px] cursor-pointer transition-all duration-200 shadow-[0_2px_8px_rgba(107,26,43,0.25)] hover:opacity-90"
                                    style="background: linear-gradient(135deg,#6B1A2B,#9B3045);">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                                        <polyline points="17 21 17 13 7 13 7 21" />
                                        <polyline points="7 3 7 8 15 8" />
                                    </svg>
                                    Update
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>

        </div>
    </div>

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
</x-app-layout>
