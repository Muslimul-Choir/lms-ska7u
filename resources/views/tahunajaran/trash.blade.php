<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trash — Tahun Ajaran') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-800 rounded-lg flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-900 font-bold text-lg leading-none">&times;</button>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700">Data Tahun Ajaran Terhapus</h3>
                    <a href="{{ route('tahunajaran.index') }}"
                        class="inline-flex items-center gap-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                            ← Data Utama
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-left w-12">#</th>
                                <th class="px-6 py-3 text-left">Nama Tahun Ajaran</th>
                                <th class="px-6 py-3 text-left">Dihapus Pada</th>
                                <th class="px-6 py-3 text-center w-44">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse ($tahunAjarans as $tahun)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        {{ $loop->iteration + ($tahunAjarans->currentPage() - 1) * $tahunAjarans->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 font-medium">
                                        {{ $tahun->nama_tahun }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-400 text-xs">
                                        {{ $tahun->deleted_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('tahunajaran.restore', $tahun->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 text-xs font-medium rounded-lg transition">
                                                    Pulihkan
                                                </button>
                                            </form>

                                            {{-- Force Delete --}}
                                            <form action="{{ route('tahunajaran.force-delete', $tahun->id) }}" method="POST"
                                                  onsubmit="return confirm('Hapus permanen? Data tidak bisa dipulihkan!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg transition">
                                                    Hapus Permanen
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                        Tidak ada data di trash.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($tahunAjarans->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $tahunAjarans->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>