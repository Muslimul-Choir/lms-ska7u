<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Tugas Kelas
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Manajemen Konten & Penugasan Siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 bg-slate-50 min-h-screen" x-data="{
        activePertemuan: null,
        
        // Create Modals
        modalMateri: false,
        modalTugas: false,
        tipeMateri: 'dokumen',

        // Edit Modals
        modalEditMateri: false,
        editMateriData: {},
        tipeMateriEdit: 'dokumen',

        modalEditTugas: false,
        editTugasData: {},

        togglePertemuan(id) {
            this.activePertemuan = this.activePertemuan === id ? null : id;
        },

        openEditMateri(m) {
            this.editMateriData = m;
            this.tipeMateriEdit = m.tipe_materi;
            document.getElementById('formEditMateri').action = '/materi/' + m.id;
            this.modalEditMateri = true;
        },

        openEditTugas(t) {
            this.editTugasData = t;
            // Format batas_waktu for datetime-local input
            if(t.batas_waktu) {
                let date = new Date(t.batas_waktu);
                date.setMinutes(date.getMinutes() - date.getTimezoneOffset());
                this.editTugasData.formatted_batas_waktu = date.toISOString().slice(0, 16);
            }
            document.getElementById('formEditTugas').action = '/tugas/' + t.id;
            this.modalEditTugas = true;
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Breadcrumb & Action Button --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide">
                    <a href="{{ route('dashboard') }}" class="text-[#1B3A6B] hover:underline">Dashboard</a>
                    <span class="text-slate-300">/</span>
                    <span class="text-slate-600 font-semibold">Tugas Kelas</span>
                </nav>

                <div class="flex items-center gap-3 relative" x-data="{ openMenu: false }">
                    <button @click="openMenu = !openMenu" @click.away="openMenu = false"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#C8992A] hover:bg-[#b5861f] text-white text-sm font-bold rounded-full transition shadow-lg shadow-amber-900/20">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat
                    </button>
                    
                    {{-- Dropdown Buat --}}
                    <div x-show="openMenu" style="display: none;"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl ring-1 ring-slate-200 z-40 overflow-hidden">
                        <button @click="modalTugas = true; openMenu = false" class="w-full text-left px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 font-medium flex items-center gap-3 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-[#1B3A6B]">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            Tugas Baru
                        </button>
                        <button @click="modalMateri = true; openMenu = false" class="w-full text-left px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 font-medium flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center text-[#C8992A]">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            Materi Baru
                        </button>
                    </div>
                </div>
            </div>

            {{-- Alert Messages --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            @endif
            @if ($errors->any())
                <div class="px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Search & Filter Bar --}}
            <form method="GET" action="{{ route('materi.index') }}" class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul materi, tugas, atau nomor pertemuan..." class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                </div>
                
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-3">
                    <select name="filter_tipe" class="border border-slate-200 rounded-lg text-sm py-2 px-3 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                        <option value="semua" {{ request('filter_tipe') == 'semua' ? 'selected' : '' }}>Semua Tipe</option>
                        <option value="materi" {{ request('filter_tipe') == 'materi' ? 'selected' : '' }}>Hanya Materi</option>
                        <option value="tugas" {{ request('filter_tipe') == 'tugas' ? 'selected' : '' }}>Hanya Tugas</option>
                    </select>

                    <select name="filter_status" class="border border-slate-200 rounded-lg text-sm py-2 px-3 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                        <option value="semua" {{ request('filter_status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="published" {{ request('filter_status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('filter_status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    
                    <button type="submit" class="bg-[#1B3A6B] hover:bg-[#0F2145] text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">Cari</button>
                    @if(request('q') || request('filter_tipe') && request('filter_tipe') != 'semua' || request('filter_status') && request('filter_status') != 'semua')
                        <a href="{{ route('materi.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-3 py-2 rounded-lg text-sm font-semibold transition flex items-center justify-center" title="Reset Filter">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </a>
                    @endif
                </div>
            </form>

            {{-- Accordion List by Pertemuan --}}
            <div class="space-y-4 sm:space-y-6">
                @forelse($pertemuans as $pertemuan)
                    @php
                        $materiList = $materis->where('id_pertemuan', $pertemuan->id)->map(function($m) { $m->is_tugas = false; return $m; });
                        $tugasList = $tugas->where('id_pertemuan', $pertemuan->id)->map(function($t) { $t->is_tugas = true; return $t; });
                        $items = collect($materiList)->concat($tugasList)->sortByDesc('created_at');
                        $hasContent = $items->count() > 0;
                    @endphp

                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden" 
                         x-data="{ count: {{ $items->count() }} }">
                         
                        {{-- Header Accordion --}}
                        <div @click="togglePertemuan({{ $pertemuan->id }})" 
                             class="flex items-center justify-between p-4 sm:p-5 bg-gradient-to-r hover:from-slate-50 hover:to-white cursor-pointer transition select-none border-b border-slate-100 group">
                            
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50/50 border border-blue-100 text-[#1B3A6B] flex flex-col items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                    <span class="text-[10px] font-bold uppercase tracking-widest leading-none mb-0.5">Pert</span>
                                    <span class="text-base sm:text-lg font-black leading-none">{{ $pertemuan->nomor_pertemuan }}</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-[#0F2145] text-sm sm:text-base group-hover:text-[#1B3A6B] transition">
                                        Pertemuan Ke-{{ $pertemuan->nomor_pertemuan }}
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-1">
                                        @php
                                            $jadwal = $pertemuan->jadwalBelajar;
                                            $namaMapel = $jadwal?->guruMapel?->mapel?->nama_mapel ?? $jadwal?->mapel?->nama_mapel ?? null;
                                            $namaGuru  = $jadwal?->guruMapel?->guru?->nama_lengkap ?? null;
                                        @endphp
                                        @if($namaMapel)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-600">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                {{ $namaMapel }}
                                            </span>
                                        @endif
                                        @if($namaGuru)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-medium text-slate-500">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                {{ $namaGuru }}
                                            </span>
                                        @endif
                                        @if(!$namaMapel && !$namaGuru)
                                            <span class="text-[10px] font-medium text-slate-400">Tidak terhubung ke jadwal khusus</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500" x-text="count + ' Item Konten'"></span>
                                <div class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 group-hover:bg-[#1B3A6B]/10 group-hover:text-[#1B3A6B] transition">
                                    <svg class="w-5 h-5 transform transition-transform duration-300" 
                                         :class="{'rotate-180': activePertemuan === {{ $pertemuan->id }} }" 
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Body Accordion --}}
                        <div x-show="activePertemuan === {{ $pertemuan->id }}" 
                             x-transition.opacity 
                             class="bg-white">
                             
                            @if(!$hasContent)
                                <div class="px-5 py-8 text-center text-sm text-slate-400">
                                    Belum ada materi atau tugas di pertemuan ini.
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-sm border-collapse">
                                        <thead>
                                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                                <th class="px-5 py-3 w-10 text-center">#</th>
                                                <th class="px-5 py-3 w-1/3 min-w-[200px]">Judul Konten</th>
                                                <th class="px-5 py-3">Mata Pelajaran</th>
                                                <th class="px-5 py-3 w-1/4">Tipe & Status</th>
                                                <th class="px-5 py-3 w-1/4">Info Tambahan</th>
                                                <th class="px-5 py-3 text-center w-32">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 text-slate-600">
                                            @foreach($items as $index => $item)
                                                <tr class="hover:bg-slate-50/50 transition group">
                                                    <td class="px-5 py-4 text-[11px] font-mono text-slate-400 text-center align-top">
                                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                    </td>
                                                    <td class="px-5 py-4 align-top">
                                                        <div class="flex items-start gap-3">
                                                            <div class="w-8 h-8 rounded-lg {{ $item->is_tugas ? 'bg-amber-100 text-amber-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center shrink-0 mt-0.5">
                                                                @if($item->is_tugas)
                                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                                                @else
                                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                                @endif
                                                            </div>
                                                            <div class="min-w-0 flex-1 whitespace-normal">
                                                                <h5 class="text-[13px] font-bold text-slate-800 leading-snug">{{ $item->judul }}</h5>
                                                                <p class="text-[11px] text-slate-500 mt-1 line-clamp-2" title="{{ $item->deskripsi }}">{{ $item->deskripsi }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    {{-- Mata Pelajaran Column --}}
                                                    <td class="px-5 py-4 align-top">
                                                        @php
                                                            $rowMapel = $item->mapel?->nama_mapel
                                                                ?? $item->pertemuan?->jadwalBelajar?->guruMapel?->mapel?->nama_mapel
                                                                ?? $item->pertemuan?->jadwalBelajar?->mapel?->nama_mapel
                                                                ?? null;
                                                            $rowGuru = $item->is_tugas
                                                                ? ($item->guru?->nama_lengkap ?? $item->guruMapel?->guru?->nama_lengkap ?? null)
                                                                : ($item->guruMapel?->guru?->nama_lengkap ?? $item->pertemuan?->jadwalBelajar?->guruMapel?->guru?->nama_lengkap ?? null);
                                                        @endphp
                                                        @if($rowMapel)
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                                <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                                {{ $rowMapel }}
                                                            </span>
                                                            @if($rowGuru)
                                                                <div class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                                                                    <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                                    {{ $rowGuru }}
                                                                </div>
                                                            @endif
                                                        @else
                                                            <span class="text-[10px] text-slate-300 italic">—</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-5 py-4 align-top">
                                                        @if($item->is_tugas)
                                                            <div class="flex items-center gap-1.5 mb-1.5">
                                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider border bg-amber-50 text-amber-700 border-amber-200">Tugas</span>
                                                                <span class="text-[9px] font-bold uppercase text-slate-400">{{ $item->tipe_tugas ?? 'File' }}</span>
                                                            </div>
                                                            <div>
                                                                @if($item->status == 'published')
                                                                    <span class="inline-block px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded text-[9px] font-bold uppercase">Published</span>
                                                                @else
                                                                    <span class="inline-block px-1.5 py-0.5 bg-slate-100 text-slate-600 rounded text-[9px] font-bold uppercase">Draft</span>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="flex items-center gap-1.5 mb-1.5">
                                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider border bg-blue-50 text-blue-700 border-blue-200">Materi</span>
                                                                <span class="text-[9px] font-bold uppercase text-slate-400">{{ $item->tipe_materi }}</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="px-5 py-4 align-top">
                                                        @if($item->is_tugas)
                                                            <div class="text-[11px] font-semibold text-slate-600">
                                                                Tenggat: <br>
                                                                <span class="{{ \Carbon\Carbon::parse($item->batas_waktu)->isPast() ? 'text-red-500' : 'text-emerald-600' }}">
                                                                    {{ \Carbon\Carbon::parse($item->batas_waktu)->format('d M Y H:i') }}
                                                                </span>
                                                            </div>
                                                        @else
                                                            <div class="text-[11px] text-slate-500 whitespace-normal">
                                                                @if($item->tipe_materi == 'link')
                                                                    <a href="{{ $item->file_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-semibold underline transition">
                                                                        Tautan URL Terlampir
                                                                    </a>
                                                                @else
                                                                    <span class="text-slate-600">File {{ ucfirst($item->tipe_materi) }} Terlampir</span>
                                                                @endif
                                                            </div>
                                                            <div class="mt-1 text-[9px] text-slate-400 uppercase tracking-widest font-semibold">Diposting {{ $item->created_at->format('d M Y') }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="px-5 py-4 align-top text-center">
                                                        <div class="flex items-center justify-center gap-1.5">
                                                            @if($item->is_tugas)
                                                                <a href="{{ $item->file_url ? (str_starts_with($item->file_url, 'http') ? $item->file_url : asset('storage/' . $item->file_url)) : '#' }}" 
                                                                   target="_blank"
                                                                   class="w-7 h-7 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-200 transition"
                                                                   title="Lihat Lampiran Tugas">
                                                                   <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                                </a>
                                                                <button @click='openEditTugas(@json($item))' 
                                                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 border border-amber-200 transition"
                                                                        title="Edit Tugas">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                                </button>
                                                                <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tugas ini?')">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 transition" title="Hapus Tugas">
                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                @if(isset($pertemuan->id_jadwal))
                                                                <a href="{{ route('ruang-belajar.show', [$pertemuan->id_jadwal, $item->id]) }}" 
                                                                   target="_blank"
                                                                   class="w-7 h-7 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-200 transition"
                                                                   title="Pratinjau Materi">
                                                                   <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                                </a>
                                                                @endif
                                                                @if($item->file_url && ($item->tipe_materi === 'dokumen' || $item->tipe_materi === 'video'))
                                                                <a href="{{ str_starts_with($item->file_url, 'http') ? $item->file_url : asset('storage/' . $item->file_url) }}" 
                                                                   target="_blank"
                                                                   download
                                                                   class="w-7 h-7 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200 transition"
                                                                   title="Download File">
                                                                   <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                                </a>
                                                                @endif
                                                                <button @click='openEditMateri(@json($item))' 
                                                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 border border-amber-200 transition"
                                                                        title="Edit Materi">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                                </button>
                                                                <form action="{{ route('materi.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus materi ini?')">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 transition" title="Hapus Materi">
                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 text-center">
                        <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <h3 class="text-slate-600 font-bold mb-1">Belum Ada Data</h3>
                        <p class="text-sm text-slate-400">Belum ada jadwal / pertemuan yang tersedia.</p>
                    </div>
                @endforelse
                
                {{-- Pagination Links --}}
                @if($pertemuans->hasPages())
                    <div class="mt-8">
                        {{ $pertemuans->links() }}
                    </div>
                @endif
            </div>

        {{-- ============================== --}}
        {{-- MODAL TAMBAH MATERI --}}
        {{-- ============================== --}}
        <div x-show="modalMateri" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="modalMateri" x-transition.opacity class="absolute inset-0 bg-[#0A193C]/60 backdrop-blur-sm" @click="modalMateri = false"></div>
            <div x-show="modalMateri" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden ring-1 ring-slate-200 z-10">
                <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col">
                    @csrf
                    <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-amber-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-[15px] tracking-wide">Materi Baru</h3>
                                <p class="text-blue-200 text-[11px] uppercase tracking-wider">Tambahkan bahan ajar siswa</p>
                            </div>
                        </div>
                        <button type="button" @click="modalMateri = false" class="text-white/70 hover:text-white transition bg-white/5 hover:bg-white/20 p-1.5 rounded-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="px-6 py-6 space-y-5 max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Pertemuan / Topik <span class="text-red-500">*</span></label>
                                <select name="id_pertemuan" id="materi_id_pertemuan"
                                        onchange="updateMapelInfo(this, 'materi_mapel_info')"
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                                    <option value="">-- Pilih Pertemuan --</option>
                                    @foreach($allPertemuan as $p)
                                        @php
                                            $pMapel = $p->jadwalBelajar?->guruMapel?->mapel?->nama_mapel ?? $p->jadwalBelajar?->mapel?->nama_mapel ?? null;
                                            $pGuru  = $p->jadwalBelajar?->guruMapel?->guru?->nama_lengkap ?? null;
                                            $pInfo  = collect([$pMapel, $pGuru])->filter()->join(' · ');
                                        @endphp
                                        <option value="{{ $p->id }}"
                                            data-mapel="{{ $pMapel }}"
                                            data-guru="{{ $pGuru }}">
                                            Pertemuan {{ $p->nomor_pertemuan }}{{ $pInfo ? ' — '.$pInfo : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- Mapel info box --}}
                                <div id="materi_mapel_info" class="hidden mt-2 flex items-center gap-2 px-3 py-2 bg-blue-50 rounded-lg border border-blue-100">
                                    <svg class="w-3.5 h-3.5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    <span class="text-[11px] font-semibold text-blue-700" id="materi_mapel_text"></span>
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Judul Materi <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" required placeholder="Contoh: Pengantar Aljabar Boolean" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Jenis Materi <span class="text-red-500">*</span></label>
                                <select name="tipe_materi" x-model="tipeMateri" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                                    <option value="dokumen">Dokumen (PDF, Word)</option>
                                    <option value="video">Video (MP4)</option>
                                    <option value="link">Tautan Luar / Link YouTube</option>
                                    <option value="lainnya">Hanya Artikel / Teks</option>
                                </select>
                            </div>
                        </div>
                        
                        <div x-show="tipeMateri === 'dokumen' || tipeMateri === 'video'">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Unggah File <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:border-[#1B3A6B] transition bg-slate-50 group relative">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-[#1B3A6B] transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <label class="relative cursor-pointer bg-white rounded-md font-bold text-[#1B3A6B] hover:text-[#0F2145] focus-within:outline-none px-2 py-0.5">
                                            <span>Pilih File</span>
                                            <input type="file" name="file_url" class="sr-only" :accept="tipeMateri === 'video' ? 'video/mp4,video/x-m4v,video/*' : '.pdf,.doc,.docx'">
                                        </label>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-2" x-text="tipeMateri === 'video' ? 'MP4 maksimal 50MB' : 'PDF, DOCX maksimal 50MB'"></p>
                                </div>
                            </div>
                        </div>

                        <div x-show="tipeMateri === 'link'">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Tautan (URL) <span class="text-red-500">*</span></label>
                            <input type="url" name="file_url" :required="tipeMateri === 'link'" :disabled="tipeMateri !== 'link'" placeholder="https://youtube.com/..." class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Deskripsi / Artikel</label>
                            <textarea name="deskripsi" rows="4" placeholder="Tulis instruksi atau isi materi di sini..." class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50"></textarea>
                        </div>
                    </div>
                    
                    <div class="border-t border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="modalMateri = false" class="px-5 py-2.5 text-sm font-semibold bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition shadow-sm">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold bg-[#1B3A6B] hover:bg-[#0F2145] text-white rounded-xl transition shadow-lg shadow-blue-900/20">Posting Materi</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============================== --}}
        {{-- MODAL EDIT MATERI --}}
        {{-- ============================== --}}
        <div x-show="modalEditMateri" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="modalEditMateri" x-transition.opacity class="absolute inset-0 bg-[#0A193C]/60 backdrop-blur-sm" @click="modalEditMateri = false"></div>
            <div x-show="modalEditMateri" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden ring-1 ring-slate-200 z-10">
                <form id="formEditMateri" method="POST" enctype="multipart/form-data" class="flex flex-col">
                    @csrf @method('PUT')
                    <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-amber-500 to-amber-600">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-[15px] tracking-wide">Edit Materi</h3>
                                <p class="text-amber-100 text-[11px] uppercase tracking-wider">Perbarui data bahan ajar</p>
                            </div>
                        </div>
                        <button type="button" @click="modalEditMateri = false" class="text-white/70 hover:text-white transition bg-white/5 hover:bg-white/20 p-1.5 rounded-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="px-6 py-6 space-y-5 max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Pertemuan / Topik <span class="text-red-500">*</span></label>
                                <select name="id_pertemuan" x-model="editMateriData.id_pertemuan"
                                        onchange="updateMapelInfo(this, 'edit_materi_mapel_info')"
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm bg-slate-50">
                                    <option value="">-- Pilih Pertemuan --</option>
                                    @foreach($allPertemuan as $p)
                                        @php
                                            $pMapel = $p->jadwalBelajar?->guruMapel?->mapel?->nama_mapel ?? $p->jadwalBelajar?->mapel?->nama_mapel ?? null;
                                            $pGuru  = $p->jadwalBelajar?->guruMapel?->guru?->nama_lengkap ?? null;
                                            $pInfo  = collect([$pMapel, $pGuru])->filter()->join(' · ');
                                        @endphp
                                        <option value="{{ $p->id }}"
                                            data-mapel="{{ $pMapel }}"
                                            data-guru="{{ $pGuru }}">
                                            Pertemuan {{ $p->nomor_pertemuan }}{{ $pInfo ? ' — '.$pInfo : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="edit_materi_mapel_info" class="hidden mt-2 flex items-center gap-2 px-3 py-2 bg-amber-50 rounded-lg border border-amber-100">
                                    <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    <span class="text-[11px] font-semibold text-amber-700" id="edit_materi_mapel_text"></span>
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Judul Materi <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" x-model="editMateriData.judul" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm bg-slate-50">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Jenis Materi <span class="text-red-500">*</span></label>
                                <select name="tipe_materi" x-model="tipeMateriEdit" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm bg-slate-50">
                                    <option value="dokumen">Dokumen (PDF, Word)</option>
                                    <option value="video">Video (MP4)</option>
                                    <option value="link">Tautan Luar / Link YouTube</option>
                                    <option value="lainnya">Hanya Artikel / Teks</option>
                                </select>
                            </div>
                        </div>
                        
                        <div x-show="tipeMateriEdit === 'dokumen' || tipeMateriEdit === 'video'">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Timpa File Lama <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                            <input type="file" name="file_url" class="mt-1 block w-full text-slate-600 text-sm file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200 cursor-pointer" :accept="tipeMateriEdit === 'video' ? 'video/mp4,video/x-m4v,video/*' : '.pdf,.doc,.docx'">
                        </div>

                        <div x-show="tipeMateriEdit === 'link'">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Tautan (URL) <span class="text-red-500">*</span></label>
                            <input type="url" name="file_url" x-model="editMateriData.file_url" :required="tipeMateriEdit === 'link'" :disabled="tipeMateriEdit !== 'link'" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm bg-slate-50">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Deskripsi / Artikel</label>
                            <textarea name="deskripsi" x-model="editMateriData.deskripsi" rows="4" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm bg-slate-50"></textarea>
                        </div>
                    </div>
                    
                    <div class="border-t border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="modalEditMateri = false" class="px-5 py-2.5 text-sm font-semibold bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition shadow-sm">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold bg-amber-500 hover:bg-amber-600 text-white rounded-xl transition shadow-lg shadow-amber-900/20">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============================== --}}
        {{-- MODAL BUAT TUGAS --}}
        {{-- ============================== --}}
        <div x-show="modalTugas" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4">
            <div x-show="modalTugas" x-transition.opacity class="absolute inset-0 bg-[#0A193C]/60 backdrop-blur-sm" @click="modalTugas = false"></div>
            <div x-show="modalTugas" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="relative bg-white rounded-2xl shadow-2xl w-full max-h-[95vh] sm:max-h-[90vh] md:max-h-[85vh] sm:max-w-lg md:max-w-2xl lg:max-w-3xl overflow-hidden ring-1 ring-slate-200 z-10 flex flex-col">
                <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col h-full overflow-hidden">
                    @csrf
                    <div class="flex items-center justify-between px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B] shrink-0">
                        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white/10 flex items-center justify-center text-blue-300 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-white font-bold text-sm sm:text-[15px] tracking-wide">Tugas Baru</h3>
                                <p class="text-blue-200 text-[10px] sm:text-[11px] uppercase tracking-wider hidden sm:block">Buat penugasan untuk siswa</p>
                            </div>
                        </div>
                        <button type="button" @click="modalTugas = false" class="text-white/70 hover:text-white transition bg-white/5 hover:bg-white/20 p-1 sm:p-1.5 rounded-lg flex-shrink-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="px-3 sm:px-6 py-4 sm:py-6 space-y-4 sm:space-y-6 overflow-y-auto flex-1">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 sm:mb-2">Pertemuan / Topik <span class="text-red-500">*</span></label>
                                <select name="id_pertemuan" class="w-full rounded-lg sm:rounded-xl border border-slate-200 px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                                    @foreach($allPertemuan as $p)
                                        <option value="{{ $p->id }}">Pertemuan {{ $p->nomor_pertemuan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 sm:mb-2">Guru Pengampu <span class="text-red-500">*</span></label>
                                <select name="id_guru" class="w-full rounded-lg sm:rounded-xl border border-slate-200 px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->id }}">{{ $g->user->name ?? 'Guru '.$g->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 sm:mb-2">Judul Tugas <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" required placeholder="Contoh: Analisis Jurnal" class="w-full rounded-lg sm:rounded-xl border border-slate-200 px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 sm:mb-2">Petunjuk Pengerjaan</label>
                            <textarea name="deskripsi" rows="3" placeholder="Tulis detail dan instruksi tugas..." class="w-full rounded-lg sm:rounded-xl border border-slate-200 px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-3 lg:gap-4 bg-blue-50/50 p-2.5 sm:p-3 sm:p-4 rounded-lg sm:rounded-xl border border-blue-100">
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold text-blue-800 uppercase tracking-widest mb-1 sm:mb-2">Tenggat Waktu <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="batas_waktu" required class="w-full rounded border border-blue-200 px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-slate-700 focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold text-blue-800 uppercase tracking-widest mb-1 sm:mb-2">Poin Maksimal</label>
                                <input type="number" name="nilai_maksimal" value="100" class="w-full rounded border border-blue-200 px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-slate-700 focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold text-blue-800 uppercase tracking-widest mb-1 sm:mb-2">Jenis Tugas</label>
                                <select name="tipe_tugas" class="w-full rounded border border-blue-200 px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-slate-700 focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm">
                                    <option value="individu">Individu</option>
                                    <option value="kelompok">Kelompok</option>
                                </select>
                            </div>
                        </div>

                        <!-- Advanced File Type Selection -->
                        <div x-data="{ tipeFile: 'tanpa' }" class="space-y-2.5 sm:space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 sm:mb-2">Jenis Lampiran</label>
                                <select name="tipe_file" x-model="tipeFile" class="w-full rounded-lg sm:rounded-xl border border-slate-200 px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                                    <option value="tanpa">Tanpa File</option>
                                    <option value="dokumen">Dokumen (PDF, Word)</option>
                                    <option value="video">Video (MP4)</option>
                                    <option value="link">Tautan / Link</option>
                                </select>
                            </div>

                            <!-- File Upload for Dokumen/Video -->
                            <div x-show="tipeFile === 'dokumen' || tipeFile === 'video'">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 sm:mb-2">Unggah File <span class="text-red-500">*</span></label>
                                <div class="flex justify-center px-3 sm:px-6 py-3 sm:py-4 border-2 border-slate-300 border-dashed rounded-lg sm:rounded-xl hover:border-[#1B3A6B] transition bg-slate-50 group relative">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-8 sm:h-12 w-8 sm:w-12 text-slate-400 group-hover:text-[#1B3A6B] transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                        <div class="flex text-xs sm:text-sm text-slate-600 justify-center">
                                            <label class="relative cursor-pointer bg-white rounded-md font-bold text-[#1B3A6B] hover:text-[#0F2145] focus-within:outline-none px-2 py-0.5">
                                                <span>Pilih</span>
                                                <input type="file" name="file_url" class="sr-only" :required="tipeFile === 'dokumen' || tipeFile === 'video'" :accept="tipeFile === 'video' ? 'video/mp4,video/x-m4v,video/*' : '.pdf,.doc,.docx'">
                                            </label>
                                        </div>
                                        <p class="text-[9px] sm:text-[10px] text-slate-400 mt-1" x-text="tipeFile === 'video' ? 'MP4 max 50MB' : 'PDF/DOCX max 50MB'"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Link Input -->
                            <div x-show="tipeFile === 'link'">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 sm:mb-2">Tautan (URL) <span class="text-red-500">*</span></label>
                                <input type="url" name="file_url" :required="tipeFile === 'link'" :disabled="tipeFile !== 'link'" placeholder="https://..." class="w-full rounded-lg sm:rounded-xl border border-slate-200 px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition shadow-sm bg-slate-50">
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                            <div class="flex flex-col gap-2 sm:gap-3 flex-1 justify-center">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="allow_late" value="1" class="w-4 h-4 sm:w-5 sm:h-5 rounded border-slate-300 text-[#1B3A6B] focus:ring-[#1B3A6B] transition">
                                    <span class="ml-2 sm:ml-3 text-xs sm:text-sm text-slate-700 font-medium group-hover:text-[#1B3A6B] transition">Terima Terlambat</span>
                                </label>
                                
                                <div class="flex items-center gap-2 bg-slate-100 p-1.5 sm:p-2 rounded border border-slate-200">
                                    <span class="text-[9px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-widest">Status:</span>
                                    <select name="status" class="flex-1 rounded border-none bg-transparent py-0.5 sm:py-1 text-xs sm:text-sm text-slate-700 font-semibold focus:ring-0 cursor-pointer">
                                        <option value="published">Posting</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-slate-100 bg-slate-50/50 px-3 sm:px-6 py-3 sm:py-4 flex items-center justify-end gap-2 sm:gap-3 shrink-0">
                        <button type="button" @click="modalTugas = false" class="px-3 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-semibold bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-lg sm:rounded-xl transition shadow-sm">Batal</button>
                        <button type="submit" class="px-4 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-bold bg-[#C8992A] hover:bg-[#b5861f] text-white rounded-lg sm:rounded-xl transition shadow-lg shadow-amber-900/20">Posting</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============================== --}}
        {{-- MODAL EDIT TUGAS --}}
        {{-- ============================== --}}
        <div x-show="modalEditTugas" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="modalEditTugas" x-transition.opacity class="absolute inset-0 bg-[#0A193C]/60 backdrop-blur-sm" @click="modalEditTugas = false"></div>
            <div x-show="modalEditTugas" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden ring-1 ring-slate-200 z-10">
                <form id="formEditTugas" method="POST" enctype="multipart/form-data" class="flex flex-col h-full max-h-[90vh]">
                    @csrf @method('PUT')
                    <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-amber-500 to-amber-600 shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-[15px] tracking-wide">Edit Tugas</h3>
                                <p class="text-amber-100 text-[11px] uppercase tracking-wider">Perbarui penugasan siswa</p>
                            </div>
                        </div>
                        <button type="button" @click="modalEditTugas = false" class="text-white/70 hover:text-white transition bg-white/5 hover:bg-white/20 p-1.5 rounded-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="px-6 py-6 space-y-6 overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Pertemuan / Topik <span class="text-red-500">*</span></label>
                                <select name="id_pertemuan" x-model="editTugasData.id_pertemuan"
                                        onchange="updateMapelInfo(this, 'edit_tugas_mapel_info')"
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm bg-slate-50">
                                    <option value="">-- Pilih Pertemuan --</option>
                                    @foreach($allPertemuan as $p)
                                        @php
                                            $pMapel = $p->jadwalBelajar?->guruMapel?->mapel?->nama_mapel ?? $p->jadwalBelajar?->mapel?->nama_mapel ?? null;
                                            $pGuru  = $p->jadwalBelajar?->guruMapel?->guru?->nama_lengkap ?? null;
                                            $pInfo  = collect([$pMapel, $pGuru])->filter()->join(' · ');
                                        @endphp
                                        <option value="{{ $p->id }}"
                                            data-mapel="{{ $pMapel }}"
                                            data-guru="{{ $pGuru }}">
                                            Pertemuan {{ $p->nomor_pertemuan }}{{ $pInfo ? ' — '.$pInfo : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="edit_tugas_mapel_info" class="hidden mt-2 flex items-center gap-2 px-3 py-2 bg-amber-50 rounded-lg border border-amber-100">
                                    <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    <span class="text-[11px] font-semibold text-amber-700" id="edit_tugas_mapel_text"></span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Guru Pengampu <span class="text-red-500">*</span></label>
                                <select name="id_guru" x-model="editTugasData.id_guru" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm bg-slate-50">
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->id }}">{{ $g->user->name ?? 'Guru '.$g->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Judul Tugas <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" x-model="editTugasData.judul" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm bg-slate-50">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Petunjuk Pengerjaan</label>
                            <textarea name="deskripsi" x-model="editTugasData.deskripsi" rows="4" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm bg-slate-50"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 bg-amber-50/50 p-4 rounded-xl border border-amber-100">
                            <div>
                                <label class="block text-[10px] font-bold text-amber-800 uppercase tracking-widest mb-2">Tenggat Waktu <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="batas_waktu" x-model="editTugasData.formatted_batas_waktu" required class="w-full rounded-lg border border-amber-200 px-3 py-2 text-sm text-slate-700 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-amber-800 uppercase tracking-widest mb-2">Poin Maksimal</label>
                                <input type="number" name="nilai_maksimal" x-model="editTugasData.nilai_maksimal" class="w-full rounded-lg border border-amber-200 px-3 py-2 text-sm text-slate-700 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-amber-800 uppercase tracking-widest mb-2">Jenis Tugas</label>
                                <select name="tipe_tugas" x-model="editTugasData.tipe_tugas" class="w-full rounded-lg border border-amber-200 px-3 py-2 text-sm text-slate-700 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                                    <option value="individu">Tugas Individu</option>
                                    <option value="kelompok">Tugas Kelompok</option>
                                </select>
                            </div>
                        </div>

                        <!-- Advanced File Type Selection for Edit -->
                        <div x-data="{ tipeFileEdit: editTugasData.tipe_file || 'tanpa' }" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Jenis Lampiran</label>
                                <select name="tipe_file" x-model="tipeFileEdit" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm bg-slate-50">
                                    <option value="tanpa">Tanpa File Lampiran</option>
                                    <option value="dokumen">Dokumen (PDF, Word)</option>
                                    <option value="video">Video (MP4)</option>
                                    <option value="link">Tautan Luar / Link</option>
                                </select>
                            </div>

                            <!-- File Upload for Dokumen/Video -->
                            <div x-show="tipeFileEdit === 'dokumen' || tipeFileEdit === 'video'">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Timpa File Lama <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                                <input type="file" name="file_url" class="mt-1 block w-full text-slate-600 text-sm file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200 cursor-pointer" :accept="tipeFileEdit === 'video' ? 'video/mp4,video/x-m4v,video/*' : '.pdf,.doc,.docx'">
                            </div>

                            <!-- Link Input -->
                            <div x-show="tipeFileEdit === 'link'">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Tautan (URL) <span class="text-red-500">*</span></label>
                                <input type="url" name="file_url" x-model="editTugasData.file_url" :required="tipeFileEdit === 'link'" :disabled="tipeFileEdit !== 'link'" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm bg-slate-50">
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-6">
                            <div class="flex flex-col gap-3 justify-center">
                                <label class="flex items-center cursor-pointer group">
                                    <!-- Use a hidden input for unchecked state with x-model -->
                                    <input type="hidden" name="allow_late" value="0">
                                    <input type="checkbox" name="allow_late" value="1" x-model="editTugasData.allow_late" class="w-5 h-5 rounded border-slate-300 text-amber-500 focus:ring-amber-500 transition">
                                    <span class="ml-3 text-sm text-slate-700 font-medium group-hover:text-amber-600 transition">Izinkan Pengumpulan Terlambat</span>
                                </label>
                                
                                <div class="flex items-center gap-3 bg-slate-100 p-2 rounded-lg border border-slate-200">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Status:</span>
                                    <select name="status" x-model="editTugasData.status" class="flex-1 rounded border-none bg-transparent py-1 text-sm text-slate-700 font-semibold focus:ring-0 cursor-pointer">
                                        <option value="published">Posting Sekarang</option>
                                        <option value="draft">Simpan Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="modalEditTugas = false" class="px-5 py-2.5 text-sm font-semibold bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition shadow-sm">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold bg-amber-500 hover:bg-amber-600 text-white rounded-xl transition shadow-lg shadow-amber-900/20">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

<script>
function updateMapelInfo(selectEl, infoBoxId) {
    const selected = selectEl.options[selectEl.selectedIndex];
    const mapel = selected ? selected.getAttribute('data-mapel') : null;
    const guru  = selected ? selected.getAttribute('data-guru')  : null;
    const box   = document.getElementById(infoBoxId);
    const textId = infoBoxId.replace('_info', '_text');
    const textEl = document.getElementById(textId);

    if (box && textEl) {
        if (mapel || guru) {
            const parts = [mapel ? '📚 ' + mapel : null, guru ? '👤 ' + guru : null].filter(Boolean);
            textEl.textContent = parts.join('  ·  ');
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
        }
    }
}
</script>

</x-app-layout>