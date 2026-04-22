<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Semester') }}
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
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700">Daftar Semester</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('semester.trash') }}"
                           class="inline-flex items-center gap-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                            🗑 Trash
                        </a>
                        <button type="button" id="btnTambahSemester"
                                class="inline-flex items-center gap-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
                            + Tambah Semester
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-left w-12">#</th>
                                <th class="px-6 py-3 text-left">Nama Semester</th>
                                <th class="px-6 py-3 text-center w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse ($semesters as $semester)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        {{ $loop->iteration + ($semesters->currentPage() - 1) * $semesters->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 font-medium">
                                        {{ $semester->nama_semester }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                data-id="{{ $semester->id }}"
                                                data-nama="{{ $semester->nama_semester }}"
                                                class="btn-edit px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 text-xs font-medium rounded-lg transition">
                                                Edit
                                            </button>

                                            <form action="{{ route('semester.destroy', $semester) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus semester ini?')">
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
                                    <td colspan="3" class="px-6 py-10 text-center text-gray-400">
                                        Belum ada data semester.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($semesters->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $semesters->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal --}}
    @include('semester.modal-create')
    @include('semester.modal-edit')

    {{-- SCRIPT --}}
    <script>
        const modalCreate = document.getElementById('modalCreate');
        const modalEdit   = document.getElementById('modalEdit');

        // Open Create
        document.getElementById('btnTambahSemester').addEventListener('click', function () {
            modalCreate.style.display = 'block';
        });

        // Close Create
        document.getElementById('closeCreate').onclick = () => modalCreate.style.display = 'none';
        document.getElementById('cancelCreate').onclick = () => modalCreate.style.display = 'none';
        document.getElementById('overlayCreate').onclick = () => modalCreate.style.display = 'none';

        // Close Edit
        document.getElementById('closeEdit').onclick = () => modalEdit.style.display = 'none';
        document.getElementById('cancelEdit').onclick = () => modalEdit.style.display = 'none';
        document.getElementById('overlayEdit').onclick = () => modalEdit.style.display = 'none';

        // Open Edit
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('editNamaSemester').value = this.dataset.nama;
                document.getElementById('formEdit').action = `/semester/${this.dataset.id}`;
                modalEdit.style.display = 'block';
            });
        });

        // Auto open modal if error
        @if ($errors->any())
            modalCreate.style.display = 'block';
        @endif
    </script>

</x-app-layout>