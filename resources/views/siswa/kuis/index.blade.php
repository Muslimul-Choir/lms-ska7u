<x-student-layout>
    <x-slot name="heading">Kuis & Ulangan</x-slot>

    <div class="max-w-5xl mx-auto px-4 py-6" x-data="{ tab: 'tersedia' }">

        {{-- Tab bar --}}
        <div class="grid grid-cols-3 bg-gray-200 rounded-xl p-1 gap-1 mb-6">
            <button @click="tab='tersedia'" 
                :class="tab==='tersedia' ? 'bg-white text-rose-900 shadow-sm' : 'bg-transparent text-gray-500 hover:text-gray-700'"
                class="py-2.5 px-3 text-xs font-bold rounded-lg border-none cursor-pointer transition-all uppercase tracking-wide">
                Tersedia ({{ count($tersedia) }})
            </button>
            <button @click="tab='selesai'" 
                :class="tab==='selesai' ? 'bg-white text-rose-900 shadow-sm' : 'bg-transparent text-gray-500 hover:text-gray-700'"
                class="py-2.5 px-3 text-xs font-bold rounded-lg border-none cursor-pointer transition-all uppercase tracking-wide">
                Selesai ({{ count($sudahDikerjakan) }})
            </button>
            <button @click="tab='ditutup'" 
                :class="tab==='ditutup' ? 'bg-white text-rose-900 shadow-sm' : 'bg-transparent text-gray-500 hover:text-gray-700'"
                class="py-2.5 px-3 text-xs font-bold rounded-lg border-none cursor-pointer transition-all uppercase tracking-wide">
                Ditutup ({{ count($ditutup) }})
            </button>
        </div>

        {{-- Tab: Tersedia --}}
        <div x-show="tab==='tersedia'" class="space-y-3">
            @forelse($tersedia as $item)
                @php 
                    $kuis = $item['kuis']; 
                    $isUrgent = \Carbon\Carbon::parse($kuis->batas_selesai)->diffInHours(now()) < 24;
                @endphp
                <a href="{{ route('siswa.kuis.show', $kuis->id) }}" 
                   class="flex items-center gap-4 bg-white border {{ $isUrgent ? 'border-red-200' : 'border-gray-200' }} rounded-xl p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                    <div class="w-12 h-12 rounded-xl {{ $isUrgent ? 'bg-red-50' : 'bg-blue-50' }} flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 {{ $isUrgent ? 'text-red-600' : 'text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-sm text-gray-900 truncate mb-1">{{ $kuis->judul }}</h3>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600">
                            <span class="font-semibold">{{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</span>
                            <span class="flex items-center gap-1 {{ $isUrgent ? 'text-red-600 font-semibold' : 'text-emerald-600' }}">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($kuis->batas_selesai)->format('d M Y, H:i') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                {{ $kuis->durasi }} menit
                            </span>
                        </div>
                    </div>
                    <span class="px-3 py-1.5 text-xs font-bold rounded-full {{ $isUrgent ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }} whitespace-nowrap">
                        {{ $isUrgent ? 'Segera' : 'Tersedia' }}
                    </span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @empty
                <div class="py-16 text-center bg-white rounded-xl border-2 border-dashed border-gray-200">
                    <div class="text-5xl mb-3">📋</div>
                    <div class="text-sm font-semibold text-gray-700 mb-1">Tidak ada kuis yang tersedia saat ini</div>
                    <div class="text-xs text-gray-500">Kuis baru akan muncul di sini</div>
                </div>
            @endforelse
        </div>

        {{-- Tab: Sudah Dikerjakan --}}
        <div x-show="tab==='selesai'" class="space-y-3" x-cloak>
            @forelse($sudahDikerjakan as $item)
                @php 
                    $kuis = $item['kuis']; 
                    $hasil = $item['hasil'];
                    $pct = $hasil && $kuis->nilai_maksimal > 0 ? min(($hasil->nilai / $kuis->nilai_maksimal) * 100, 100) : 0;
                @endphp
                <a href="{{ route('siswa.kuis.hasil', $kuis->id) }}" 
                   class="flex items-center gap-4 bg-white border-l-4 border-emerald-500 border-t border-r border-b border-gray-200 rounded-xl p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-sm text-gray-900 truncate mb-1">{{ $kuis->judul }}</h3>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600">
                            <span class="font-semibold">{{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</span>
                            @if($hasil)
                                <span class="font-bold text-purple-600">
                                    Nilai: {{ number_format($hasil->nilai, 1) }}/{{ number_format($kuis->nilai_maksimal, 1) }}
                                </span>
                                <span class="text-emerald-600 font-semibold">
                                    ✓ {{ $hasil->jumlah_benar }} benar
                                </span>
                            @endif
                        </div>
                    </div>
                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap">
                        Selesai
                    </span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @empty
                <div class="py-16 text-center bg-white rounded-xl border-2 border-dashed border-gray-200">
                    <div class="text-5xl mb-3">📊</div>
                    <div class="text-sm font-semibold text-gray-700">Belum ada kuis yang selesai dikerjakan</div>
                </div>
            @endforelse
        </div>

        {{-- Tab: Ditutup --}}
        <div x-show="tab==='ditutup'" class="space-y-3" x-cloak>
            @forelse($ditutup as $item)
                @php $kuis = $item['kuis']; @endphp
                <div class="flex items-center gap-4 bg-white border border-red-200 rounded-xl p-4 opacity-70">
                    <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-sm text-gray-900 truncate mb-1">{{ $kuis->judul }}</h3>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600">
                            <span class="font-semibold">{{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</span>
                            <span class="text-red-600 font-semibold">
                                Ditutup {{ \Carbon\Carbon::parse($kuis->batas_selesai)->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-red-50 text-red-700 border border-red-200 whitespace-nowrap">
                        Ditutup
                    </span>
                </div>
            @empty
                <div class="py-16 text-center bg-white rounded-xl border-2 border-dashed border-gray-200">
                    <div class="text-5xl mb-3">🔒</div>
                    <div class="text-sm font-semibold text-gray-700">Tidak ada kuis yang ditutup</div>
                </div>
            @endforelse
        </div>

    </div>
</x-student-layout>
