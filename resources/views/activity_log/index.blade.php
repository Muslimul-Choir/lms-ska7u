<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Activity Log</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Catatan Aktivitas Sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen" x-data="{
        showModal: false,
        detailData: null,
        openDetail(log) {
            this.detailData = log;
            this.showModal = true;
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-gray-400 font-medium">
                <a href="{{ route('dashboard') }}" class="text-amber-600 hover:text-amber-700 transition">Dashboard</a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600 font-semibold">Activity Log</span>
            </nav>

            {{-- Search, Filter & Export Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <span class="w-1 h-5 rounded-full bg-amber-500 inline-block"></span>
                            Filter & Pencarian
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5 ml-3">Cari aktivitas berdasarkan kata kunci atau jenis aksi</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('activity-log.index') }}"
                      class="flex flex-wrap items-center gap-2">

                    {{-- Search --}}
                    <div class="relative flex-1 min-w-[200px]">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}"
                               placeholder="Cari aktivitas, modul, atau email..."
                               class="w-full pl-9 pr-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 focus:bg-white transition">
                    </div>

                    {{-- Filter Aksi --}}
                    <div class="relative">
                        <select name="filter_aksi"
                                class="appearance-none pl-3 pr-8 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition cursor-pointer">
                            <option value="semua" {{ request('filter_aksi') == 'semua' ? 'selected' : '' }}>Semua Aksi</option>
                            <option value="CREATE" {{ request('filter_aksi') == 'CREATE' ? 'selected' : '' }}>CREATE</option>
                            <option value="UPDATE" {{ request('filter_aksi') == 'UPDATE' ? 'selected' : '' }}>UPDATE</option>
                            <option value="DELETE" {{ request('filter_aksi') == 'DELETE' ? 'selected' : '' }}>DELETE</option>
                            <option value="LOGIN"  {{ request('filter_aksi') == 'LOGIN'  ? 'selected' : '' }}>LOGIN</option>
                            <option value="LOGOUT" {{ request('filter_aksi') == 'LOGOUT' ? 'selected' : '' }}>LOGOUT</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>

                    @if(request('q') || (request('filter_aksi') && request('filter_aksi') != 'semua'))
                        <a href="{{ route('activity-log.index') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reset
                        </a>
                    @endif

                    <button type="submit" name="export" value="1"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded-xl transition shadow-sm ml-auto">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Ekspor CSV
                    </button>
                </form>
            </div>

            {{-- Main Table Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                        <span class="w-1 h-5 rounded-full bg-amber-500 inline-block"></span>
                        Daftar Aktivitas
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5 ml-3">Riwayat seluruh aktivitas pengguna di sistem</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-12">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Waktu</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Pengguna</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Aksi / Modul</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Deskripsi</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-24">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($logs as $log)
                                <tr class="hover:bg-amber-50/40 transition group">
                                    <td class="px-6 py-4 text-center text-gray-400 text-xs font-mono">
                                        {{ $logs->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="font-semibold text-gray-800 text-sm">{{ $log->created_at->format('d M Y') }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $log->created_at->format('H:i:s') }}</p>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-amber-600 text-[10px] font-bold uppercase">
                                                    {{ substr($log->user->name ?? 'SY', 0, 2) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm leading-tight">{{ $log->user->name ?? 'System/Guest' }}</p>
                                                <p class="text-[10px] text-gray-400">{{ $log->user->email ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeMap = [
                                                'LOGIN'  => ['bg-emerald-50', 'text-emerald-700', 'border-emerald-200'],
                                                'LOGOUT' => ['bg-gray-100',   'text-gray-600',    'border-gray-200'],
                                                'CREATE' => ['bg-blue-50',    'text-blue-700',    'border-blue-200'],
                                                'UPDATE' => ['bg-amber-50',   'text-amber-700',   'border-amber-200'],
                                                'DELETE' => ['bg-red-50',     'text-red-600',     'border-red-200'],
                                                'VIEW'   => ['bg-cyan-50',    'text-cyan-700',    'border-cyan-200'],
                                            ];
                                            [$bg, $text, $border] = $badgeMap[strtoupper($log->aksi)] ?? ['bg-gray-100','text-gray-600','border-gray-200'];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 {{ $bg }} {{ $text }} border {{ $border }} text-[10px] font-bold uppercase tracking-wide rounded-full">
                                            {{ $log->aksi }}
                                        </span>
                                        <p class="text-[10px] text-gray-500 font-semibold mt-1 tracking-wider">{{ $log->modul ?? '—' }}</p>
                                    </td>

                                    <td class="px-6 py-4 text-gray-500 text-sm max-w-xs">
                                        <div class="line-clamp-2" title="{{ $log->deskripsi }}">
                                            {{ $log->deskripsi }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <button type="button"
                                                @click='openDetail(@json($log))'
                                                class="w-8 h-8 flex items-center justify-center mx-auto bg-gray-50 hover:bg-amber-50 text-gray-400 hover:text-amber-600 border border-gray-200 hover:border-amber-200 rounded-lg transition"
                                                title="Lihat Detail">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">Data tidak ditemukan</p>
                                            <p class="text-gray-300 text-xs">Coba gunakan kata kunci atau filter lain.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($logs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Menampilkan
                            <span class="font-semibold text-gray-700">{{ $logs->firstItem() }}–{{ $logs->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $logs->total() }}</span>
                            entri
                        </p>
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Modal Detail Log ── --}}
        <div x-show="showModal"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4">

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" style="position:absolute; inset:0; background:rgba(45,8,16,0.55); backdrop-filter:blur(4px);"
             @click="showModal = false">
            </div>
            

            {{-- Modal --}}
            <div x-show="showModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="relative z-10 w-full max-w-xl overflow-hidden bg-white border border-gray-200 shadow-2xl rounded-2xl flex flex-col max-h-[90vh]">

                {{-- Header --}}
                <div class="relative flex items-center justify-between px-6 py-5 overflow-hidden bg-gradient-to-br from-[#6B1A2B] via-[#4A0F1E] to-[#2D0810]">

                    {{-- Decorative Circle --}}
                    <div class="absolute top-[-40px] right-[10px] w-[120px] h-[120px] rounded-full border border-amber-400/20 pointer-events-none"></div>
                    <div class="absolute top-[10px] right-[70px] w-[70px] h-[70px] rounded-full border border-amber-400/10 pointer-events-none"></div>

                    <div class="relative flex items-center gap-3">
                        <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-xl bg-amber-500/20">
                            <svg class="w-5 h-5 text-amber-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-[15px] font-bold text-white">
                                Detail Activity Log
                            </h3>

                            <p class="mt-0.5 text-[11px] tracking-wide text-white/50 uppercase">
                                Informasi Aktivitas Sistem
                            </p>
                        </div>
                    </div>

                    {{-- Close --}}
                    <button type="button"
                            @click="showModal = false"
                            class="relative flex items-center justify-center w-8 h-8 transition rounded-lg bg-white/10 hover:bg-white/20">
                        <svg class="w-4 h-4 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Accent Bar --}}
                <div class="h-[3px] bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500"></div>

                {{-- Notice --}}
                <div class="flex items-center gap-2 px-6 py-3 border-b bg-amber-50 border-amber-200">
                    <svg class="flex-shrink-0 w-4 h-4 text-amber-600"
                        fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/>
                    </svg>

                    <p class="text-[11.5px] font-medium text-amber-800">
                        Data Activity Log bersifat read-only dan telah tersimpan aman di database.
                    </p>
                </div>

                {{-- Body --}}
                <div class="p-6 overflow-y-auto bg-gray-50 space-y-4">

                    <template x-if="detailData">

                        <div class="space-y-4">

                            {{-- Info Grid --}}
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                                {{-- Aksi --}}
                                <div class="p-4 bg-white border border-gray-200 shadow-sm rounded-xl">
                                    <span class="block mb-2 text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                                        Aksi
                                    </span>

                                    <template x-if="detailData.aksi === 'CREATE'">
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide text-blue-700 uppercase border rounded-full bg-blue-50 border-blue-200">
                                            CREATE
                                        </span>
                                    </template>

                                    <template x-if="detailData.aksi === 'UPDATE'">
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide text-amber-700 uppercase border rounded-full bg-amber-50 border-amber-200">
                                            UPDATE
                                        </span>
                                    </template>

                                    <template x-if="detailData.aksi === 'DELETE'">
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide text-red-700 uppercase border rounded-full bg-red-50 border-red-200">
                                            DELETE
                                        </span>
                                    </template>

                                    <template x-if="detailData.aksi === 'LOGIN'">
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide text-emerald-700 uppercase border rounded-full bg-emerald-50 border-emerald-200">
                                            LOGIN
                                        </span>
                                    </template>

                                    <template x-if="detailData.aksi === 'LOGOUT'">
                                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold tracking-wide text-gray-700 uppercase border rounded-full bg-gray-100 border-gray-200">
                                            LOGOUT
                                        </span>
                                    </template>
                                </div>

                                {{-- Modul --}}
                                <div class="p-4 bg-white border border-gray-200 shadow-sm rounded-xl">
                                    <span class="block mb-2 text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                                        Modul / Tabel
                                    </span>

                                    <p class="text-sm font-bold text-gray-700"
                                    x-text="detailData.modul || '—'">
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400"
                                    x-text="'ID: ' + (detailData.id_target || '—')">
                                    </p>
                                </div>

                                {{-- Waktu --}}
                                <div class="p-4 bg-white border border-gray-200 shadow-sm rounded-xl">
                                    <span class="block mb-2 text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                                        Waktu Kejadian
                                    </span>

                                    <p class="text-xs font-semibold leading-relaxed text-gray-700"
                                    x-text="new Date(detailData.created_at).toLocaleString('id-ID', {
                                            year: 'numeric',
                                            month: 'long',
                                            day: 'numeric',
                                            hour: '2-digit',
                                            minute: '2-digit',
                                            second: '2-digit'
                                    })">
                                    </p>
                                </div>

                                {{-- IP --}}
                                <div class="p-4 bg-white border border-gray-200 shadow-sm rounded-xl">
                                    <span class="block mb-2 text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                                        IP Address
                                    </span>

                                    <p class="font-mono text-xs font-semibold text-gray-700"
                                    x-text="detailData.ip_address || '—'">
                                    </p>
                                </div>
                            </div>

                            {{-- User --}}
                            <div class="flex items-center gap-3 p-4 bg-white border border-gray-200 shadow-sm rounded-xl">

                                <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-xl bg-amber-100">
                                    <svg class="w-5 h-5 text-amber-500"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>

                                <div>
                                    <span class="block mb-1 text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                                        Dilakukan Oleh
                                    </span>

                                    <p class="text-sm font-bold text-gray-800"
                                    x-text="detailData.user ? detailData.user.name : 'Sistem / Guest'">
                                    </p>

                                    <p class="text-xs text-gray-400"
                                    x-text="detailData.user ? detailData.user.email : '—'">
                                    </p>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="p-4 bg-white border border-gray-200 shadow-sm rounded-xl">

                                <span class="block mb-2 text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                                    Deskripsi Lengkap
                                </span>

                                <div class="p-3 text-sm leading-relaxed text-gray-700 border border-gray-100 bg-gray-50 rounded-xl"
                                    x-text="detailData.deskripsi || 'Tidak ada deskripsi.'">
                                </div>
                            </div>

                            {{-- User Agent --}}
                            <div class="p-4 bg-white border border-gray-200 shadow-sm rounded-xl">

                                <span class="block mb-2 text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                                    User Agent (Perangkat)
                                </span>

                                <div class="max-h-32 overflow-y-auto break-all rounded-lg border border-gray-100 bg-gray-50 p-3 text-[11px] font-mono text-gray-500"
                                    x-text="detailData.user_agent || '—'">
                                </div>
                            </div>

                        </div>

                    </template>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end px-6 py-4 bg-white border-t border-gray-100 shrink-0">

                    <button type="button"
                            @click="showModal = false"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-[13px] font-bold text-white transition rounded-xl bg-gradient-to-br from-[#6B1A2B] to-[#9B3045] hover:opacity-90 shadow-lg shadow-[#6B1A2B]/20">
                        <svg class="w-4 h-4" fill="none"viewBox="0 0 24 24"stroke="currentColor"stroke-width="2.5">
                            <path stroke-linecap="round"stroke-linejoin="round"d="M5 13l4 4L19 7"/>
                        </svg>
                        Tutup Detail
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>