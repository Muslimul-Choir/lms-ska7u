<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a1 1 0 011-1h4a1 1 0 011 1v2" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] uppercase">Trash Mapel</h2>
                <p class="text-[11px] text-slate-400 uppercase tracking-widest">Data yang dihapus sementara</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="text-xs text-slate-400 flex gap-2">
                <span class="text-[#1B3A6B]">Dashboard</span> /
                <span>Mapel</span> /
                <span class="text-slate-600 font-semibold">Trash</span>
            </nav>

            {{-- Card --}}
            <div class="bg-white rounded-xl border shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm">Data Mapel Terhapus</h3>
                        <p class="text-blue-200 text-xs">Kelola restore & hapus permanen</p>
                    </div>

                    <a href="{{ route('mapel.index') }}"
                       class="px-3 py-2 bg-white/10 hover:bg-white/20 text-white text-xs rounded-lg border border-white/20">
                        Kembali
                    </a>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">

                        <thead class="bg-slate-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-bold">Nama Mapel</th>
                                <th class="px-6 py-3 text-left text-xs font-bold">Deskripsi</th>
                                <th class="px-6 py-3 text-center text-xs font-bold">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                            @forelse ($mapels as $mapel)
                                <tr class="hover:bg-slate-50">

                                    <td class="px-6 py-4 font-bold text-[#1B3A6B]">
                                        {{ $mapel->kode_mapel }}
                                    </td>

                                    <td class="px-6 py-4 font-semibold">
                                        {{ $mapel->nama_mapel }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $mapel->deskripsi ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('mapel.restore', $mapel->id) }}" method="POST">
                                                @csrf
                                                <button class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs">
                                                    Restore
                                                </button>
                                            </form>

                                            {{-- Force Delete --}}
                                            <form action="{{ route('mapel.forceDelete', $mapel->id) }}" method="POST"
                                                  onsubmit="return confirm('Hapus permanen data ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-xs">
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-10 text-slate-400">
                                        Tidak ada data di trash
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t bg-slate-50">
                    {{ $mapels->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>