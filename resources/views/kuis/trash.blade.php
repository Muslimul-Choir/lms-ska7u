<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-red-500 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Arsip Kuis</h2>
                    <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Terhapus Sementara</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-gray-400 font-medium">
                <a href="{{ route('dashboard') }}" class="text-amber-600 hover:text-amber-700 transition">Dashboard</a>
                <span class="text-gray-300">/</span>
                <span>Konten & Evaluasi</span>
                <span class="text-gray-300">/</span>
                <a href="{{ route('kuis.index') }}" class="hover:text-amber-600 transition">Kuis</a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600 font-semibold">Arsip</span>
            </nav>

            {{-- Warning Banner --}}
            <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"/>
                </svg>
                <p class="text-xs tracking-widest font-medium leading-relaxed text-red-700">
                    Data kuis dalam arsip telah diarsipkan sementara. Gunakan tombol aksi untuk memulihkan atau menghapus data secara permanen beserta soal dan data riwayat hasil pengerjaan terkait.
                </p>
            </div>

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Data Kuis Terhapus</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Kelola data kuis yang diarsipkan</p>
                    </div>
                    <a href="{{ route('kuis.index') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Data Utama
                    </a>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest w-12">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Kuis</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Mapel</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Dihapus Pada</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($kuisList as $kuis)
                                <tr class="hover:bg-red-50/10 transition opacity-90">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-700 text-sm">
                                            {{ $kuis->judul }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-0.5">
                                            Pertemuan {{ $kuis->Pertemuan->nomor_pertemuan ?? '-' }} • Status Asal: {{ ucfirst($kuis->status) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-600 text-sm">
                                            {{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 border border-red-100 rounded-lg">
                                            <svg class="w-3 h-3 text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-red-500 text-[11px] font-medium whitespace-nowrap">
                                                {{ $kuis->deleted_at ? \Carbon\Carbon::parse($kuis->deleted_at)->format('d M Y, H:i') : '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            {{-- Restore --}}
                                            <form action="{{ route('kuis.restore', $kuis->id) }}" method="POST"
                                                onsubmit="confirmRestore(event)">
                                                @csrf @method('PATCH')
                                                <button type="submit" title="Pulihkan"
                                                    class="w-8 h-8 flex items-center justify-center bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-200 rounded-lg transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            {{-- Force Delete --}}
                                            <form action="{{ route('kuis.force-delete', $kuis->id) }}" method="POST"
                                                onsubmit="confirmForceDelete(event)">
                                                @csrf @method('DELETE')
                                                <button type="submit" title="Hapus Permanen"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">Tempat sampah kosong</p>
                                            <p class="text-gray-300 text-xs">Tidak ada data kuis yang dihapus sementara.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    @include('components.alerts.success')
    @include('components.alerts.error')
    @include('components.alerts.confirm-delete')
    @include('components.alerts.confirm-restore')

    @push('scripts')
    <script>
        function confirmRestore(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            showConfirmRestore(true).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }

        function confirmForceDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            showConfirmDelete(true).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }
    </script>
    @endpush
</x-app-layout>
