<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Manajemen Siswa</h2>
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
                <span class="text-gray-600 font-semibold">Siswa</span>
            </nav>

            {{-- Alert Error --}}
            @if (session('error'))
                <div
                    class="flex items-center justify-between px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Skipped Import Details --}}
            @if (session('skipped_details'))
                <div class="px-5 py-4 bg-amber-50 border border-amber-200 rounded-xl text-sm">
                    <p class="font-semibold text-amber-700 mb-2">Baris yang ditolak saat import:</p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="border-b border-amber-200">
                                    <th class="py-1.5 pr-4 text-left font-bold text-amber-700">Baris</th>
                                    <th class="py-1.5 pr-4 text-left font-bold text-amber-700">Email</th>
                                    <th class="py-1.5 text-left font-bold text-amber-700">Alasan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-100">
                                @foreach (session('skipped_details') as $skipped)
                                    <tr>
                                        <td class="py-1.5 pr-4 text-amber-800">{{ $skipped['row'] }}</td>
                                        <td class="py-1.5 pr-4 text-amber-800">{{ $skipped['email'] }}</td>
                                        <td class="py-1.5 text-amber-800">{{ $skipped['reason'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div
                    class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Daftar Siswa</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Kelola data siswa</p>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        {{-- Trash --}}
                        <a href="{{ route('siswa.trash') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Arsip
                            @if ($trashCount > 0)
                                <span
                                    class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold leading-none">{{ $trashCount }}</span>
                            @endif
                        </a>
                        {{-- Send Email Semua --}}
                        <form action="{{ route('siswa.sendEmailAll') }}" method="POST" id="sendEmailAllSiswaForm">
                            @csrf
                            <button type="button" onclick="confirmSendEmailAllSiswa(event)"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 text-xs font-semibold rounded-xl transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Kirim Email Semua
                            </button>
                        </form>
                        {{-- Export --}}
                        <a id="exportSiswaBtn" href="{{ route('siswa.export') }}" onclick="handleExportSiswa(this)"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-200 text-xs font-semibold rounded-xl transition">
                            <svg id="exportSiswaIcon" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                            </svg>
                            <span id="exportSiswaText">Export Excel</span>
                        </a>
                        {{-- Import --}}
                        <button type="button" onclick="openImportSiswaModal()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-sky-50 hover:bg-sky-100 text-sky-600 border border-sky-200 text-xs font-semibold rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            Import Excel
                        </button>
                        {{-- Tambah --}}
                        <button type="button" onclick="openCreateSiswaModal()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Siswa
                        </button>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <form method="GET" action="{{ route('siswa.index') }}" id="filterSiswaForm">
                        <div class="flex flex-wrap items-end gap-3">

                            {{-- Search --}}
                            <div class="flex flex-col gap-1 flex-1 min-w-[200px]">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Cari
                                    Siswa</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Cari nama atau email..."
                                        class="w-full pl-9 pr-3 py-2 text-xs bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                                </div>
                            </div>

                            {{-- Kelas --}}
                            <div class="flex flex-col gap-1">
                                <label
                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kelas</label>
                                <select name="id_kelas"
                                    class="rounded-xl border min-w-[115px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition"
                                    onchange="document.getElementById('filterSiswaForm').submit()">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelasList as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            {{ request('id_kelas') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Agama --}}
                            <div class="flex flex-col gap-1">
                                <label
                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Agama</label>
                                <select name="agama"
                                    class="rounded-xl border min-w-[100px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition"
                                    onchange="document.getElementById('filterSiswaForm').submit()">
                                    <option value="">Semua</option>
                                    @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                        <option value="{{ $agama }}"
                                            {{ request('agama') === $agama ? 'selected' : '' }}>
                                            {{ $agama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit"
                                class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                                Cari
                            </button>

                            @if (request()->filled('search') || request()->filled('id_kelas') || request()->filled('agama'))
                                <a href="{{ route('siswa.index') }}"
                                    class="px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-medium rounded-xl border border-gray-200 transition">
                                    Reset
                                </a>
                            @endif

                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest w-12">
                                    #</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Nama Lengkap</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest hidden md:table-cell">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest hidden lg:table-cell">
                                    Tgl Lahir</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest hidden lg:table-cell">
                                    Agama</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest hidden lg:table-cell">
                                    Kelas</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-36">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($siswas as $index => $siswa)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($siswas->firstItem() + $index, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-amber-600 text-[10px] font-bold uppercase">
                                                    {{ strtoupper(substr($siswa->nama_lengkap, 0, 2)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm leading-tight">
                                                    {{ $siswa->nama_lengkap ?? '-' }}</p>
                                                <p class="text-xs text-gray-400 mt-0.5 md:hidden">
                                                    {{ $siswa->email ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-sm hidden md:table-cell">
                                        {{ $siswa->email ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-sm hidden lg:table-cell">
                                        {{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border bg-gray-100 text-gray-600 border-gray-200">
                                            {{ $siswa->agama ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border bg-sky-100 text-sky-700 border-sky-200">
                                            {{ $siswa->Kelas?->nama_kelas ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            {{-- Send Email --}}
                                            <form action="{{ route('siswa.sendEmail', $siswa->id) }}" method="POST"
                                                class="sendEmailSiswaForm">
                                                @csrf
                                                <button type="button"
                                                    onclick="confirmSendEmailSiswa(event, '{{ addslashes($siswa->nama_lengkap) }}')"
                                                    title="Kirim Email"
                                                    class="w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            {{-- Edit --}}
                                            <button type="button" onclick="openEditSiswaModal(this)"
                                                data-id="{{ $siswa->id }}"
                                                data-route="{{ route('siswa.update', $siswa->id) }}"
                                                data-nama="{{ $siswa->nama_lengkap }}"
                                                data-email="{{ $siswa->email }}"
                                                data-tanggal_lahir="{{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '' }}"
                                                data-agama="{{ $siswa->agama }}" data-kelas="{{ $siswa->id_kelas }}"
                                                title="Edit"
                                                class="w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            {{-- Delete --}}
                                            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDeleteSiswa(event)"
                                                    title="Hapus"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">Belum ada data siswa</p>
                                            <p class="text-gray-300 text-xs">Ubah filter atau klik <span
                                                    class="font-semibold text-gray-400">+ Tambah Siswa</span></p>
                                            <button type="button" onclick="openCreateSiswaModal()"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah Siswa
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($siswas->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Menampilkan
                            <span
                                class="font-semibold text-gray-700">{{ $siswas->firstItem() }}–{{ $siswas->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $siswas->total() }}</span>
                            entri
                        </p>
                        {{ $siswas->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('components.alerts.confirm-update')
    @include('components.alerts.confirm-delete')
    @include('components.alerts.success')
    @include('components.alerts.error')

    @include('siswa.modal-create')
    @include('siswa.modal-edit')
    @include('siswa.import')

    @push('scripts')
        <script>
            /* ── Export Excel ── */
            function handleExportSiswa(el) {
                if (el.dataset.loading === 'true') return false;
                el.dataset.loading = 'true';
                el.classList.add('opacity-60', 'cursor-not-allowed');
                el.disabled = true;
                document.getElementById('exportSiswaIcon').outerHTML = `
                    <svg id="exportSiswaIcon" class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                `;
                document.getElementById('exportSiswaText').textContent = 'Mengunduh...';
                setTimeout(() => {
                    const btn = document.getElementById('exportSiswaBtn');
                    if (!btn) return;
                    btn.dataset.loading = 'false';
                    btn.classList.remove('opacity-60', 'cursor-not-allowed');
                    btn.disabled = false;
                    document.getElementById('exportSiswaIcon').outerHTML = `
                        <svg id="exportSiswaIcon" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z"/>
                        </svg>
                    `;
                    document.getElementById('exportSiswaText').textContent = 'Export Excel';
                }, 5000);
            }

            /* ── Modal Create ── */
            function openCreateSiswaModal() {
                document.getElementById('modalCreateSiswa').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeCreateSiswaModal() {
                document.getElementById('modalCreateSiswa').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Modal Edit ── */
            function openEditSiswaModal(button) {
                const d = button.dataset;
                const modal = document.getElementById('modalEditSiswa');
                const form = document.getElementById('editSiswaForm');
                const btn = document.getElementById('editSiswaSubmitBtn');

                form.action = d.route;
                document.getElementById('edit_route').value = d.route ?? '';
                document.getElementById('edit_siswa_id').value = d.id ?? '';
                document.getElementById('edit_nama_lengkap').value = d.nama ?? '';
                document.getElementById('edit_email_siswa').value = d.email ?? '';
                document.getElementById('edit_tanggal_lahir').value = d.tanggal_lahir ?? '';
                document.getElementById('edit_agama').value = d.agama ?? '';
                document.getElementById('edit_id_kelas').value = d.kelas ?? '';

                btn.disabled = false;
                btn.innerHTML = `
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Update
                `;

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeEditSiswaModal() {
                document.getElementById('modalEditSiswa').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Modal Import ── */
            function openImportSiswaModal() {
                document.getElementById('modalImportSiswa').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeImportSiswaModal() {
                document.getElementById('modalImportSiswa').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Confirm Delete ── */
            function confirmDeleteSiswa(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmDelete(true).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }

            /* ── Confirm Send Email Single ── */
            function confirmSendEmailSiswa(event, namaSiswa) {
                event.preventDefault();
                const form = event.target.closest('form');
                const btn = event.target.closest('button');
                Swal.fire({
                    title: 'Kirim Email Akun?',
                    html: `Kirim email akun ke <strong>${namaSiswa}</strong>?<br><small class="text-amber-600">Password akan direset secara otomatis.</small>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d97706',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, kirim email',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.disabled = true;
                        btn.classList.add('opacity-60', 'cursor-not-allowed');
                        btn.innerHTML = `
                            <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                        `;
                        form.submit();
                    }
                });
            }

            /* ── Confirm Send Email All ── */
            function confirmSendEmailAllSiswa(event) {
                event.preventDefault();
                const btn = event.target.closest('button');
                const form = document.getElementById('sendEmailAllSiswaForm');
                Swal.fire({
                    title: 'Kirim Email ke Semua Siswa?',
                    html: `Email akun akan dikirim ke <strong>semua siswa</strong>.<br><small class="text-amber-600">Password semua siswa akan direset secara otomatis.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d97706',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, kirim semua',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.disabled = true;
                        btn.classList.add('opacity-60', 'cursor-not-allowed');
                        btn.innerHTML = `
                            <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            Mengirim...
                        `;
                        form.submit();
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', () => {

                /* Anti double-submit create */
                const createForm = document.getElementById('createSiswaFormAction');
                const createBtn = document.getElementById('createSiswaSubmitBtn');
                if (createForm) {
                    createForm.addEventListener('submit', () => {
                        createBtn.disabled = true;
                        createBtn.innerHTML = `
                            <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            Menyimpan...
                        `;
                    });
                }

                /* Anti double-submit edit + confirm update */
                const editForm = document.getElementById('editSiswaForm');
                const editBtn = document.getElementById('editSiswaSubmitBtn');
                if (editForm) {
                    editForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        showConfirmUpdate().then((result) => {
                            if (result.isConfirmed) {
                                editBtn.disabled = true;
                                editBtn.innerHTML = `
                                    <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                    </svg>
                                    Menyimpan...
                                `;
                                editForm.submit();
                            }
                        });
                    });
                }

                /* Re-open modal on validation error */
                @if ($errors->any())
                    @if (old('_modal') === 'create')
                        openCreateSiswaModal();
                    @elseif (old('_modal') === 'edit')
                        const savedRoute = document.getElementById('edit_route').value;
                        if (savedRoute) {
                            document.getElementById('editSiswaForm').action = savedRoute;
                        }
                        document.getElementById('modalEditSiswa').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    @elseif (old('_modal') === 'import')
                        openImportSiswaModal();
                    @endif
                @endif

                /* Close modal on backdrop click */
                ['modalCreateSiswa', 'modalEditSiswa', 'modalImportSiswa'].forEach(id => {
                    const modal = document.getElementById(id);
                    if (modal) {
                        modal.addEventListener('click', function(e) {
                            if (e.target === this) {
                                this.classList.add('hidden');
                                document.body.classList.remove('overflow-hidden');
                            }
                        });
                    }
                });

            });
        </script>
    @endpush

</x-app-layout>
