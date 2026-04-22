<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold mb-6 text-center text-green-600">
            Jam Belajar
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">

        {{-- Button --}}
        <div class="flex gap-2 mb-4">
            <button onclick="openCreateModal()"
                class="bg-green-600 text-white px-4 py-2 rounded">
                + Tambah
            </button>

            <a href="{{ route('jambelajar.trash') }}"
                class="bg-red-500 text-white px-4 py-2 rounded">
                Trash
            </a>
        </div>

        {{-- Table --}}
        <div class="bg-white shadow rounded p-4">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="p-2">No</th>
                        <th class="p-2">Jam Mulai</th>
                        <th class="p-2">Jam Selesai</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($jamBelajars as $key => $item)
                    <tr class="border-b">
                        <td class="p-2">{{ $key+1 }}</td>
                        <td class="p-2">{{ $item->jam_mulai }}</td>
                        <td class="p-2">{{ $item->jam_selesai }}</td>
                        <td class="p-2 flex gap-2">

                            <button
                                onclick="openEditModal({{ $item }})"
                                class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Edit
                            </button>

                            <form action="{{ route('jambelajar.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('jambelajar.modal-create')
    @include('jambelajar.modal-edit')

    <script>
        function openCreateModal(){
            document.getElementById('createModal').style.display = 'block';
        }

        function openEditModal(data){
            document.getElementById('editModal').style.display = 'block';

            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_jam_mulai').value = data.jam_mulai;
            document.getElementById('edit_jam_selesai').value = data.jam_selesai;
        }
    </script>
</x-app-layout>