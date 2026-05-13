<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Guru Mapel
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Manajemen Penugasan Guru ke Mapel</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide" aria-label="Breadcrumb">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <span>Master Data</span>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <span class="text-slate-600 font-semibold">Guru Mapel</span>
            </nav>

            {{-- Alert Success --}}
            @if (session('success'))
                <div role="alert" class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" aria-label="Tutup notifikasi" class="text-emerald-400 hover:text-emerald-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Daftar Guru Mapel</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Kelola penugasan guru ke mata pelajaran</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('guru_mapel.trash') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition backdrop-blur-sm"
                           title="Lihat data yang dihapus">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Trash
                        </a>
                        <button type="button" id="btnTambahGuruMapel"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#C8992A] hover:bg-[#b5861f] text-white text-xs font-semibold rounded-lg transition shadow-md shadow-amber-900/20"
                                title="Tambah data guru mapel baru">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Guru Mapel
                        </button>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="px-6 py-3 bg-slate-50 border-b border-slate-100">
                    <div class="flex items-center gap-2 max-w-md">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none" aria-hidden="true">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="search" id="searchInput" value="{{ request('search') }}"
                                   placeholder="Cari nama mapel atau guru..."
                                   autocomplete="off"
                                   class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition">
                        </div>
                        <button type="button" id="btnSearch"
                                class="px-4 py-2 bg-[#1B3A6B] hover:bg-[#0F2145] text-white text-sm font-medium rounded-lg transition">
                            Cari
                        </button>
                        @if(request()->hasAny(['search']))
                            <button type="button" id="btnReset"
                                    class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm rounded-lg transition">
                                Reset
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm" aria-label="Daftar Guru Mapel">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest w-12">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Mapel</th>
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Guru</th>
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Kelas</th>
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Semester</th>
                                <th scope="col" class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="guruMapelTableBody" class="divide-y divide-slate-100">
                            @forelse ($guruMapels as $guruMapel)
                                <tr class="hover:bg-slate-50/70 transition group">

                                    {{-- No --}}
                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($guruMapels->currentPage() - 1) * $guruMapels->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Mapel --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-md bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0">
                                                <span class="text-[#1B3A6B] text-[10px] font-bold uppercase">
                                                    {{ substr($guruMapel->Mapel->nama_mapel ?? '-', 0, 2) }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-[#0F2145] text-sm">{{ $guruMapel->Mapel->nama_mapel ?? '-' }}</span>
                                        </div>
                                    </td>

                                    {{-- Guru --}}
                                    <td class="px-6 py-4 text-slate-600 text-sm">
                                        {{ $guruMapel->Guru->nama_lengkap ?? '-' }}
                                    </td>

                                    {{-- Kelas --}}
                                    <td class="px-6 py-4 text-slate-600 text-sm">
                                        {{ trim(
                                            ($guruMapel->Kelas->Tingkatan->nama_tingkatan ?? '') . ' ' .
                                            ($guruMapel->Kelas->Jurusan->nama_jurusan ?? '') . ' ' .
                                            ($guruMapel->Kelas->Bagian->nama_bagian ?? '')
                                        ) ?: '-' }}
                                    </td>

                                    {{-- Semester --}}
                                    <td class="px-6 py-4 text-slate-600 text-sm">
                                        {{ $guruMapel->Semester->nama_semester ?? '-' }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                data-id="{{ $guruMapel->id }}"
                                                data-id_mapel="{{ $guruMapel->id_mapel }}"
                                                data-id_guru="{{ $guruMapel->id_guru }}"
                                                data-id_kelas="{{ $guruMapel->id_kelas }}"
                                                data-id_semester="{{ $guruMapel->id_semester }}"
                                                class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </button>
                                            <form action="{{ route('guru_mapel.destroy', $guruMapel) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus penugasan guru mapel ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 text-sm font-medium">Belum ada data guru mapel</p>
                                            <p class="text-slate-300 text-xs">Klik <span class="font-semibold text-slate-400">Tambah Guru Mapel</span> untuk mulai menambahkan data</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($guruMapels->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-slate-500">
                            Menampilkan
                            <span class="font-semibold text-slate-700">{{ $guruMapels->firstItem() }}–{{ $guruMapels->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $guruMapels->total() }}</span>
                            entri
                        </p>
                        {{ $guruMapels->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @include('guru_mapel.modal-create')
    @include('guru_mapel.modal-edit')

    <script>
        const modalCreate = document.getElementById('modalCreate');
        const modalEdit = document.getElementById('modalEdit');
        const searchInput = document.getElementById('searchInput');
        const btnSearch = document.getElementById('btnSearch');
        const btnReset = document.getElementById('btnReset');
        const tableBody = document.getElementById('guruMapelTableBody');

        let currentPage = 1;
        let currentSearch = '{{ $search }}';

        function loadData(search = '', page = 1) {
            fetch(`{{ route('guru_mapel.index') }}?search=${encodeURIComponent(search)}&page=${page}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => renderTable(data.guru_mapels, page))
            .catch(error => console.error('Error:', error));
        }

        function renderTable(guruMapels, page) {
            if (guruMapels.length === 0) {
                tableBody.innerHTML = `
                    <tr><td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <p class="text-slate-400 text-sm font-medium">Belum ada data guru mapel</p>
                        </div>
                    </td></tr>`;
                return;
            }

            tableBody.innerHTML = guruMapels.map((guruMapel, i) => {
                const no = String((page - 1) * 5 + i + 1).padStart(3, '0');
                const namaKelas = [guruMapel.kelas?.tingkatan?.nama_tingkatan, guruMapel.kelas?.jurusan?.nama_jurusan, guruMapel.kelas?.bagian?.nama_bagian].filter(Boolean).join(' ') || '-';
                const singkatan = (guruMapel.mapel?.nama_mapel ?? '-').substring(0, 2).toUpperCase();

                return `<tr class="hover:bg-slate-50/70 transition group">
                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">${no}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-md bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0">
                                <span class="text-[#1B3A6B] text-[10px] font-bold uppercase">${singkatan}</span>
                            </div>
                            <span class="font-semibold text-[#0F2145] text-sm">${guruMapel.mapel?.nama_mapel ?? '-'}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600 text-sm">${guruMapel.guru?.nama_lengkap ?? '-'}</td>
                    <td class="px-6 py-4 text-slate-600 text-sm">${namaKelas}</td>
                    <td class="px-6 py-4 text-slate-600 text-sm">${guruMapel.semester?.nama_semester ?? '-'}</td>
                    <td class="px-6 py-4"><div class="flex items-center justify-center gap-2">
                        <button type="button" data-id="${guruMapel.id}" data-id_mapel="${guruMapel.id_mapel}" data-id_guru="${guruMapel.id_guru}" data-id_kelas="${guruMapel.id_kelas}" data-id_semester="${guruMapel.id_semester}" class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </button>
                        <form action="{{ url('guru_mapel') }}/${guruMapel.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus penugasan guru mapel ini?')" style="display: inline;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus
                            </button>
                        </form>
                    </div></td>
                </tr>`;
            }).join('');

            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('editIdMapel').value = this.dataset.id_mapel;
                    document.getElementById('editIdGuru').value = this.dataset.id_guru;
                    document.getElementById('editIdKelas').value = this.dataset.id_kelas;
                    document.getElementById('editIdSemester').value = this.dataset.id_semester;
                    document.getElementById('editForm').action = `{{ url('guru_mapel') }}/${this.dataset.id}`;
                    modalEdit.style.display = 'block';
                });
            });
        }

        btnSearch.addEventListener('click', () => {
            currentSearch = searchInput.value;
            currentPage = 1;
            loadData(currentSearch, currentPage);
        });

        searchInput.addEventListener('keypress', e => e.key === 'Enter' && btnSearch.click());

        if (btnReset) {
            btnReset.addEventListener('click', () => {
                searchInput.value = '';
                currentSearch = '';
                currentPage = 1;
                loadData('', 1);
            });
        }

        document.getElementById('btnTambahGuruMapel').addEventListener('click', () => modalCreate.style.display = 'block');
        document.getElementById('closeCreate')?.addEventListener('click', () => modalCreate.style.display = 'none');
        document.getElementById('cancelCreate')?.addEventListener('click', () => modalCreate.style.display = 'none');
        document.getElementById('overlayCreate')?.addEventListener('click', () => modalCreate.style.display = 'none');

        document.getElementById('closeEdit')?.addEventListener('click', () => modalEdit.style.display = 'none');
        document.getElementById('cancelEdit')?.addEventListener('click', () => modalEdit.style.display = 'none');
        document.getElementById('overlayEdit')?.addEventListener('click', () => modalEdit.style.display = 'none');
    </script>
</x-app-layout>