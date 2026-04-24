<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('guru.index') }}"
                    class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition"
                    title="Kembali ke Data Guru">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Trash — Data Guru
                    </h1>
                    <p class="text-sm text-gray-400 mt-0.5">{{ $gurus->total() }} data terhapus</p>
                </div>
            </div>

            {{-- Aksi massal --}}
            @if ($gurus->total() > 0)
                <div class="flex gap-2">
                    <form action="{{ route('guru.restoreAll') }}" method="POST"
                        onsubmit="return confirm('Kembalikan SEMUA data guru yang ada di trash?')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Restore Semua
                        </button>
                    </form>

                    <form action="{{ route('guru.forceDeleteAll') }}" method="POST"
                        onsubmit="return confirm('HAPUS PERMANEN semua data guru di trash?\nTindakan ini TIDAK BISA dibatalkan!')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Permanen Semua
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div
                class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
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
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Dihapus Pada</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($gurus as $guru)
                        <tr class="hover:bg-red-50/40 transition">
                            <td class="px-4 py-3 text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-medium text-gray-400 line-through">{{ $guru->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-gray-400">{{ $guru->email }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $badge =
                                        [
                                            'pengajar' => 'bg-blue-100 text-blue-600',
                                            'walikelas' => 'bg-purple-100 text-purple-600',
                                            'keduanya' => 'bg-green-100 text-green-600',
                                        ][$guru->status_pengajar] ?? 'bg-gray-100 text-gray-500';
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badge }} opacity-50">
                                    {{ ucfirst($guru->status_pengajar) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-400 text-xs">
                                {{ $guru->deleted_at->diffForHumans() }}
                                <br>
                                <span class="text-gray-300">{{ $guru->deleted_at->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">

                                    {{-- Restore --}}
                                    <form action="{{ route('guru.restore', $guru->id) }}" method="POST"
                                        onsubmit="return confirm('Kembalikan data guru {{ addslashes($guru->nama_lengkap) }}?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded text-xs font-medium transition">
                                            Restore
                                        </button>
                                    </form>

                                    {{-- Force Delete --}}
                                    <form action="{{ route('guru.forceDelete', $guru->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus PERMANEN data guru {{ addslashes($guru->nama_lengkap) }}?\nTidak bisa dibatalkan!')">
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
                            <td colspan="6" class="px-4 py-14 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <p class="text-sm font-medium">Trash kosong</p>
                                    <a href="{{ route('guru.index') }}"
                                        class="text-xs text-indigo-400 hover:underline">Kembali ke Data Guru</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($gurus->hasPages())
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $gurus->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
