<x-app-layout>
    @include('siswa.modal-create')
    @include('siswa.modal-edit')
    @include('siswa.import')

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Data Siswa
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Manajemen Data Siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 py-6">

        {{-- Header Aksi --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Data Siswa</h1>
            <div class="flex flex-wrap gap-2">

                {{-- Kirim Email Semua --}}
                <form action="{{ route('siswa.sendEmailAll') }}" method="POST"
                    onsubmit="return confirm('Kirim email akun ke SEMUA siswa? Password mereka akan direset.')">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Kirim Email Semua
                    </button>
                </form>

                {{-- Export --}}
                <a href="{{ route('siswa.export') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    Export Excel
                </a>

                {{-- Import --}}
                <button onclick="openImportSiswaModal()"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition">
                    Import Excel
                </button>

                {{-- Trash --}}
                <a href="{{ route('siswa.trash') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition">
                    🗑 Trash
                    @if ($trashCount > 0)
                        <span
                            class="bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">{{ $trashCount }}</span>
                    @endif
                </a>

                {{-- Tambah --}}
                <button onclick="openCreateSiswaModal()"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                    Tambah Siswa
                </button>

            </div>
        </div>

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('siswa.index') }}" class="mb-5">
            <div class="flex flex-wrap gap-3 items-center">

                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau email..."
                    class="border rounded-lg px-3 py-2 text-sm w-64 focus:ring focus:ring-indigo-200 focus:outline-none">

                <select name="id_kelas"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-indigo-200 focus:outline-none">
                    <option value="">Semua Kelas</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('id_kelas') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <select name="agama"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-indigo-200 focus:outline-none">
                    <option value="">Semua Agama</option>
                    @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                        <option value="{{ $agama }}" {{ request('agama') === $agama ? 'selected' : '' }}>
                            {{ $agama }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                    Filter
                </button>

                @if (request()->hasAny(['search', 'id_kelas', 'agama']))
                    <a href="{{ route('siswa.index') }}"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg text-sm font-medium transition">
                        Reset
                    </a>
                @endif

            </div>
        </form>

        {{-- Alert --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tabel --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">NO</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal Lahir</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Agama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Kelas</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($siswas as $siswa)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $siswas->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $siswa->nama_lengkap ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $siswa->email ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $siswa->agama ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $siswa->Kelas?->nama_kelas ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">

                                    {{-- Send Email --}}
                                    <form action="{{ route('siswa.sendEmail', $siswa->id) }}" method="POST"
                                        onsubmit="return confirm('Kirim email akun ke {{ addslashes($siswa->nama_lengkap) }}?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs font-medium transition">
                                            Send Email
                                        </button>
                                    </form>

                                    {{-- Edit --}}
                                    <button onclick="openEditSiswaModal(this)" data-id="{{ $siswa->id }}"
                                        data-nama="{{ $siswa->nama_lengkap }}" data-email="{{ $siswa->email }}"
                                        data-agama="{{ $siswa->agama }}" data-kelas="{{ $siswa->id_kelas }}"
                                        data-tanggal_lahir="{{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '' }}"
                                        class="px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white rounded text-xs font-medium transition">
                                        Edit
                                    </button>

                                    {{-- Hapus --}}
                                    <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            data-nama="{{ $siswa->nama_lengkap }}"
                                            onclick="return confirm('Hapus data siswa ' + this.dataset.nama + '?')"
                                            class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded text-xs font-medium transition">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                {{ request()->hasAny(['search', 'id_kelas', 'agama']) ? 'Tidak ada data yang sesuai filter.' : 'Belum ada data siswa.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $siswas->links() }}
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function openCreateSiswaModal() {
                document.getElementById('modalCreateSiswa').classList.remove('hidden');
            }

            function closeCreateSiswaModal() {
                document.getElementById('modalCreateSiswa').classList.add('hidden');
            }

            function openEditSiswaModal(button) {
                const modal = document.getElementById('modalEditSiswa');
                const d = button.dataset;

                document.getElementById('editSiswaForm').action = `/siswa/${d.id}`;
                document.getElementById('edit_siswa_id').value = d.id;
                document.getElementById('edit_nama_lengkap').value = d.nama;
                document.getElementById('edit_email').value = d.email;
                document.getElementById('edit_tanggal_lahir').value = d.tanggal_lahir;
                document.getElementById('edit_agama').value = d.agama;
                document.getElementById('edit_id_kelas').value = d.kelas;

                modal.classList.remove('hidden');
            }

            function closeEditSiswaModal() {
                document.getElementById('modalEditSiswa').classList.add('hidden');
            }

            function openImportSiswaModal() {
                document.getElementById('modalImportSiswa').classList.remove('hidden');
            }

            function closeImportSiswaModal() {
                document.getElementById('modalImportSiswa').classList.add('hidden');
            }

            function openEditSiswaModalFromOld() {
                const modal = document.getElementById('modalEditSiswa');
                const form = document.getElementById('editSiswaForm');
                const id = "{{ old('edit_id') }}";

                document.getElementById('edit_siswa_id').value = id;
                document.getElementById('edit_nama_lengkap').value = "{{ old('nama_lengkap') }}";
                document.getElementById('edit_email').value = "{{ old('email') }}";
                document.getElementById('edit_tanggal_lahir').value = "{{ old('tanggal_lahir') }}";
                document.getElementById('edit_agama').value = "{{ old('agama') }}";
                document.getElementById('edit_id_kelas').value = "{{ old('id_kelas') }}";
                form.action = `/siswa/${id}`;

                modal.classList.remove('hidden');
            }

            document.addEventListener('DOMContentLoaded', function() {
                @if ($errors->any())
                    const modalType = @json(old('_modal'));

                    const handlers = {
                        create: () => openCreateSiswaModal(),
                        edit: () => openEditSiswaModalFromOld(),
                        import: () => openImportSiswaModal(),
                    };

                    if (handlers[modalType]) {
                        handlers[modalType]();
                    }
                @endif
            });
        </script>
    @endpush

</x-app-layout>
