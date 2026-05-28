<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Detail Jawaban Siswa
                </h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">
                    Konten & Evaluasi
                </p>
            </div>
        </div>
    </x-slot>

    <x-slot name="breadcrumb">
        <a href="{{ route('dashboard') }}" class="text-amber-600 hover:text-amber-700 transition">Dashboard</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('kuis.index') }}" class="text-amber-600 hover:text-amber-700 transition">Kuis</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('kuis.show', $kuis) }}" class="text-amber-600 hover:text-amber-700 transition">Detail</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 font-semibold">Jawaban Siswa</span>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            
            <!-- Student Result Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $kuis->judul }}</h3>
                        <div class="text-sm text-gray-500 mt-1">{{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</div>
                    </div>
                    <a href="{{ route('kuis.show', $kuis) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-lg inline-flex items-center gap-2 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>

                <!-- Student Info & Score -->
                <div class="grid grid-cols-2 gap-5 mb-5">
                    <div class="bg-blue-50 border border-blue-100 p-5 rounded-xl">
                        <div class="text-xs text-gray-500 mb-2 uppercase tracking-wider font-semibold">Siswa</div>
                        <div class="font-bold text-gray-900 text-base">{{ $hasil->Siswa?->nama_lengkap ?? '-' }}</div>
                        <div class="text-xs text-gray-500 mt-1">NIS: {{ $hasil->Siswa?->nis ?? '-' }}</div>
                    </div>
                    <div class="bg-purple-50 border border-purple-100 p-5 rounded-xl">
                        <div class="text-xs text-gray-500 mb-2 uppercase tracking-wider font-semibold">Nilai</div>
                        <div class="text-3xl font-bold text-purple-700">{{ number_format($hasil->nilai, 1) }}</div>
                        <div class="text-xs text-gray-500 mt-1">dari {{ number_format($kuis->nilai_maksimal, 1) }}</div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-3 gap-4 mb-5">
                    <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-xl text-center">
                        <div class="text-2xl font-bold text-emerald-700">{{ $hasil->jumlah_benar }}</div>
                        <div class="text-xs text-gray-600 mt-1 uppercase tracking-wider font-semibold">Jawaban Benar</div>
                    </div>
                    <div class="bg-red-50 border border-red-100 p-4 rounded-xl text-center">
                        <div class="text-2xl font-bold text-red-700">{{ $jumlahSalah }}</div>
                        <div class="text-xs text-gray-600 mt-1 uppercase tracking-wider font-semibold">Jawaban Salah</div>
                    </div>
                    <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl text-center">
                        <div class="text-2xl font-bold text-blue-700">{{ $soalList->count() }}</div>
                        <div class="text-xs text-gray-600 mt-1 uppercase tracking-wider font-semibold">Total Soal</div>
                    </div>
                </div>

                <!-- Time Info -->
                <div class="bg-gray-50 border border-gray-100 p-4 rounded-xl text-sm">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Waktu Mulai:</span>
                            <span class="font-semibold text-gray-700 ml-2">{{ $hasil->waktu_mulai ? \Carbon\Carbon::parse($hasil->waktu_mulai)->format('d M Y, H:i:s') : '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Waktu Selesai:</span>
                            <span class="font-semibold text-gray-700 ml-2">{{ $hasil->waktu_selesai ? \Carbon\Carbon::parse($hasil->waktu_selesai)->format('d M Y, H:i:s') : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Answer Review -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                <h3 class="text-base font-bold text-gray-800 mb-5 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    Review Jawaban per Soal
                </h3>
                
                <div class="space-y-5">
                    @foreach($soalList as $soal)
                        @php
                            $jawabanSiswa = $jawaban[$soal->nomor_soal] ?? null;
                            $isBenar = $jawabanSiswa === $soal->kunci_jawaban;
                        @endphp
                        
                        <div class="border-l-4 {{ $isBenar ? 'border-emerald-500 bg-emerald-50' : 'border-red-500 bg-red-50' }} p-5 rounded-r-xl">
                            <!-- Question Header -->
                            <div class="flex items-start gap-3 mb-4">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center font-bold {{ $isBenar ? 'bg-emerald-100 text-emerald-700 border-2 border-emerald-200' : 'bg-red-100 text-red-700 border-2 border-red-200' }}">
                                    {{ $soal->nomor_soal }}
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900 mb-2 text-sm">{{ $soal->pertanyaan }}</div>
                                    <div class="flex items-center gap-2">
                                        @if($isBenar)
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Benar
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-200 inline-flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                                Salah
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Answer Options -->
                            <div class="space-y-2.5 ml-13">
                                @foreach(['A' => $soal->pilihan_a, 'B' => $soal->pilihan_b, 'C' => $soal->pilihan_c, 'D' => $soal->pilihan_d] as $huruf => $pilihan)
                                    @php
                                        $isKunci = $huruf === $soal->kunci_jawaban;
                                        $isPilihan = $huruf === $jawabanSiswa;
                                        
                                        if ($isKunci && $isPilihan) {
                                            // Correct answer
                                            $bgColor = 'bg-emerald-50';
                                            $borderColor = 'border-emerald-500';
                                            $textColor = 'text-emerald-900';
                                            $icon = '<svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
                                        } elseif ($isKunci) {
                                            // Correct answer (not selected)
                                            $bgColor = 'bg-emerald-50/50';
                                            $borderColor = 'border-emerald-300';
                                            $textColor = 'text-emerald-800';
                                            $icon = '<svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
                                        } elseif ($isPilihan) {
                                            // Wrong answer selected
                                            $bgColor = 'bg-red-50';
                                            $borderColor = 'border-red-500';
                                            $textColor = 'text-red-900';
                                            $icon = '<svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>';
                                        } else {
                                            // Not selected
                                            $bgColor = 'bg-white';
                                            $borderColor = 'border-gray-200';
                                            $textColor = 'text-gray-700';
                                            $icon = '';
                                        }
                                    @endphp
                                    
                                    <div class="flex items-start gap-3 p-3 {{ $bgColor }} border-2 {{ $borderColor }} rounded-xl transition-all">
                                        <span class="flex-shrink-0 w-6 h-6 rounded-full bg-gray-700 text-white text-xs font-bold flex items-center justify-center">{{ $huruf }}</span>
                                        <span class="flex-1 {{ $textColor }} text-sm {{ ($isKunci || $isPilihan) ? 'font-semibold' : '' }}">{{ $pilihan }}</span>
                                        @if($icon)
                                            <span class="flex-shrink-0">{!! $icon !!}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- Answer Summary -->
                            <div class="mt-4 ml-13 p-3 bg-white border border-gray-200 rounded-xl text-sm">
                                @if($isBenar)
                                    <span class="text-emerald-700 font-semibold inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Siswa menjawab dengan benar: {{ $jawabanSiswa }}
                                    </span>
                                @else
                                    <div class="space-y-1.5">
                                        <div class="inline-flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-red-700 font-semibold">Jawaban Siswa:</span> 
                                            <span class="text-red-600 font-bold">{{ $jawabanSiswa ?? 'Tidak dijawab' }}</span>
                                        </div>
                                        <div class="inline-flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-emerald-700 font-semibold">Kunci Jawaban:</span> 
                                            <span class="text-emerald-600 font-bold">{{ $soal->kunci_jawaban }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
