<x-student-layout>
<x-slot name="heading">{{ Str::limit($kuis->judul, 40) }}</x-slot>
<x-slot name="back">
    <a href="{{ route('siswa.kuis.index') }}" class="flex items-center justify-center w-9 h-9 bg-white/10 hover:bg-white/20 rounded-lg text-white transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
</x-slot>

<div class="max-w-3xl mx-auto px-4 py-6 space-y-4">

    {{-- Header Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 mb-4">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            Kuis Tersedia
        </span>
        <h1 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">{{ $kuis->judul }}</h1>
        
        @if($kuis->deskripsi)
        <div class="bg-blue-50 rounded-xl p-4 mb-4 border border-blue-100">
            <div class="text-sm leading-relaxed text-gray-700">{!! nl2br(e($kuis->deskripsi)) !!}</div>
        </div>
        @endif

        <div class="grid grid-cols-2 gap-3">
            <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
                <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Mata Pelajaran</div>
                <div class="text-sm font-bold text-gray-900">{{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
                <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Pengajar</div>
                <div class="text-sm font-bold text-gray-900">{{ $kuis->GuruMapel?->Guru?->nama_lengkap ?? '-' }}</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
                <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Jumlah Soal</div>
                <div class="text-sm font-bold text-gray-900">{{ $jumlahSoal }} Soal</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
                <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Durasi</div>
                <div class="text-sm font-bold text-purple-600">{{ $kuis->durasi }} Menit</div>
            </div>
        </div>

        <div class="flex items-start gap-3 p-4 rounded-xl mt-4 bg-emerald-50 border border-emerald-200">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <div class="text-sm text-emerald-900 font-medium">
                <div><strong>Batas Mulai:</strong> {{ \Carbon\Carbon::parse($kuis->batas_mulai)->format('d M Y, H:i') }}</div>
                <div class="mt-1"><strong>Batas Selesai:</strong> {{ \Carbon\Carbon::parse($kuis->batas_selesai)->format('d M Y, H:i') }}</div>
            </div>
        </div>
    </div>

    {{-- Informasi Penting --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 pt-5 pb-3">
            <div class="flex items-center gap-2 text-amber-600 font-bold text-sm uppercase tracking-wide mb-3">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                Informasi Penting
            </div>
        </div>
        <div class="px-6 pb-6">
            <ul class="space-y-2.5 text-sm text-gray-700">
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Kuis ini hanya dapat dikerjakan <strong class="text-gray-900">satu kali</strong></span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Waktu pengerjaan: <strong class="text-gray-900">{{ $kuis->durasi }} menit</strong></span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Timer akan berjalan otomatis setelah Anda memulai kuis</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Jika waktu habis, jawaban akan otomatis dikumpulkan</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Pastikan koneksi internet Anda stabil</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Nilai maksimal: <strong class="text-gray-900">{{ number_format($kuis->nilai_maksimal, 1) }}</strong></span>
                </li>
            </ul>
        </div>
    </div>

    {{-- Tombol Mulai --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="text-center">
            <div class="text-sm font-semibold text-gray-600 mb-5">
                Pastikan Anda sudah siap sebelum memulai kuis
            </div>
            <form action="{{ route('siswa.kuis.mulai', $kuis->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memulai kuis? Timer akan langsung berjalan.');">
                @csrf
                <button type="submit" class="w-full max-w-sm px-6 py-3.5 bg-gradient-to-r from-rose-800 to-rose-700 hover:from-rose-900 hover:to-rose-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-center gap-2 mx-auto">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Mulai Kuis Sekarang
                </button>
            </form>
            <div class="mt-4">
                <a href="{{ route('siswa.kuis.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold transition inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Kuis
                </a>
            </div>
        </div>
    </div>

</div>
</x-student-layout>
