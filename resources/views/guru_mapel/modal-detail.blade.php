<div id="modalDetail" class="hidden fixed inset-0 z-[9998] flex items-center justify-center p-3 sm:p-5">

    {{-- Overlay --}}
    <div onclick="closeDetailModal()"
        class="absolute inset-0 bg-[rgba(45,8,16,0.55)] backdrop-blur-[4px]">
    </div>

    {{-- Dialog --}}
    <div class="relative z-10 w-full max-w-lg">
        <div class="bg-white rounded-[18px] shadow-[0_24px_60px_rgba(107,26,43,0.22),0_4px_16px_rgba(0,0,0,0.08)] overflow-hidden border border-[rgba(107,26,43,0.1)]">

            {{-- Header --}}
            <div class="px-6 py-[18px] flex items-center justify-between relative overflow-hidden"
                style="background: linear-gradient(135deg,#6B1A2B 0%,#4A0F1E 55%,#2D0810 100%);">
                <div class="absolute w-[120px] h-[120px] rounded-full top-[-40px] right-[10px] border border-[rgba(232,147,10,0.2)] pointer-events-none"></div>
                <div class="absolute w-[70px] h-[70px] rounded-full top-[10px] right-[70px] border border-[rgba(232,147,10,0.12)] pointer-events-none"></div>

                <div class="flex items-center gap-3 relative">
                    <div class="w-[38px] h-[38px] rounded-[10px] bg-[rgba(232,147,10,0.2)] flex items-center justify-center flex-shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F5A623" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-[15px] m-0 mb-[2px]">Informasi Penugasan</h3>
                        <p class="text-[rgba(255,255,255,0.5)] text-[11px] m-0">Detail lengkap guru mata pelajaran</p>
                    </div>
                </div>

                <button type="button" onclick="closeDetailModal()"
                    class="w-[30px] h-[30px] rounded-lg bg-[rgba(255,255,255,0.12)] hover:bg-[rgba(255,255,255,0.22)] border-none cursor-pointer flex items-center justify-center relative transition-all duration-200">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Gold accent bar --}}
            <div class="h-[3px]" style="background: linear-gradient(90deg,#E8930A,#F5A623,#E8930A);"></div>

            {{-- Body --}}
            <div class="p-6 flex flex-col gap-4">

                {{-- Mata Pelajaran --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Mata Pelajaran</label>
                    <div class="flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-[10px] min-h-[42px]">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span id="detail-mapel" class="font-semibold text-gray-800 text-sm"></span>
                    </div>
                </div>

                {{-- Guru --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Guru</label>
                    <div class="flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-[10px] min-h-[42px]">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span id="detail-guru" class="font-semibold text-gray-800 text-sm"></span>
                    </div>
                </div>

                {{-- Kelas --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Kelas</label>
                    <div class="flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-[10px] min-h-[42px]">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span id="detail-kelas" class="font-semibold text-gray-800 text-sm"></span>
                    </div>
                </div>

                {{-- Semester --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Semester</label>
                    <div class="flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-[10px] min-h-[42px]">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span id="detail-semester" class="font-semibold text-gray-800 text-sm"></span>
                    </div>
                </div>

                {{-- Timestamps --}}
                <div class="grid grid-cols-2 gap-3 p-3.5 bg-gray-50 rounded-[10px] border border-gray-100">
                    <div>
                        <p class="text-[10.5px] font-bold text-gray-400 uppercase tracking-wider mb-1">Dibuat Pada</p>
                        <p id="detail-created" class="text-sm font-semibold text-gray-700"></p>
                    </div>
                    <div>
                        <p class="text-[10.5px] font-bold text-gray-400 uppercase tracking-wider mb-1">Diupdate Pada</p>
                        <p id="detail-updated" class="text-sm font-semibold text-gray-700"></p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 pb-5 pt-4 flex justify-end border-t border-gray-100">
                <button type="button" onclick="closeDetailModal()"
                    class="inline-flex items-center gap-[6px] px-5 py-[9px] text-[13.5px] font-bold text-white border-none rounded-[10px] cursor-pointer transition-all duration-200 shadow-[0_2px_8px_rgba(107,26,43,0.25)] hover:opacity-90"
                    style="background: linear-gradient(135deg,#6B1A2B,#9B3045);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tutup Detail
                </button>
            </div>

        </div>
    </div>
</div>