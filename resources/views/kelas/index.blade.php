<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Manajemen Kelas
            </h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Total: {{ $kelasList->total() }} kelas
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-4">

            {{-- Alert Sukses / Error --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                    class="flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                    <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    class="flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/30 dark:text-red-300">
                    <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Toolbar: Search, Filter, Tombol Aksi --}}
            <div class="rounded-xl bg-white shadow-sm dark:bg-gray-800 p-4">
                <form method="GET" action="{{ route('kelas.index') }}" id="filterForm">
                    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:flex-wrap">

                        {{-- Search --}}
                        <div class="flex-1 min-w-[200px]">
                            <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-400">Cari
                                Kelas</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Tingkatan, jurusan, bagian..."
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 py-2 pl-9 pr-4 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                            </div>
                        </div>

                        {{-- Filter Tahun Ajaran --}}
                        <div class="min-w-[160px]">
                            <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-400">Tahun
                                Ajaran</label>
                            <select name="id_tahun_ajaran"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 py-2 px-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="">Semua Tahun</option>
                                @foreach ($tahunAjaranList as $ta)
                                    <option value="{{ $ta->id }}"
                                        {{ request('id_tahun_ajaran') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->nama_tahun }}
                                        @if ($ta->is_aktif)
                                            (Aktif)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Tingkatan --}}
                        <div class="min-w-[140px]">
                            <label
                                class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-400">Tingkatan</label>
                            <select name="id_tingkatan"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 py-2 px-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="">Semua Tingkat</option>
                                @foreach ($tingkatanList as $t)
                                    <option value="{{ $t->id }}"
                                        {{ request('id_tingkatan') == $t->id ? 'selected' : '' }}>
                                        {{ $t->nama_tingkatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Jurusan --}}
                        <div class="min-w-[160px]">
                            <label
                                class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-400">Jurusan</label>
                            <select name="id_jurusan"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 py-2 px-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="">Semua Jurusan</option>
                                @foreach ($jurusanList as $j)
                                    <option value="{{ $j->id }}"
                                        {{ request('id_jurusan') == $j->id ? 'selected' : '' }}>
                                        {{ $j->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tombol Reset --}}
                        @if (request()->hasAny(['search', 'id_tahun_ajaran', 'id_tingkatan', 'id_jurusan']))
                            <div class="flex items-end">
                                <a href="{{ route('kelas.index') }}"
                                    class="inline-flex items-center gap-1 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Reset
                                </a>
                            </div>
                        @endif

                        {{-- Spacer --}}
                        <div class="flex-1 hidden lg:block"></div>

                        {{-- Tombol Trash --}}
                        <div class="flex items-end">
                            <a href="{{ route('kelas.trash') }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-100 dark:border-red-700 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Tempat Sampah
                            </a>
                        </div>

                        {{-- Tombol Tambah --}}
                        <div class="flex items-end">
                            <button type="button" onclick="openCreateModal()"
                                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Kelas
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Tabel Data --}}
            <div class="rounded-xl bg-white shadow-sm dark:bg-gray-800 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 w-10">
                                    No</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Kelas</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Jurusan</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Tahun Ajaran</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Wali Kelas</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 w-28">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($kelasList as $index => $kelas)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $kelasList->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300">
                                                {{ $kelas->Tingkatan?->nama_tingkatan ?? '-' }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $kelas->Tingkatan?->nama_tingkatan ?? '-' }}
                                                    {{ $kelas->Bagian?->nama_bagian ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $kelas->Jurusan?->nama_jurusan ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $kelas->TahunAjaran?->nama_tahun ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $kelas->WaliKelas?->nama_lengkap ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Edit --}}
                                            <button type="button" onclick="openEditModal(this)"
                                                data-id="{{ $kelas->id }}"
                                                data-tingkatan="{{ $kelas->id_tingkatan }}"
                                                data-jurusan="{{ $kelas->id_jurusan }}"
                                                data-bagian="{{ $kelas->id_bagian }}"
                                                data-tahun="{{ $kelas->id_tahun_ajaran }}"
                                                data-wali="{{ $kelas->id_wali_kelas }}" title="Edit"
                                                class="inline-flex items-center justify-center h-8 w-8 rounded-lg border border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100 dark:border-amber-700 dark:bg-amber-900/20 dark:text-amber-400 transition-colors">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>

                                            {{-- Delete --}}
                                            <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST"
                                                onsubmit="return confirmDelete(event, '{{ $kelas->Tingkatan?->nama_tingkatan }} {{ $kelas->Bagian?->nama_bagian }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus"
                                                    class="inline-flex items-center justify-center h-8 w-8 rounded-lg border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 dark:border-red-700 dark:bg-red-900/20 dark:text-red-400 transition-colors">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2 text-gray-400">
                                            <svg class="h-10 w-10" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-sm font-medium">Tidak ada data kelas</p>
                                            <p class="text-xs">Coba ubah filter atau tambahkan kelas baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($kelasList->hasPages())
                    <div class="border-t border-gray-200 px-4 py-3 dark:border-gray-700">
                        {{ $kelasList->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- MODAL CREATE --}}
    {{-- ============================================ --}}
    @include('kelas.modal-create', [
        'tingkatanList' => $tingkatanList,
        'jurusanList' => $jurusanList,
        'bagianList' => $bagianList,
        'tahunAjaranList' => $tahunAjaranList,
        'guruList' => $guruList,
    ])

    {{-- ============================================ --}}
    {{-- MODAL EDIT --}}
    {{-- ============================================ --}}
    @include('kelas.modal-edit', [
        'tingkatanList' => $tingkatanList,
        'jurusanList' => $jurusanList,
        'bagianList' => $bagianList,
        'tahunAjaranList' => $tahunAjaranList,
        'guruList' => $guruList,
    ])

    @push('scripts')
        <script>
            // ---- Buka modal create ----
            function openCreateModal() {
                document.getElementById('modalCreate').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeCreateModal() {
                document.getElementById('modalCreate').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // ---- Buka modal edit ----
            function openEditModal(btn) {
                try {
                    const d = btn.dataset;

                    document.getElementById('editFormAction').action = `/kelas/${d.id}`;
                    document.getElementById('edit_id').value = d.id;
                    document.getElementById('edit_id_tingkatan').value = d.tingkatan;
                    document.getElementById('edit_id_jurusan').value = d.jurusan;
                    document.getElementById('edit_id_bagian').value = d.bagian;
                    document.getElementById('edit_id_tahun_ajaran').value = d.tahun;
                    document.getElementById('edit_id_wali_kelas').value = d.wali;
                    
                    document.getElementById('modalEdit').classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                } catch (err) {
                    alert('Gagal memuat data. Silakan coba lagi.');
                    console.error(err);
                }
            }

            function closeEditModal() {
                document.getElementById('modalEdit').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // ---- Konfirmasi hapus ----
            function confirmDelete(event, nama) {
                if (!confirm(`Yakin ingin menghapus kelas "${nama}"?\nData akan dipindahkan ke tempat sampah.`)) {
                    event.preventDefault();
                    return false;
                }
                return true;
            }

            // ---- Buka modal jika ada error validasi ----
            @if ($errors->any())
                @if (old('_modal') === 'create')
                    document.addEventListener('DOMContentLoaded', () => openCreateModal());
                @elseif (old('_modal') === 'edit')
                    document.addEventListener('DOMContentLoaded', () => {
                        document.getElementById('modalEdit').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    });
                @endif
            @endif

            // ---- Tutup modal klik backdrop ----
            // document.addEventListener('DOMContentLoaded', () => {
            //     ['modalCreate', 'modalEdit'].forEach(id => {
            //         const modal = document.getElementById(id);
            //         if (modal) {
            //             modal.addEventListener('click', function(e) {
            //                 if (e.target === this) {
            //                     this.classList.add('hidden');
            //                     document.body.classList.remove('overflow-hidden');
            //                 }
            //             });
            //         }
            //     });
            // });
        </script>
    @endpush
</x-app-layout>
