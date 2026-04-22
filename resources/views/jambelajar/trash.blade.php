<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-red-600 text-center">
            Trash Jam Belajar
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6">

        <a href="{{ route('jambelajar.index') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            Kembali
        </a>

        <div class="bg-white shadow rounded p-4">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th>No</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($trash as $key => $item)
                    <tr class="border-b">
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->jam_mulai }}</td>
                        <td>{{ $item->jam_selesai }}</td>
                        <td class="flex gap-2">

                            <form action="{{ route('jambelajar.restore', $item->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <button type="submit">
        Restore
    </button>
</form>

                            <form action="{{ route('jambelajar.force-delete', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded">
                                    Delete Permanen
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>