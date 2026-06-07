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
@endphp

<div class="max-w-4xl mx-auto px-4 py-6 space-y-4">

    {{-- Hasil Nilai Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="text-center mb-6">
            <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-2">Hasil Kuis</div>
            <h1 class="text-2xl font-bold text-gray-900 mb-1 leading-tight">{{ $kuis->judul }}</h1>
            <div class="text-sm text-gray-600">{{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</div>
        </div>

        {{-- Score Display --}}
        <div class="bg-gradient-to-br from-purple-600 to-purple-500 rounded-2xl p-6 mb-6 text-center text-white">
            <div class="text-sm font-semibold opacity-90 mb-2">Nilai Anda</div>
            <div class="text-6xl font-black leading-none mb-1">{{ number_format($hasilKuis->nilai, 1) }}</div>
            <div class="text-lg opacity-90 mb-4">dari {{ number_format($kuis->nilai_maksimal, 1) }}</div>
            <div class="h-2 bg-white/20 rounded-full overflow-hidden">
                <div class="h-full bg-white rounded-full transition-all duration-700" style="width: {{ $pct }}%"></div>
            </div>
            <div class="text-xl font-bold mt-2">{{ number_format($pct, 1) }}%</div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-3 gap-3 mb-6">
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-center">
                <div class="text-xs text-emerald-700 font-semibold uppercase tracking-wide mb-2">Benar</div>
                <div class="text-3xl font-black text-emerald-600">{{ $hasilKuis->jumlah_benar }}</div>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                <div class="text-xs text-red-700 font-semibold uppercase tracking-wide mb-2">Salah</div>
                <div class="text-3xl font-black text-red-600">{{ $jumlahSalah }}</div>
            </div>
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
                <div class="text-xs text-amber-700 font-semibold uppercase tracking-wide mb-2">Total</div>
                <div class="text-3xl font-black text-amber-600">{{ $soalList->count() }}</div>
            </div>
        </div>

        {{-- Waktu Info --}}
        <div class="flex items-start gap-3 p-4 rounded-xl bg-blue-50 border border-blue-200">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1 text-xs text-gray-700 space-y-1">
                <div><strong class="text-gray-900">Mulai:</strong> {{ $hasilKuis->waktu_mulai ? $hasilKuis->waktu_mulai->format('d M Y, H:i:s') : '-' }}</div>
                <div><strong class="text-gray-900">Selesai:</strong> {{ $hasilKuis->waktu_selesai ? $hasilKuis->waktu_selesai->format('d M Y, H:i:s') : '-' }}</div>
                @if($hasilKuis->waktu_mulai && $hasilKuis->waktu_selesai)
                <div><strong class="text-gray-900">Durasi:</strong> {{ $hasilKuis->waktu_mulai->diffInMinutes($hasilKuis->waktu_selesai) }} menit {{ $hasilKuis->waktu_mulai->diffInSeconds($hasilKuis->waktu_selesai) % 60 }} detik</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Pembahasan Header --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <span class="text-base font-bold text-gray-900">Pembahasan Soal & Kunci Jawaban</span>
        </div>
    </div>

    {{-- Soal Review List --}}
    @foreach($soalList as $soal)
        @php
            $jawabanSiswa = $jawaban[$soal->nomor_soal] ?? null;
            $isBenar = $jawabanSiswa === $soal->kunci_jawaban;
        @endphp
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 border-l-4 {{ $isBenar ? 'border-l-emerald-500' : 'border-l-red-500' }}">
            <div class="flex items-start gap-3 mb-4">
                <span class="flex items-center justify-center w-8 h-8 rounded-lg {{ $isBenar ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }} text-sm font-black flex-shrink-0">{{ $soal->nomor_soal }}</span>
                <div class="flex-1 text-sm font-semibold text-gray-900 leading-relaxed">{!! nl2br(e($soal->pertanyaan)) !!}</div>
                <span class="text-2xl flex-shrink-0">{{ $isBenar ? '✅' : '❌' }}</span>
            </div>

            <div class="space-y-2 mt-4">
                @foreach(['A' => $soal->pilihan_a, 'B' => $soal->pilihan_b, 'C' => $soal->pilihan_c, 'D' => $soal->pilihan_d] as $huruf => $pilihan)
                    @php
                        $isKunci = $huruf === $soal->kunci_jawaban;
                        $isPilihan = $huruf === $jawabanSiswa;
                        
                        if ($isKunci && $isPilihan) {
                            // Jawaban benar
                            $bgColor = 'bg-emerald-50';
                            $borderColor = 'border-emerald-500';
                            $badgeColor = 'bg-emerald-600';
                            $icon = '✓';
                        } elseif ($isKunci) {
                            // Kunci jawaban (tidak dipilih)
                            $bgColor = 'bg-emerald-50';
                            $borderColor = 'border-emerald-300';
                            $badgeColor = 'bg-emerald-600';
                            $icon = '✓';
                        } elseif ($isPilihan) {
                            // Jawaban salah yang dipilih
                            $bgColor = 'bg-red-50';
                            $borderColor = 'border-red-500';
                            $badgeColor = 'bg-red-600';
                            $icon = '✗';
                        } else {
                            // Pilihan biasa
                            $bgColor = 'bg-gray-50';
                            $borderColor = 'border-gray-200';
                            $badgeColor = 'bg-gray-600';
                            $icon = '';
                        }
                    @endphp
                    <div class="flex items-start gap-3 p-3 {{ $bgColor }} border-2 {{ $borderColor }} rounded-lg">
                        <div class="flex-1">
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-md {{ $badgeColor }} text-white text-xs font-bold mr-2">{{ $huruf }}</span>
                            <span class="text-sm text-gray-700 leading-relaxed {{ ($isKunci || $isPilihan) ? 'font-semibold' : '' }}">{{ $pilihan }}</span>
                        </div>
                        @if($icon)
                        <span class="text-lg flex-shrink-0">{{ $icon }}</span>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Info Jawaban --}}
            <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg text-xs">
                @if($isBenar)
                    <span class="text-emerald-700 font-semibold">✓ Jawaban Anda benar!</span>
                @else
                    <span class="text-red-700 font-semibold">✗ Jawaban Anda: {{ $jawabanSiswa ?? 'Tidak dijawab' }}</span>
                    <span class="text-gray-500"> • </span>
                    <span class="text-emerald-700 font-semibold">Kunci: {{ $soal->kunci_jawaban }}</span>
                @endif
            </div>
        </div>
    @endforeach

    {{-- Back Button --}}
    <div class="text-center py-6">
        <a href="{{ route('siswa.kuis.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-gray-200 hover:border-blue-500 rounded-xl text-sm font-semibold text-gray-700 hover:text-blue-600 transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Kuis
        </a>
    </div>

</div>
</x-student-layout>
