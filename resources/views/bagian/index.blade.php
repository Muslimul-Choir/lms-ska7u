<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Bagian') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-800 rounded-lg flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-900 font-bold text-lg leading-none">&times;</button>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                {{-- Table Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700">Daftar Bagian</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('bagian.trash') }}"
                           class="inline-flex items-center gap-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                            🗑 Trash
                        </a>
                        <button type="button" id="btnTambahBagian"
                                class="inline-flex items-center gap-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
                            + Tambah Bagian
                        </button>
                    </div>
                </div>

                <form action="{{ route('bagian.index') }}" method="GET" class="mb-4 flex gap-2">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari nama bagian..."
                        class="border rounded px-3 py-2 w-full"
                    >
                    <button 
                        type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded"
                    >
                        Cari
                    </button>
                </form>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-left w-12">#</th>
                                <th class="px-6 py-3 text-left">Nama Bagian</th>
                                <th class="px-6 py-3 text-left">Deskripsi</th>
                                <th class="px-6 py-3 text-center w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse ($bagians as $bagian)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">{{ $loop->iteration + ($bagians->currentPage() - 1) * $bagians->perPage() }}</td>
                                    <td class="px-6 py-4 font-medium">{{ $bagian->nama_bagian }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bagian->deskripsi ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                data-id="{{ $bagian->id }}"
                                                data-nama="{{ $bagian->nama_bagian }}"
                                                data-deskripsi="{{ $bagian->deskripsi ?? '' }}"
                                                class="btn-edit px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 text-xs font-medium rounded-lg transition">
                                                Edit
                                            </button>
                                            <form action="{{ route('bagian.destroy', $bagian) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus bagian ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                        Belum ada data bagian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($bagians->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $bagians->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Include Modal Partials --}}
    @include('bagian.modal-create')
    @include('bagian.modal-edit')

    {{-- ======================== SCRIPT ======================== --}}
    <script>
        const modalCreate = document.getElementById('modalCreate');
        const modalEdit   = document.getElementById('modalEdit');

        // Buka modal create
        document.getElementById('btnTambahBagian').addEventListener('click', function () {
            modalCreate.style.display = 'block';
        });

        // Tutup modal create
        document.getElementById('closeCreate').addEventListener('click', function () {
            modalCreate.style.display = 'none';
        });
        document.getElementById('cancelCreate').addEventListener('click', function () {
            modalCreate.style.display = 'none';
        });
        document.getElementById('overlayCreate').addEventListener('click', function () {
            modalCreate.style.display = 'none';
        });

        // Tutup modal edit
        document.getElementById('closeEdit').addEventListener('click', function () {
            modalEdit.style.display = 'none';
        });
        document.getElementById('cancelEdit').addEventListener('click', function () {
            modalEdit.style.display = 'none';
        });
        document.getElementById('overlayEdit').addEventListener('click', function () {
            modalEdit.style.display = 'none';
        });

        // Buka modal edit + isi data
        document.querySelectorAll('.btn-edit').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.getElementById('editNamaBagian').value = this.dataset.nama;
                document.getElementById('editDeskripsi').value  = this.dataset.deskripsi;
                document.getElementById('formEdit').action      = `/bagian/${this.dataset.id}`;
                modalEdit.style.display = 'block';
            });
        });

        // Auto buka modal create jika ada validation error
        @if ($errors->any())
            modalCreate.style.display = 'block';
        @endif
    </script>

</x-app-layout>