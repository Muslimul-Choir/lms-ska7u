<x-student-layout>
<x-slot name="heading">{{ Str::limit($kuis->judul, 40) }}</x-slot>

<div class="max-w-4xl mx-auto px-4 py-6" x-data="kuisTimer(@json($sisaDetik), @json(route('siswa.kuis.submit', $kuis)))" x-init="mulai()">

    {{-- Timer Sticky Header --}}
    <div class="sticky top-0 z-10 bg-white rounded-xl shadow-md border-2 border-blue-200 p-4 mb-5 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Sisa Waktu</div>
                <div class="text-2xl font-black" :class="sisa < 60 ? 'text-red-600' : 'text-blue-600'" x-text="formatWaktu(sisa)">--:--</div>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Total Soal</div>
            <div class="text-lg font-bold text-gray-900">{{ $soalList->count() }} Soal</div>
        </div>
    </div>

    <form id="form-kuis" action="{{ route('siswa.kuis.submit', $kuis->id) }}" method="POST">
        @csrf

        {{-- Soal List --}}
        <div class="space-y-4 mb-6">
            @foreach($soalList as $soal)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 border-l-4 border-l-blue-500">
                <div class="flex items-start gap-3 mb-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-700 text-sm font-black flex-shrink-0">{{ $soal->nomor_soal }}</span>
                    <div class="flex-1 text-sm font-semibold text-gray-900 leading-relaxed">{!! nl2br(e($soal->pertanyaan)) !!}</div>
                </div>

                <div class="space-y-2 mt-4">
                    @foreach(['A' => $soal->pilihan_a, 'B' => $soal->pilihan_b, 'C' => $soal->pilihan_c, 'D' => $soal->pilihan_d] as $huruf => $pilihan)
                    <label class="flex items-start gap-3 p-3 bg-gray-50 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all duration-150 group">
                        <input type="radio" name="jawaban[{{ $soal->nomor_soal }}]" value="{{ $huruf }}" class="mt-1 w-4 h-4 cursor-pointer accent-blue-600" onchange="this.closest('label').classList.add('!border-blue-500', '!bg-blue-50'); Array.from(this.closest('.space-y-2').querySelectorAll('label')).forEach(l=>{if(l!==this.closest('label')){l.classList.remove('!border-blue-500', '!bg-blue-50')}})">
                        <div class="flex-1">
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-blue-600 text-white text-xs font-bold mr-2">{{ $huruf }}</span>
                            <span class="text-sm text-gray-700 leading-relaxed">{{ $pilihan }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        {{-- Submit Button --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
            <div class="text-sm text-gray-600 mb-4 font-medium">
                Pastikan semua jawaban sudah terisi sebelum mengumpulkan
            </div>
            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengumpulkan kuis? Jawaban tidak dapat diubah setelah dikumpulkan.');" class="w-full max-w-md px-6 py-3.5 bg-gradient-to-r from-rose-800 to-rose-700 hover:from-rose-900 hover:to-rose-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-center gap-2 mx-auto">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Kumpulkan Kuis
            </button>
        </div>

    </form>

</div>

<script>
function kuisTimer(sisaDetik, submitUrl) {
    return {
        sisa: sisaDetik,
        interval: null,
        mulai() {
            this.interval = setInterval(() => {
                if (this.sisa <= 0) {
                    clearInterval(this.interval);
                    // Auto-submit when time is up
                    document.getElementById('form-kuis').submit();
                } else {
                    this.sisa--;
                }
            }, 1000);
        },
        formatWaktu(detik) {
            const m = Math.floor(detik / 60).toString().padStart(2, '0');
            const s = (detik % 60).toString().padStart(2, '0');
            return `${m}:${s}`;
        }
    }
}
</script>

</x-student-layout>
