<x-student-layout>
<x-slot name="heading">Hasil Kuis</x-slot>
<x-slot name="back">
    <a href="{{ route('siswa.kuis.index') }}" class="flex items-center justify-center w-9 h-9 bg-white/10 hover:bg-white/20 rounded-lg text-white transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
</x-slot>

@php
    $pct = $kuis->nilai_maksimal > 0 ? min(($hasilKuis->nilai / $kuis->nilai_maksimal) * 100, 100) : 0;
    $grade = $pct >= 90 ? 'A' : ($pct >= 80 ? 'B' : ($pct >= 70 ? 'C' : ($pct >= 60 ? 'D' : 'E')));
    $gradeColor = $pct >= 80 ? 'emerald' : ($pct >= 60 ? 'blue' : 'red');
@endphp

<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 pb-10">

    {{-- Hero Score Card --}}
    <div class="max-w-4xl mx-auto px-4 pt-6 pb-4">
        <div class="bg-white rounded-3xl shadow-2xl border-4 border-{{ $gradeColor }}-200 overflow-hidden">
            
            {{-- Celebration Header --}}
            <div class="bg-gradient-to-r from-{{ $gradeColor }}-500 via-{{ $gradeColor }}-600 to-{{ $gradeColor }}-700 px-6 py-8 text-center relative overflow-hidden">
                {{-- Decorative elements --}}
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-40 h-40 bg-white rounded-full -translate-x-20 -translate-y-20"></div>
                    <div class="absolute bottom-0 right-0 w-40 h-40 bg-white rounded-full translate-x-20 translate-y-20"></div>
                </div>
                
                <div class="relative z-10">
                    <div class="text-6xl mb-3">{{ $pct >= 80 ? '🎉' : ($pct >= 60 ? '👍' : '💪') }}</div>
                    <h1 class="text-3xl sm:text-4xl font-black text-white mb-2">
                        {{ $pct >= 80 ? 'Luar Biasa!' : ($pct >= 60 ? 'Bagus!' : 'Tetap Semangat!') }}
                    </h1>
                    <p class="text-white/90 font-semibold">{{ $kuis->judul }}</p>
                </div>
            </div>

            {{-- Score Display --}}
            <div class="p-8">
                {{-- Grade Badge --}}
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-{{ $gradeColor }}-400 to-{{ $gradeColor }}-600 flex items-center justify-center shadow-2xl border-8 border-white">
                            <span class="text-6xl font-black text-white">{{ $grade }}</span>
                        </div>
                        <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 px-4 py-1 bg-{{ $gradeColor }}-600 text-white text-xs font-bold rounded-full shadow-lg whitespace-nowrap">
                            {{ number_format($pct, 1) }}%
                        </div>
                    </div>
                </div>

                {{-- Score Details --}}
                <div class="text-center mb-8">
                    <div class="text-5xl font-black text-gray-900 mb-2">{{ number_format($hasilKuis->nilai, 1) }}</div>
                    <div class="text-lg text-gray-600 font-semibold">dari {{ number_format($kuis->nilai_maksimal, 1) }}</div>
                </div>

                {{-- Stats Grid --}}
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border-2 border-emerald-200 rounded-2xl p-4 text-center">
                        <div class="text-3xl mb-1">✓</div>
                        <div class="text-2xl font-black text-emerald-600">{{ $hasilKuis->jumlah_benar }}</div>
                        <div class="text-xs text-emerald-700 font-bold uppercase tracking-wide mt-1">Benar</div>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-2xl p-4 text-center">
                        <div class="text-3xl mb-1">✗</div>
                        <div class="text-2xl font-black text-red-600">{{ $jumlahSalah }}</div>
                        <div class="text-xs text-red-700 font-bold uppercase tracking-wide mt-1">Salah</div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl p-4 text-center">
                        <div class="text-3xl mb-1">📝</div>
                        <div class="text-2xl font-black text-blue-600">{{ $soalList->count() }}</div>
                        <div class="text-xs text-blue-700 font-bold uppercase tracking-wide mt-1">Total</div>
                    </div>
                </div>

                {{-- Time Info --}}
                @if($hasilKuis->waktu_mulai && $hasilKuis->waktu_selesai)
                <div class="bg-gradient-to-r from-purple-50 to-blue-50 border-2 border-purple-200 rounded-2xl p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 text-xs text-gray-700">
                            <div class="font-semibold"><strong>Mulai:</strong> {{ $hasilKuis->waktu_mulai->format('d M Y, H:i:s') }}</div>
                            <div class="font-semibold mt-1"><strong>Selesai:</strong> {{ $hasilKuis->waktu_selesai->format('d M Y, H:i:s') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-black text-purple-600">{{ $hasilKuis->waktu_mulai->diffInMinutes($hasilKuis->waktu_selesai) }}</div>
                            <div class="text-xs text-purple-700 font-bold">menit</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Answer Review Section --}}
    <div class="max-w-4xl mx-auto px-4 mt-6 space-y-4">
        
        {{-- Section Header --}}
        <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-200 p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-900">Pembahasan Soal</h2>
                    <p class="text-sm text-gray-600">Review jawaban dan kunci jawaban</p>
                </div>
            </div>
        </div>

        {{-- Questions Review --}}
        @foreach($soalList as $soal)
            @php
                $jawabanSiswa = $jawaban[$soal->nomor_soal] ?? null;
                $isBenar = $jawabanSiswa === $soal->kunci_jawaban;
                $borderColor = $isBenar ? 'border-emerald-500' : 'border-red-500';
                $bgGradient = $isBenar ? 'from-emerald-50 to-emerald-100' : 'from-red-50 to-red-100';
            @endphp
            
            <div class="bg-white rounded-2xl shadow-lg border-l-8 {{ $borderColor }} overflow-hidden">
                {{-- Question Header --}}
                <div class="bg-gradient-to-r {{ $bgGradient }} px-5 py-4 border-b-2 {{ $isBenar ? 'border-emerald-200' : 'border-red-200' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $isBenar ? 'bg-emerald-500' : 'bg-red-500' }} flex items-center justify-center shadow-md">
                                <span class="text-xl font-black text-white">{{ $soal->nomor_soal }}</span>
                            </div>
                            <span class="text-sm font-bold {{ $isBenar ? 'text-emerald-800' : 'text-red-800' }}">
                                Soal {{ $soal->nomor_soal }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 {{ $isBenar ? 'bg-emerald-500' : 'bg-red-500' }} rounded-full">
                            <span class="text-white text-2xl">{{ $isBenar ? '✓' : '✗' }}</span>
                            <span class="text-white text-xs font-bold">{{ $isBenar ? 'BENAR' : 'SALAH' }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-5">
                    {{-- Question Text --}}
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 leading-relaxed">{!! nl2br(e($soal->pertanyaan)) !!}</p>
                        
                        {{-- Question Image --}}
                        @if($soal->gambar_soal)
                        <div class="mt-4 rounded-xl overflow-hidden shadow-md border-2 border-gray-200">
                            <img src="{{ Storage::url($soal->gambar_soal) }}" 
                                 alt="Gambar Soal {{ $soal->nomor_soal }}" 
                                 class="w-full h-auto max-h-80 object-contain bg-gray-50">
                        </div>
                        @endif
                    </div>

                    {{-- Answer Options --}}
                    <div class="space-y-2">
                        @foreach(['A' => $soal->pilihan_a, 'B' => $soal->pilihan_b, 'C' => $soal->pilihan_c, 'D' => $soal->pilihan_d] as $huruf => $pilihan)
                            @php
                                $isKunci = $huruf === $soal->kunci_jawaban;
                                $isPilihan = $huruf === $jawabanSiswa;
                                
                                if ($isKunci && $isPilihan) {
                                    // Correct answer
                                    $optionBg = 'bg-gradient-to-r from-emerald-100 to-emerald-50';
                                    $optionBorder = 'border-emerald-500';
                                    $badgeBg = 'bg-emerald-600';
                                    $icon = '✓';
                                    $iconColor = 'text-emerald-600';
                                } elseif ($isKunci) {
                                    // Correct answer (not selected)
                                    $optionBg = 'bg-gradient-to-r from-emerald-50 to-emerald-25';
                                    $optionBorder = 'border-emerald-300';
                                    $badgeBg = 'bg-emerald-500';
                                    $icon = '✓';
                                    $iconColor = 'text-emerald-500';
                                } elseif ($isPilihan) {
                                    // Wrong answer (selected)
                                    $optionBg = 'bg-gradient-to-r from-red-100 to-red-50';
                                    $optionBorder = 'border-red-500';
                                    $badgeBg = 'bg-red-600';
                                    $icon = '✗';
                                    $iconColor = 'text-red-600';
                                } else {
                                    // Not selected
                                    $optionBg = 'bg-gray-50';
                                    $optionBorder = 'border-gray-200';
                                    $badgeBg = 'bg-gray-400';
                                    $icon = '';
                                    $iconColor = '';
                                }
                            @endphp
                            
                            <div class="flex items-center gap-3 p-3 {{ $optionBg }} border-2 {{ $optionBorder }} rounded-xl relative">
                                <div class="flex-shrink-0 w-9 h-9 rounded-lg {{ $badgeBg }} flex items-center justify-center shadow-sm">
                                    <span class="text-base font-black text-white">{{ $huruf }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="text-sm text-gray-800 font-medium {{ ($isKunci || $isPilihan) ? 'font-bold' : '' }}">{{ $pilihan }}</span>
                                </div>
                                @if($icon)
                                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $isKunci ? 'bg-emerald-500' : 'bg-red-500' }} flex items-center justify-center">
                                    <span class="text-xl text-white font-bold">{{ $icon }}</span>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Result Info --}}
                    <div class="mt-4 p-4 {{ $isBenar ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200' }} border-2 rounded-xl">
                        @if($isBenar)
                            <div class="flex items-center gap-2 text-emerald-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-bold">Jawaban Anda BENAR! ✓</span>
                            </div>
                        @else
                            <div class="text-sm space-y-2">
                                <div class="flex items-center gap-2 text-red-700 font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span>Jawaban Anda: <strong>{{ $jawabanSiswa ?? 'Tidak dijawab' }}</strong></span>
                                </div>
                                <div class="flex items-center gap-2 text-emerald-700 font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Jawaban yang Benar: <strong>{{ $soal->kunci_jawaban }}</strong></span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Back Button --}}
        <div class="text-center py-8">
            <a href="{{ route('siswa.kuis.index') }}" 
               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white text-lg font-bold rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-200 hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
              
            </a>
        </div>
    </div>

</div>
</x-student-layout>
