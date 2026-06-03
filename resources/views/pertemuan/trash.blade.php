<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-red-700 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Trash — Pertemuan
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Data Terhapus Sementara</p>
            </div>
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
            <div class="flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-sm shadow-sm">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-red-700 text-xs font-medium leading-relaxed">
                    Data dalam trash telah dihapus sementara. Gunakan <span class="font-bold">Pulihkan</span> untuk
                    mengembalikan,
                    atau <span class="font-bold">Hapus Permanen</span> untuk menghapus selamanya tanpa bisa dipulihkan.
                </p>
            </div>

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4
                            border-b border-slate-100 bg-gradient-to-r from-[#6B1A1A] to-[#B91C1C]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Data Pertemuan Terhapus</h3>
                        <p class="text-red-200 text-xs mt-0.5">Daftar record yang telah dipindahkan ke trash</p>
                    </div>
                    <a href="{{ route('pertemuan.index') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20
                              text-white text-xs font-medium rounded-lg border border-white/20 transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Data Utama
                    </a>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest w-12">
                                    #</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    Jadwal Belajar</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-28">
                                    No. Pertemuan</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest w-36">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-32">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    Dihapus Pada</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-52">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($pertemuans as $pertemuan)
                                <tr class="hover:bg-red-50/40 transition group">

                                    {{-- No --}}
                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($pertemuans->currentPage() - 1) * $pertemuans->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Jadwal Belajar --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div
                                                class="w-7 h-7 rounded-md bg-red-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <span
                                                class="font-semibold text-slate-500 text-sm line-through decoration-red-300">
                                                {{ $pertemuan->jadwalBelajar->nama_jadwal ?? 'Jadwal #' . $pertemuan->id_jadwal }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Nomor Pertemuan --}}
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-400 text-xs font-bold">
                                            {{ $pertemuan->nomor_pertemuan }}
                                        </span>
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="px-6 py-4">
                                        @if ($pertemuan->tanggal)
                                            <span class="text-slate-400 text-sm line-through decoration-red-300">
                                                {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-slate-300 text-xs italic">Belum ditentukan</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusMap = [
                                                'dijadwalkan' => ['#EFF6FF', '#93C5FD', '#BFDBFE', 'Dijadwalkan'],
                                                'berlangsung' => ['#FFFBEB', '#FCD34D', '#FDE68A', 'Berlangsung'],
                                                'selesai' => ['#F0FDF4', '#86EFAC', '#BBF7D0', 'Selesai'],
                                                'dibatalkan' => ['#FEF2F2', '#FCA5A5', '#FECACA', 'Dibatalkan'],
                                            ];
                                            [$bg, $color, $border, $label] = $statusMap[$pertemuan->status] ?? [
                                                '#F9FAFB',
                                                '#9CA3AF',
                                                '#E5E7EB',
                                                $pertemuan->status,
                                            ];
                                        @endphp
                                        <span
                                            style="display:inline-flex; align-items:center; padding:3px 10px; background:{{ $bg }}; color:{{ $color }}; border:1px solid {{ $border }}; font-size:10px; font-weight:700; border-radius:99px; opacity:.8;">
                                            {{ $label }}
                                        </span>
                                    </td>

                                    {{-- Deleted At --}}
                                    <td class="px-6 py-4">
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2 py-1 bg-red-50 border border-red-100 rounded-md">
                                            <svg class="w-3 h-3 text-red-400 flex-shrink-0" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-red-500 text-[11px] font-medium whitespace-nowrap">
                                                {{ $pertemuan->deleted_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('pertemuan.restore', $pertemuan->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Pulihkan
                                                </button>
                                            </form>

                                            {{-- Force Delete --}}
                                            <form action="{{ route('pertemuan.force-delete', $pertemuan->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Hapus permanen? Data tidak bisa dipulihkan!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus Permanen
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-slate-300" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 text-sm font-medium">Trash kosong</p>
                                            <p class="text-slate-300 text-xs">Tidak ada data pertemuan yang dihapus
                                                sementara</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($pertemuans->hasPages())
                    <div
                        class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-slate-500">
                            Menampilkan
                            <span
                                class="font-semibold text-slate-700">{{ $pertemuans->firstItem() }}–{{ $pertemuans->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $pertemuans->total() }}</span>
                            entri
                        </p>
                        {{ $pertemuans->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
