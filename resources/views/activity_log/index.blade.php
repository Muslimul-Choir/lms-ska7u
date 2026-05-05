<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Activity Log
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Catatan Aktivitas Sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 bg-slate-50 min-h-screen" x-data="{
        showModal: false,
        detailData: null,
        openDetail(log) {
            this.detailData = log;
            this.showModal = true;
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide">
                <a href="{{ route('dashboard') }}" class="text-[#1B3A6B] hover:underline">Dashboard</a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-600 font-semibold">Activity Log</span>
            </nav>

            {{-- Search, Filter, and Export Bar --}}
            <form method="GET" action="{{ route('activity-log.index') }}" class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center">
                <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto flex-1">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari aktivitas, modul, atau email..." class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                    </div>
                    
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <select name="filter_aksi" class="flex-1 sm:flex-none border border-slate-200 rounded-lg text-sm py-2 px-3 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                            <option value="semua" {{ request('filter_aksi') == 'semua' ? 'selected' : '' }}>Semua Aksi</option>
                            <option value="CREATE" {{ request('filter_aksi') == 'CREATE' ? 'selected' : '' }}>CREATE</option>
                            <option value="UPDATE" {{ request('filter_aksi') == 'UPDATE' ? 'selected' : '' }}>UPDATE</option>
                            <option value="DELETE" {{ request('filter_aksi') == 'DELETE' ? 'selected' : '' }}>DELETE</option>
                            <option value="LOGIN" {{ request('filter_aksi') == 'LOGIN' ? 'selected' : '' }}>LOGIN</option>
                            <option value="LOGOUT" {{ request('filter_aksi') == 'LOGOUT' ? 'selected' : '' }}>LOGOUT</option>
                        </select>
                        <button type="submit" class="bg-[#1B3A6B] hover:bg-[#0F2145] text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">Cari</button>
                        
                        @if(request('q') || (request('filter_aksi') && request('filter_aksi') != 'semua'))
                            <a href="{{ route('activity-log.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-3 py-2 rounded-lg text-sm font-semibold transition" title="Reset Filter">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Export Button --}}
                <button type="submit" name="export" value="1" class="w-full lg:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-bold transition shadow-sm shadow-emerald-900/20">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Ekspor CSV
                </button>
            </form>

            {{-- Table Container --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead>
                            <tr class="bg-[#0F2145] text-white">
                                <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider border-b border-[#1B3A6B] w-12 text-center">#</th>
                                <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider border-b border-[#1B3A6B]">Waktu</th>
                                <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider border-b border-[#1B3A6B]">Pengguna</th>
                                <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider border-b border-[#1B3A6B]">Aksi / Modul</th>
                                <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider border-b border-[#1B3A6B] w-1/3">Deskripsi Singkat</th>
                                <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider border-b border-[#1B3A6B] text-center w-24">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-[11px] font-medium text-slate-600">
                            @forelse($logs as $log)
                                <tr class="hover:bg-slate-50/70 transition-colors group">
                                    <td class="px-5 py-3.5 text-center text-slate-400 font-mono text-[10px]">
                                        {{ $logs->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-[#0F2145] font-semibold">
                                        {{ $log->created_at->format('d M Y') }}
                                        <span class="block text-[10px] text-slate-400 font-normal">{{ $log->created_at->format('H:i:s') }}</span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="font-bold text-slate-700">{{ $log->user->name ?? 'System/Guest' }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $log->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        @php
                                            $badgeColors = [
                                                'LOGIN' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                'LOGOUT' => 'bg-slate-100 text-slate-600 border-slate-200',
                                                'CREATE' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'UPDATE' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                'DELETE' => 'bg-red-100 text-red-800 border-red-200',
                                                'VIEW' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
                                            ];
                                            $color = $badgeColors[strtoupper($log->aksi)] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border {{ $color }}">
                                            {{ $log->aksi }}
                                        </span>
                                        <div class="mt-1 text-[10px] text-slate-500 font-bold tracking-wider">{{ $log->modul ?? '-' }}</div>
                                    </td>
                                    <td class="px-5 py-3.5 text-slate-600">
                                        <div class="line-clamp-2" title="{{ $log->deskripsi }}">
                                            {{ $log->deskripsi }}
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <button type="button" @click='openDetail(@json($log))' class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition bg-slate-50 border border-slate-200 group-hover:border-blue-200" title="Lihat Detail Lengkap">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            <p class="text-[12px] font-bold uppercase tracking-widest text-slate-500">Data Tidak Ditemukan</p>
                                            <p class="text-[11px] mt-1">Coba gunakan kata kunci atau filter lain.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination Links --}}
                @if($logs->hasPages())
                    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- ============================== --}}
        {{-- MODAL VIEW DETAIL LOG --}}
        {{-- ============================== --}}
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="showModal" x-transition.opacity class="absolute inset-0 bg-[#0A193C]/60 backdrop-blur-sm" @click="showModal = false"></div>
            
            <div x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="relative bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden ring-1 ring-slate-200 z-10 flex flex-col max-h-[90vh]">
                
                {{-- Modal Header --}}
                <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B] shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-blue-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-[15px] tracking-wide">Detail Aktivitas</h3>
                            <p class="text-blue-200 text-[10px] font-mono tracking-wider" x-text="detailData ? 'LOG ID: ' + detailData.id : ''"></p>
                        </div>
                    </div>
                    <button type="button" @click="showModal = false" class="text-white/70 hover:text-white transition bg-white/5 hover:bg-white/20 p-1.5 rounded-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 overflow-y-auto space-y-5 bg-slate-50/50">
                    <template x-if="detailData">
                        <div class="space-y-4">
                            
                            {{-- Info Utama Grid --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-sm">
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Aksi</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider border bg-blue-50 text-blue-700 border-blue-200" x-text="detailData.aksi"></span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-sm">
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Modul / Tabel</span>
                                    <div class="text-sm font-bold text-slate-700">
                                        <span x-text="detailData.modul"></span>
                                        <span class="text-slate-400 text-xs font-normal" x-text="' (ID: ' + detailData.id_target + ')'"></span>
                                    </div>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-sm">
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu Kejadian</span>
                                    <div class="text-[13px] font-semibold text-slate-700" x-text="new Date(detailData.created_at).toLocaleString('id-ID', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' })"></div>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-sm">
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">IP Address</span>
                                    <div class="text-[13px] font-mono text-slate-700 font-semibold" x-text="detailData.ip_address || '-'"></div>
                                </div>
                            </div>

                            {{-- Pelaku --}}
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Dilakukan Oleh</span>
                                    <div class="text-[14px] font-bold text-[#0F2145]" x-text="detailData.user ? detailData.user.name : 'Sistem / Guest'"></div>
                                    <div class="text-[11px] text-slate-500" x-text="detailData.user ? detailData.user.email : 'No Email'"></div>
                                </div>
                            </div>

                            {{-- Deskripsi Penuh --}}
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Deskripsi Lengkap</span>
                                <div class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-100 leading-relaxed" x-text="detailData.deskripsi"></div>
                            </div>

                            {{-- User Agent --}}
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">User Agent (Perangkat)</span>
                                <div class="text-[11px] font-mono text-slate-500 break-all bg-slate-50 p-2 rounded border border-slate-100" x-text="detailData.user_agent || '-'"></div>
                            </div>

                        </div>
                    </template>
                </div>
                
                {{-- Modal Footer --}}
                <div class="border-t border-slate-100 bg-white px-6 py-4 flex items-center justify-end shrink-0">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 text-sm font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition shadow-sm border border-slate-200">Tutup Detail</button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>