<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Detail Guru Mapel
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Informasi Lengkap Penugasan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300">/</span>
                <span>Master Data</span>
                <span class="text-slate-300">/</span>
                <a href="{{ route('guru_mapel.index') }}" class="hover:text-[#1B3A6B] transition">Guru Mapel</a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-600 font-semibold">Detail</span>
            </nav>

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Informasi Penugasan Guru Mapel</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Detail lengkap penugasan guru ke mata pelajaran</p>
                    </div>
                    <a href="{{ route('guru_mapel.index') }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>

                {{-- Content --}}
                <div class="p-6 space-y-6">

                    {{-- Detail Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Mapel Card --}}
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-blue-900 uppercase tracking-wide">Mata Pelajaran</h4>
                                    <p class="text-xs text-blue-600">Subject Information</p>
                                </div>
                            </div>
                            <p class="text-lg font-semibold text-blue-800">{{ $guru_mapel->Mapel->nama_mapel }}</p>
                        </div>

                        {{-- Guru Card --}}
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-lg bg-green-500 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-green-900 uppercase tracking-wide">Guru Pengajar</h4>
                                    <p class="text-xs text-green-600">Teacher Information</p>
                                </div>
                            </div>
                            <p class="text-lg font-semibold text-green-800">{{ $guru_mapel->Guru->nama_guru }}</p>
                        </div>

                        {{-- Kelas Card --}}
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-lg bg-purple-500 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-purple-900 uppercase tracking-wide">Kelas</h4>
                                    <p class="text-xs text-purple-600">Class Information</p>
                                </div>
                            </div>
                            <p class="text-lg font-semibold text-purple-800">{{ $guru_mapel->Kelas->nama_kelas }}</p>
                        </div>

                        {{-- Semester Card --}}
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-lg bg-orange-500 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-orange-900 uppercase tracking-wide">Semester</h4>
                                    <p class="text-xs text-orange-600">Semester Information</p>
                                </div>
                            </div>
                            <p class="text-lg font-semibold text-orange-800">{{ $guru_mapel->Semester->nama_semester }}</p>
                        </div>

                    </div>

                    {{-- Timestamps --}}
                    <div class="border-t border-slate-200 pt-6">
                        <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wide mb-4">Informasi Sistem</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-slate-500">Dibuat pada:</span>
                                <span class="font-medium text-slate-700 ml-2">{{ $guru_mapel->created_at->format('d F Y, H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500">Diupdate pada:</span>
                                <span class="font-medium text-slate-700 ml-2">{{ $guru_mapel->updated_at->format('d F Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>