<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Manajemen Guru</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Master</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">
            

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
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Daftar Guru</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Kelola data guru dan tenaga pengajar</p>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        {{-- Trash --}}
                        <a href="{{ route('guru.trash') }}"
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
                        <form action="{{ route('guru.sendEmailAll') }}" method="POST" id="sendEmailAllForm">
                            @csrf
                            <button type="button" onclick="confirmSendEmailAll(event)"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 text-xs font-semibold rounded-xl transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Kirim Semua Email
                            </button>
                        </form>
                        {{-- Export --}}
                        <a id="exportBtn" href="{{ route('guru.export') }}" onclick="handleExport(this)"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-200 text-xs font-semibold rounded-xl transition">
                            <svg id="exportIcon" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                            </svg>
                            <span id="exportText">Export Excel</span>
                        </a>
                        {{-- Import --}}
                        <button type="button" onclick="openImportGuruModal()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-sky-50 hover:bg-sky-100 text-sky-600 border border-sky-200 text-xs font-semibold rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            Import Excel
                        </button>
                        {{-- Tambah --}}
                        <button type="button" onclick="openCreateGuruModal()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Guru
                        </button>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <form method="GET" action="{{ route('guru.index') }}" id="filterForm">
                        <div class="flex flex-wrap items-end gap-3">

                            {{-- Search --}}
                            <div class="flex flex-col gap-1 flex-1 min-w-[200px]">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Cari
                                    Guru</label>
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

                            {{-- Status --}}
                            <div class="flex flex-col gap-1">
                                <label
                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</label>
                                <select name="status_pengajar"
                                    class="rounded-xl border min-w-[115px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Status</option>
                                    <option value="pengajar"
                                        {{ request('status_pengajar') == 'pengajar' ? 'selected' : '' }}>Pengajar
                                    </option>
                                    <option value="walikelas"
                                        {{ request('status_pengajar') == 'walikelas' ? 'selected' : '' }}>Wali Kelas
                                    </option>
                                    <option value="keduanya"
                                        {{ request('status_pengajar') == 'keduanya' ? 'selected' : '' }}>Keduanya
                                    </option>
                                </select>
                            </div>

                            <button type="submit"
                                class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                                Cari
                            </button>

                            @if (request()->filled('search') || request()->filled('status_pengajar'))
                                <a href="{{ route('guru.index') }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
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
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-36">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($gurus as $index => $guru)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($gurus->firstItem() + $index, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-amber-600 text-[10px] font-bold uppercase">
                                                    {{ strtoupper(substr($guru->nama_lengkap, 0, 2)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm leading-tight">
                                                    {{ $guru->nama_lengkap }}</p>
                                                <p class="text-xs text-gray-400 mt-0.5 md:hidden">{{ $guru->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-sm hidden md:table-cell">
                                        {{ $guru->email }}
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        @php
                                            $badgeClass = match ($guru->status_pengajar) {
                                                'pengajar' => 'bg-sky-100 text-sky-700 border-sky-200',
                                                'walikelas' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'keduanya' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                default => 'bg-gray-100 text-gray-600 border-gray-200',
                                            };
                                            $badgeLabel = match ($guru->status_pengajar) {
                                                'pengajar' => 'Pengajar',
                                                'walikelas' => 'Wali Kelas',
                                                'keduanya' => 'Keduanya',
                                                default => ucfirst($guru->status_pengajar),
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $badgeClass }}">
                                            {{ $badgeLabel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            {{-- Send Email --}}
                                            <form action="{{ route('guru.sendEmail', $guru->id) }}" method="POST"
                                                class="sendEmailForm">
                                                @csrf
                                                <button type="button"
                                                    onclick="confirmSendEmail(event, '{{ addslashes($guru->nama_lengkap) }}')"
                                                    title="Kirim Email"
                                                    class="w-8 h-8 flex items-center justify-center bg-sky-50 hover:bg-sky-100 text-sky-600 border border-sky-200 rounded-lg transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                                    </svg>
                                                </button>
                                            </form>
                                            {{-- Edit --}}
                                            <button type="button" onclick="openEditGuruModal(this)"
                                                data-id="{{ $guru->id }}"
                                                data-route="{{ route('guru.update', $guru->id) }}"
                                                data-nama="{{ $guru->nama_lengkap }}"
                                                data-email="{{ $guru->email }}"
                                                data-status="{{ $guru->status_pengajar }}" title="Edit"
                                                class="w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            {{-- Delete --}}
                                            <form action="{{ route('guru.destroy', $guru->id) }}" method="POST"
                                                onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus"
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
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">Belum ada data guru</p>
                                            <p class="text-gray-300 text-xs">Ubah filter atau klik <span
                                                    class="font-semibold text-gray-400">+ Tambah Guru</span></p>
                                            <button type="button" onclick="openCreateGuruModal()"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah Guru
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($gurus->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Menampilkan
                            <span
                                class="font-semibold text-gray-700">{{ $gurus->firstItem() }}–{{ $gurus->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $gurus->total() }}</span>
                            entri
                        </p>
                        {{ $gurus->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('components.alerts.confirm-update')
    @include('components.alerts.confirm-delete')
    @include('components.alerts.success')
    @include('components.alerts.error')

    @include('guru.modal-create')
    @include('guru.modal-edit')
    @include('guru.import')

    @push('scripts')
        <script>
            /* ── Export Excel ── */
            function handleExport(el) {
                if (el.dataset.loading === 'true') return false;

                el.dataset.loading = 'true';
                el.classList.add('opacity-60', 'cursor-not-allowed', 'pointer-events-none');

                document.getElementById('exportIcon').outerHTML = `
                    <svg id="exportIcon" class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                `;
                document.getElementById('exportText').textContent = 'Mengunduh...';

                // Reset otomatis setelah 5 detik (antisipasi jika download selesai / gagal)
                setTimeout(() => {
                    const btn = document.getElementById('exportBtn');
                    if (!btn) return;

                    btn.dataset.loading = 'false';
                    btn.classList.remove('opacity-60', 'cursor-not-allowed', 'pointer-events-none');

                    document.getElementById('exportIcon').outerHTML = `
                        <svg id="exportIcon" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>
                    `;
                    document.getElementById('exportText').textContent = 'Export Excel';
                }, 5000);
            }

            /* ── Modal Create ── */
            function openCreateGuruModal() {
                document.getElementById('modalCreateGuru').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeCreateGuruModal() {
                document.getElementById('modalCreateGuru').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Modal Edit ── */
            function openEditGuruModal(button) {
                const d = button.dataset;
                const modal = document.getElementById('modalEditGuru');
                const form = document.getElementById('editGuruForm');
                const btn = document.getElementById('editGuruSubmitBtn');

                form.action = d.route;
                document.getElementById('edit_route_guru').value = d.route;
                document.getElementById('edit_guru_id').value = d.id ?? '';
                document.getElementById('edit_nama_lengkap').value = d.nama ?? '';
                document.getElementById('edit_email').value = d.email ?? '';
                document.getElementById('edit_status_pengajar').value = d.status ?? '';

                btn.disabled = false;
                btn.innerHTML = `
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Simpan Perubahan
                `;

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeEditGuruModal() {
                document.getElementById('modalEditGuru').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Modal Import ── */
            function openImportGuruModal() {
                document.getElementById('modalImportGuru').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeImportGuruModal() {
                document.getElementById('modalImportGuru').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Confirm Delete ── */
            function confirmDelete(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmDelete(true).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }

            /* ── Confirm Send Email Single ── */
            function confirmSendEmail(event, namaGuru) {
                event.preventDefault();
                const form = event.target.closest('form');
                const btn = event.target.closest('button');
                Swal.fire({
                    title: 'Kirim Email Akun?',
                    html: `Kirim email akun ke <strong>${namaGuru}</strong>?<br><small class="text-amber-600">Password akan direset secara otomatis.</small>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d97706',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, kirim email',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.classList.add('opacity-60', 'cursor-not-allowed');
                        btn.disabled = true;
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
            function confirmSendEmailAll(event) {
                event.preventDefault();
                const btn = event.target.closest('button');
                const form = document.getElementById('sendEmailAllForm');
                Swal.fire({
                    title: 'Kirim Email ke Semua Guru?',
                    html: `Email akun akan dikirim ke <strong>semua guru</strong>.<br><small class="text-amber-600">Password semua guru akan direset secara otomatis.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d97706',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, kirim semua',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.classList.add('opacity-60', 'cursor-not-allowed');
                        btn.disabled = true;

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

                /* Anti double-submit */
                const createForm = document.getElementById('createGuruFormAction');
                const createBtn = document.getElementById('createGuruSubmitBtn');
                const editForm = document.getElementById('editGuruForm');
                const editBtn = document.getElementById('editGuruSubmitBtn');

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
                        openCreateGuruModal();
                    @elseif (old('_modal') === 'edit')
                        const savedRoute = document.getElementById('edit_route_guru').value;
                        if (savedRoute) {
                            document.getElementById('editGuruForm').action = savedRoute;
                        }
                        document.getElementById('modalEditGuru').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    @elseif (old('_modal') === 'import')
                        openImportGuruModal();
                    @endif
                @endif

                /* Close modal on backdrop click */
                ['modalCreateGuru', 'modalEditGuru', 'modalImportGuru'].forEach(id => {
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
