<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-red-500 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Arsip Jam Belajar</h2>
                    <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Terhapus Sementara</p>
                </div>
            </div>

            @if ($jamBelajars->total() > 0)
                <div class="flex gap-2 flex-shrink-0">
                    <form action="{{ route('jambelajar.restoreAll') }}" method="POST" id="restoreAllForm">
                        @csrf
                        @method('PATCH')
                        <button type="button" onclick="confirmRestoreAll(event)"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-semibold rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Pulihkan Semua
                        </button>
                    </form>
                    <form action="{{ route('jambelajar.forceDeleteAll') }}" method="POST" id="forceDeleteAllForm">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmForceDeleteAll(event)"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Permanen Semua
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- Alert Success --}}
            @if (session('success'))
                <div
                    class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()"
                        class="text-emerald-400 hover:text-emerald-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Warning Banner --}}
            <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm">
                <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-xs tracking-widest font-medium leading-relaxed text-red-700">
                    Data dalam arsip telah dihapus sementara. Gunakan tombol aksi untuk memulihkan data dan menghapus data secara permanen.
                </p>
            </div>

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <span class="w-1 h-5 rounded-full bg-red-400 inline-block"></span>
                            Data Jam Belajar Terhapus
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5 ml-3">Daftar record yang dipindahkan ke arsip</p>
                    </div>
                    <a href="{{ route('jambelajar.index') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Data Utama
                    </a>
                </div>

                {{-- Filter Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <form method="GET" action="{{ route('jambelajar.trash') }}">
                        <div class="flex flex-wrap items-end gap-3">

                            {{-- Filter Tingkatan --}}
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tingkatan</label>
                                <select name="tingkatan" onchange="this.form.submit()"
                                    class="rounded-xl border min-w-[130px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition">
                                    <option value="">Semua Tingkatan</option>
                                    @foreach($tingkatanList as $tingkatan)
                                        <option value="{{ $tingkatan->id }}" {{ $filterTingkatan == $tingkatan->id ? 'selected' : '' }}>
                                            {{ $tingkatan->nama_tingkatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Reset --}}
                            @if($filterTingkatan)
                                <a href="{{ route('jambelajar.trash') }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                    </svg>
                                    Reset
                                </a>
                            @endif

                        </div>
                    </form>
                </div>

                {{-- Filter badge --}}
                @if($filterTingkatan)
                    @php $namaTingkatanFilter = $tingkatanList->firstWhere('id', $filterTingkatan)?->nama_tingkatan; @endphp
                    <div class="px-6 py-2.5 bg-amber-50 border-b border-amber-100 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                        </svg>
                        <span class="text-xs text-amber-700 font-medium">
                            Filter aktif: Tingkatan <span class="font-bold">{{ $namaTingkatanFilter }}</span>
                        </span>
                    </div>
                @endif

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest w-12">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Tingkatan</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Jam Ke</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Jam Mulai</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Jam Selesai</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Dihapus Pada</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($jamBelajars as $index => $jamBelajar)
                                <tr class="hover:bg-red-50/30 transition">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($jamBelajars->firstItem() + $index, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-red-50 border border-red-100 text-xs font-semibold text-red-400 line-through decoration-red-300">
                                            {{ $jamBelajar->tingkatan?->nama_tingkatan ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100 text-xs font-bold text-gray-500">
                                            Jam ke-{{ $jamBelajar->jam_ke ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <polyline points="12 6 12 12 16 14"/>
                                                </svg>
                                            </div>
                                            <span class="font-semibold text-gray-400 text-sm line-through decoration-red-300">
                                                {{ \Carbon\Carbon::parse($jamBelajar->jam_mulai)->format('H:i') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400 text-sm font-semibold line-through decoration-red-300">
                                        {{ \Carbon\Carbon::parse($jamBelajar->jam_selesai)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 border border-red-100 rounded-lg">
                                            <svg class="w-3 h-3 text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-red-500 text-[11px] font-medium whitespace-nowrap">
                                                {{ $jamBelajar->deleted_at?->format('d M Y, H:i') ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Restore --}}
                                            <form action="{{ route('jambelajar.restore', $jamBelajar->id) }}" method="POST"
                                                onsubmit="confirmRestore(event)">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            {{-- Force Delete --}}
                                            <form action="{{ route('jambelajar.force-delete', $jamBelajar->id) }}" method="POST"
                                                onsubmit="confirmForceDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">
                                                {{ $filterTingkatan ? 'Tidak ada data terhapus untuk tingkatan ini' : 'Tempat sampah kosong' }}
                                            </p>
                                            <p class="text-gray-300 text-xs">
                                                {{ $filterTingkatan ? 'Coba pilih tingkatan lain atau reset filter' : 'Tidak ada data jam belajar yang dihapus sementara' }}
                                            </p>
                                            @if($filterTingkatan)
                                                <a href="{{ route('jambelajar.trash') }}"
                                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition mt-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                                    </svg>
                                                    Reset Filter
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($jamBelajars->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Menampilkan
                            <span class="font-semibold text-gray-700">{{ $jamBelajars->firstItem() }}–{{ $jamBelajars->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $jamBelajars->total() }}</span>
                            entri
                        </p>
                        {{ $jamBelajars->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('components.alerts.success')
    @include('components.alerts.error')
    @include('components.alerts.confirm-delete')
    @include('components.alerts.confirm-restore')
    @include('components.alerts.confirm-restore-all')
    @include('components.alerts.confirm-force-delete-all')

    @push('scripts')
        <script>
            function confirmForceDelete(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmDelete(false).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }

            function confirmRestore(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmRestore('jam belajar').then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }

            function confirmRestoreAll(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmRestoreAll('Jam Belajar').then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }

            function confirmForceDeleteAll(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmForceDeleteAll('Jam Belajar').then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }
        </script>
    @endpush
</x-app-layout>
