<x-student-layout>
<x-slot name="heading">{{ Str::limit($kuis->judul, 30) }}</x-slot>

{{-- Modern Quiz Interface - Red Theme --}}
<div class="min-h-screen bg-gray-50">

    {{-- Timer Bar - Sticky at top --}}
    <div id="timer-bar" class="sticky top-14 z-40 bg-white shadow-lg border-b-4 border-rose-800 transition-all duration-300">
        <div class="max-w-5xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between gap-4">
                {{-- Timer Display --}}
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-800 to-rose-900 flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Sisa Waktu</div>
                        <div id="timer-display" class="text-2xl font-black text-rose-800">--:--</div>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="flex-1 max-w-md hidden sm:block">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-bold text-gray-600">Progress</span>
                        <span id="progress-text" class="text-xs font-bold text-gray-900">0 / {{ $soalList->count() }}</span>
                    </div>
                    <div class="h-3 bg-gray-200 rounded-full overflow-hidden shadow-inner">
                        <div id="progress-bar" class="h-full bg-gradient-to-r from-rose-700 to-rose-800 transition-all duration-300 rounded-full" style="width: 0%"></div>
                    </div>
                </div>

                {{-- Question Counter Mobile --}}
                <div class="sm:hidden">
                    <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Soal</div>
                    <div id="mobile-progress" class="text-lg font-black text-gray-900">1 / {{ $soalList->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <form id="form-kuis" action="{{ route('siswa.kuis.submit', $kuis->id) }}" method="POST" class="pb-32">
        @csrf

        {{-- Questions Container --}}
        <div class="max-w-4xl mx-auto px-4 py-6 space-y-6 pb-40 lg:pb-8">
            @foreach($soalList as $index => $soal)
            <div class="quiz-question-card bg-white rounded-2xl shadow-lg border-2 border-gray-200 overflow-hidden" 
                 data-question="{{ $index + 1 }}">
                
                {{-- Question Header --}}
                <div class="bg-gradient-to-r from-rose-800 to-rose-900 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                <span class="text-xl font-black text-white">{{ $soal->nomor_soal }}</span>
                            </div>
                            <span class="text-white font-bold text-sm">Soal {{ $soal->nomor_soal }} dari {{ $soalList->count() }}</span>
                        </div>
                        <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                            </svg>
                            <span class="text-xs font-bold text-white">Pilih 1 Jawaban</span>
                        </div>
                    </div>
                </div>

                {{-- Question Content --}}
                <div class="p-6 sm:p-8">
                    {{-- Question Text --}}
                    <div class="mb-6">
                        <p class="text-lg sm:text-xl font-bold text-gray-900 leading-relaxed mb-4">{!! nl2br(e($soal->pertanyaan)) !!}</p>
                        
                        {{-- Question Image --}}
                        @if($soal->gambar_soal)
                        <div class="mt-4 rounded-xl overflow-hidden shadow-md border-2 border-gray-200">
                            <img src="{{ Storage::url($soal->gambar_soal) }}" 
                                 alt="Gambar Soal {{ $soal->nomor_soal }}" 
                                 class="w-full h-auto max-h-96 object-contain bg-gray-50"
                                 loading="lazy">
                        </div>
                        @endif
                    </div>

                    {{-- Answer Options - Grid Style --}}
                    <div class="space-y-3">
                        @foreach(['A' => $soal->pilihan_a, 'B' => $soal->pilihan_b, 'C' => $soal->pilihan_c, 'D' => $soal->pilihan_d] as $huruf => $pilihan)
                        <label class="answer-option group relative cursor-pointer block">
                            <input type="radio" 
                                   name="jawaban[{{ $soal->nomor_soal }}]" 
                                   value="{{ $huruf }}" 
                                   class="peer sr-only"
                                   onchange="handleAnswerSelect(this, {{ $index + 1 }}, {{ $soalList->count() }})">
                            
                            <div class="relative h-full min-h-[60px] p-4 rounded-xl border-3 border-gray-300 bg-white transition-all duration-200 
                                        peer-checked:border-rose-800 peer-checked:bg-rose-50 peer-checked:shadow-lg
                                        hover:border-rose-600 hover:shadow-md
                                        flex items-center gap-4">
                                
                                {{-- Option Letter Badge --}}
                                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gray-200 text-gray-700
                                            peer-checked:bg-gradient-to-br peer-checked:from-rose-800 peer-checked:to-rose-900 peer-checked:text-white
                                            flex items-center justify-center font-black text-lg shadow-sm transition-all duration-200">
                                    {{ $huruf }}
                                </div>

                                {{-- Option Text --}}
                                <div class="flex-1 min-w-0">
                                    <span class="text-sm sm:text-base font-medium text-gray-800 leading-snug">{{ $pilihan }}</span>
                                </div>

                                {{-- Checkmark Icon --}}
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-rose-800 flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-all duration-200">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Submit Button - Always visible at the end --}}
            <div class="bg-gradient-to-r from-rose-50 to-orange-50 border-2 border-rose-200 rounded-2xl p-6 sm:p-8 text-center shadow-lg">
                <div class="mb-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-rose-800 to-rose-900 rounded-2xl shadow-lg mb-3">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-gray-900 mb-2">Siap Mengumpulkan?</h3>
                    <p class="text-sm text-gray-600 max-w-md mx-auto">
                        Pastikan semua jawaban sudah terisi. Setelah dikumpulkan, Anda tidak bisa mengubah jawaban lagi.
                    </p>
                </div>
                
                <button type="submit" 
                        onclick="return confirmSubmitKuis(event)"
                        class="w-full sm:w-auto px-8 sm:px-10 py-4 sm:py-5 bg-gradient-to-r from-rose-800 to-rose-900 hover:from-rose-900 hover:to-rose-950 text-white text-lg sm:text-xl font-black rounded-xl shadow-xl hover:shadow-2xl transition-all duration-200 inline-flex items-center justify-center gap-3">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Kumpulkan Kuis Sekarang
                </button>
            </div>
        </div>
    </form>

</div>

{{-- JavaScript for Quiz --}}
<script>
(function() {
    // Timer logic
    let sisaDetik = Math.floor({{ $sisaDetik }});
    let interval = null;
    const totalQuestions = {{ $soalList->count() }};
    let answeredQuestions = new Set();
    
    console.log('🎯 Quiz initialized:', sisaDetik, 'seconds,', totalQuestions, 'questions');
    
    function formatWaktu(detik) {
        detik = Math.floor(detik);
        const h = Math.floor(detik / 3600);
        const m = Math.floor((detik % 3600) / 60);
        const s = detik % 60;
        
        if (h > 0) {
            return h + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }
        return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
    }
    
    function updateTimerUI() {
        const display = document.getElementById('timer-display');
        const bar = document.getElementById('timer-bar');
        
        display.textContent = formatWaktu(sisaDetik);
        
        // Remove all color classes
        bar.classList.remove('border-red-500', 'border-yellow-500', 'border-rose-800');
        display.classList.remove('text-red-600', 'text-yellow-600', 'text-rose-800');
        
        // Update colors based on time
        if (sisaDetik < 60) {
            bar.classList.add('border-red-500', 'animate-pulse');
            display.classList.add('text-red-600');
        } else if (sisaDetik < 300) {
            bar.classList.add('border-yellow-500');
            display.classList.add('text-yellow-600');
        } else {
            bar.classList.add('border-rose-800');
            display.classList.add('text-rose-800');
        }
    }
    
    function updateProgress() {
        const answered = answeredQuestions.size;
        const percentage = (answered / totalQuestions) * 100;
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        const mobileProgress = document.getElementById('mobile-progress');
        
        if (progressBar) progressBar.style.width = percentage + '%';
        if (progressText) progressText.textContent = answered + ' / ' + totalQuestions;
        if (mobileProgress) mobileProgress.textContent = answered + ' / ' + totalQuestions;
    }
    
    function startTimer() {
        updateTimerUI();
        
        interval = setInterval(() => {
            sisaDetik = Math.max(0, sisaDetik - 1);
            
            if (sisaDetik <= 0) {
                clearInterval(interval);
                Swal.fire({
                    title: '⏰ Waktu Habis!',
                    text: 'Kuis akan dikumpulkan otomatis.',
                    icon: 'warning',
                    confirmButtonColor: '#6B1A2B',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    document.getElementById('form-kuis').submit();
                });
                return;
            }
            
            updateTimerUI();
            
            // Warnings
            if (sisaDetik === 300) {
                Swal.fire({
                    title: '⏰ Perhatian!',
                    text: 'Sisa waktu 5 menit lagi!',
                    icon: 'warning',
                    confirmButtonColor: '#6B1A2B',
                    timer: 3000,
                    timerProgressBar: true
                });
            }
            
            if (sisaDetik === 60) {
                Swal.fire({
                    title: '🚨 PERHATIAN!',
                    text: 'Sisa waktu 1 menit!',
                    icon: 'error',
                    confirmButtonColor: '#6B1A2B',
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        }, 1000);
    }
    
    // Make function global
    window.handleAnswerSelect = function(input, questionNumber, totalQuestions) {
        const questionNum = parseInt(input.name.match(/\d+/)[0]);
        answeredQuestions.add(questionNum);
        updateProgress();
        
        console.log('Answer selected for question', questionNum, '- Total answered:', answeredQuestions.size);
    };
    
    // Confirm submit function
    window.confirmSubmitKuis = function(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        const answered = answeredQuestions.size;
        const unanswered = totalQuestions - answered;
        
        let html = `<div style="text-align:left;font-size:14px;">
            <p style="margin-bottom:12px;">Pastikan semua jawaban sudah terisi.</p>
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:12px;margin-bottom:8px;">
                <strong style="color:#166534;">✓ Sudah dijawab: ${answered} soal</strong>
            </div>`;
        
        if (unanswered > 0) {
            html += `<div style="background:#fef3c7;border:1px solid #fde047;border-radius:8px;padding:12px;margin-bottom:8px;">
                <strong style="color:#92400e;">⚠️ Belum dijawab: ${unanswered} soal</strong>
            </div>`;
        }
        
        html += `<div style="background:#fee2e2;border:1px solid #fecaca;border-radius:8px;padding:12px;">
                <strong style="color:#991b1b;">⚠️ Jawaban tidak dapat diubah setelah dikumpulkan!</strong>
            </div>
        </div>`;
        
        Swal.fire({
            title: '📤 Kumpulkan Kuis?',
            html: html,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6B1A2B',
            cancelButtonColor: '#64748b',
            confirmButtonText: '✓ Ya, Kumpulkan',
            cancelButtonText: 'Periksa Lagi',
            reverseButtons: true,
            width: '500px'
        }).then((result) => {
            if (result.isConfirmed) {
                clearInterval(interval);
                form.submit();
            }
        });
        
        return false;
    };
    
    // Initialize answered questions from existing selections
    document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
        const questionNum = parseInt(input.name.match(/\d+/)[0]);
        answeredQuestions.add(questionNum);
    });
    updateProgress();
    
    // Start timer
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startTimer);
    } else {
        startTimer();
    }
    
    // Prevent accidental close
    window.addEventListener('beforeunload', function (e) {
        if (sisaDetik > 0) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
})();
</script>

</x-student-layout>
