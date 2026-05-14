<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('siswa.index') }}"
                    class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition">
                    ←
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Trash — Data Siswa</h1>
                    <p class="text-sm text-gray-400 mt-0.5">{{ $siswas->total() }} data terhapus</p>
                </div>
            </div>

            @if ($siswas->total() > 0)
                <div class="flex gap-2">
                    <form action="{{ route('siswa.restoreAll') }}" method="POST"
                        onsubmit="return confirm('Kembalikan SEMUA data siswa yang ada di trash?')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                            ↺ Restore Semua
                        </button>
                    </form>

                    <form action="{{ route('siswa.forceDeleteAll') }}" method="POST"
                        onsubmit="return confirm('HAPUS PERMANEN semua data siswa di trash?\nTindakan ini TIDAK BISA dibatalkan!')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition">
                            🗑 Hapus Permanen Semua
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabel --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Agama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Kelas</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal Lahir</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Dihapus Pada</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($siswas as $siswa)
                        <tr class="hover:bg-red-50/40 transition">
                            <td class="px-4 py-3 text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-medium text-gray-400 line-through">{{ $siswa->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-gray-400">{{ $siswa->email }}</td>
                            <td class="px-4 py-3 text-gray-400">
                                {{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-gray-400">{{ $siswa->agama }}</td>
                            <td class="px-4 py-3 text-gray-400">{{ $siswa->Kelas?->nama_kelas ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-400 text-xs">
                                {{ $siswa->deleted_at->diffForHumans() }}<br>
                                <span class="text-gray-300">{{ $siswa->deleted_at->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">

                                    <form action="{{ route('siswa.restore', $siswa->id) }}" method="POST"
                                        onsubmit="return confirm('Kembalikan data siswa {{ addslashes($siswa->nama_lengkap) }}?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded text-xs font-medium transition">
                                            Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('siswa.forceDelete', $siswa->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus PERMANEN data siswa {{ addslashes($siswa->nama_lengkap) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-medium transition">
                                            Hapus Permanen
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-14 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-300">
                                    <span class="text-5xl">🗑</span>
                                    <p class="text-sm font-medium">Trash kosong</p>
                                    <a href="{{ route('siswa.index') }}"
                                        class="text-xs text-indigo-400 hover:underline">Kembali ke Data Siswa</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($siswas->hasPages())
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $siswas->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
