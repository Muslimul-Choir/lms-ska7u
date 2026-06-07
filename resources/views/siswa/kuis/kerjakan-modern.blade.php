<x-student-layout>
<x-slot name="heading">{{ Str::limit($kuis->judul, 30) }}</x-slot>

{{-- Modern Quiz Interface - Quizizz Style --}}
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50">

    {{-- Timer Bar - Sticky at top --}}
    <div id="timer-bar" class="sticky top-14 z-40 bg-white shadow-lg border-b-4 border-blue-500 transition-all duration-300">
        <div class="max-w-5xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between gap-4">
                {{-- Timer Display --}}
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Sisa Waktu</div>
                        <div id="timer-display" class="text-2xl font-black text-blue-600">--:--</div>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="flex-1 max-w-md hidden sm:block">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-bold text-gray-600">Progress</span>
                        <span id="progress-text" class="text-xs font-bold text-gray-900">0 / {{ $soalList->count() }}</span>
                    </div>
                    <div class="h-3 bg-gray-200 rounded-full overflow-hidden shadow-inner">
                        <div id="progress-bar" class="h-full bg-gradient-to-r from-emerald-500 to-emerald-600 transition-all duration-300 rounded-full" style="width: 0%"></div>
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
        <div class="max-w-4xl mx-auto px-4 py-6 space-y-6">
            @foreach($soalList as $index => $soal)
            <div class="quiz-question-card bg-white rounded-3xl shadow-xl border-4 border-gray-100 overflow-hidden transform transition-all duration-300 hover:shadow-2xl" 
                 data-question="{{ $index + 1 }}"
                 style="{{ $index > 0 ? 'opacity: 0.5; pointer-events: none;' : '' }}">
                
                {{-- Question Header --}}
                <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-pink-600 px-6 py-4">
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
                        <p class="text-xl sm:text-2xl font-bold text-gray-900 leading-relaxed mb-4">{!! nl2br(e($soal->pertanyaan)) !!}</p>
                        
                        {{-- Question Image --}}
                        @if($soal->gambar_soal)
                        <div class="mt-4 rounded-2xl overflow-hidden shadow-lg border-4 border-gray-100">
                            <img src="{{ Storage::url($soal->gambar_soal) }}" 
                                 alt="Gambar Soal {{ $soal->nomor_soal }}" 
                                 class="w-full h-auto max-h-96 object-contain bg-gray-50"
                                 loading="lazy">
                        </div>
                        @endif
                    </div>

                    {{-- Answer Options - Modern Grid Style --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach(['A' => $soal->pilihan_a, 'B' => $soal->pilihan_b, 'C' => $soal->pilihan_c, 'D' => $soal->pilihan_d] as $huruf => $pilihan)
                        <label class="answer-option group relative cursor-pointer">
                            <input type="radio" 
                                   name="jawaban[{{ $soal->nomor_soal }}]" 
                                   value="{{ $huruf }}" 
                                   class="peer sr-only"
                                   onchange="handleAnswerSelect(this, {{ $index + 1 }})">
                            
                            <div class="relative h-full min-h-[80px] p-5 rounded-2xl border-4 border-gray-200 bg-white transition-all duration-200 
                                        peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-lg peer-checked:scale-[1.02]
                                        hover:border-blue-300 hover:shadow-md hover:scale-[1.01]
                                        flex items-center gap-4">
                                
                                {{-- Option Letter Badge --}}
                                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 
                                            peer-checked:bg-gradient-to-br peer-checked:from-blue-500 peer-checked:to-purple-600
                                            flex items-center justify-center shadow-md transition-all duration-200
                                            peer-checked:[&_span]:text-white">
                                    <span class="text-xl font-black text-gray-700 peer-checked:text-white">{{ $huruf }}</span>
                                </div>

                                {{-- Option Text --}}
                                <div class="flex-1 min-w-0">
                                    <span class="text-base font-semibold text-gray-800 leading-snug line-clamp-3">{{ $pilihan }}</span>
                                </div>

                                {{-- Checkmark Icon --}}
                                <div class="absolute top-3 right-3 w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center opacity-0 scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-200">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    {{-- Next Button (appears after answer selected) --}}
                    @if($index < $soalList->count() - 1)
                    <div class="mt-6 hidden answer-selected-indicator">
                        <button type="button" 
                                onclick="goToNextQuestion({{ $index + 2 }})"
                                class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-lg font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105 flex items-center justify-center gap-2 mx-auto">
                            Soal Berikutnya
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach

            {{-- Submit Button - Always visible at the end --}}
            <div class="bg-gradient-to-r from-rose-50 to-orange-50 border-4 border-rose-200 rounded-3xl p-8 text-center shadow-xl">
                <div class="mb-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-rose-500 to-orange-600 rounded-2xl shadow-lg mb-3">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-2">Siap Mengumpulkan?</h3>
                    <p class="text-sm text-gray-600 max-w-md mx-auto">
                        Pastikan semua jawaban sudah terisi. Setelah dikumpulkan, Anda tidak bisa mengubah jawaban lagi.
                    </p>
                </div>
                
                <button type="submit" 
                        onclick="return confirm('⚠️ Apakah Anda yakin ingin mengumpulkan kuis?\n\n✓ Pastikan semua jawaban sudah terisi\n✓ Jawaban tidak dapat diubah setelah dikumpulkan\n\nKlik OK untuk mengumpulkan.')"
                        class="w-full sm:w-auto px-10 py-5 bg-gradient-to-r from-rose-800 to-rose-700 hover:from-rose-900 hover:to-rose-800 text-white text-xl font-black rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-200 hover:scale-105 inline-flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Kumpulkan Kuis Sekarang
                </button>
            </div>
        </div>
    </form>

</div>

{{-- Enhanced JavaScript for Modern Quiz Experience --}}
<script>
(function() {
    // Timer logic
    let sisaDetik = Math.floor({{ $sisaDetik }});
    let interval = null;
    const totalQuestions = {{ $soalList->count() }};
    let answeredQuestions = 0;
    
    console.log('🎯 Modern Quiz initialized with', sisaDetik, 'seconds');
    
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
        bar.classList.remove('border-red-500', 'border-yellow-500', 'border-blue-500');
        display.classList.remove('text-red-600', 'text-yellow-600', 'text-blue-600');
        
        // Update colors based on time
        if (sisaDetik < 60) {
            bar.classList.add('border-red-500', 'animate-pulse');
            display.classList.add('text-red-600');
        } else if (sisaDetik < 300) {
            bar.classList.add('border-yellow-500');
            display.classList.add('text-yellow-600');
        } else {
            bar.classList.add('border-blue-500');
            display.classList.add('text-blue-600');
        }
    }
    
    function updateProgress() {
        const percentage = (answeredQuestions / totalQuestions) * 100;
        document.getElementById('progress-bar').style.width = percentage + '%';
        document.getElementById('progress-text').textContent = answeredQuestions + ' / ' + totalQuestions;
        document.getElementById('mobile-progress').textContent = answeredQuestions + ' / ' + totalQuestions;
    }
    
    function startTimer() {
        updateTimerUI();
        
        interval = setInterval(() => {
            sisaDetik = Math.max(0, sisaDetik - 1);
            
            if (sisaDetik <= 0) {
                clearInterval(interval);
                alert('⏰ Waktu habis! Kuis akan dikumpulkan otomatis.');
                document.getElementById('form-kuis').submit();
                return;
            }
            
            updateTimerUI();
            
            // Warnings
            if (sisaDetik === 300) {
                new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBTGN0fPTgjMGHm7A7+OZURE=').play().catch(() => {});
                setTimeout(() => alert('⏰ Perhatian!\n\nSisa waktu 5 menit lagi!'), 100);
            }
            
            if (sisaDetik === 60) {
                new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBTGN0fPTgjMGHm7A7+OZURE=').play().catch(() => {});
                setTimeout(() => alert('🚨 PERHATIAN!\n\nSisa waktu 1 menit!'), 100);
            }
        }, 1000);
    }
    
    // Make functions global
    window.handleAnswerSelect = function(input, questionNumber) {
        const card = input.closest('.quiz-question-card');
        const indicator = card.querySelector('.answer-selected-indicator');
        
        if (indicator) {
            indicator.classList.remove('hidden');
            indicator.classList.add('animate-fade-in');
        }
        
        // Count answered questions
        answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
        updateProgress();
        
        // Smooth scroll to next button
        setTimeout(() => {
            if (indicator) {
                indicator.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }, 100);
    };
    
    window.goToNextQuestion = function(nextQuestionNumber) {
        const allCards = document.querySelectorAll('.quiz-question-card');
        const nextCard = document.querySelector(`.quiz-question-card[data-question="${nextQuestionNumber}"]`);
        
        if (nextCard) {
            // Enable next card
            nextCard.style.opacity = '1';
            nextCard.style.pointerEvents = 'auto';
            
            // Smooth scroll to next question
            nextCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            // Add entrance animation
            nextCard.classList.add('animate-slide-up');
        }
    };
    
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
    
    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.3s ease-out; }
        .animate-slide-up { animation: slide-up 0.5s ease-out; }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    `;
    document.head.appendChild(style);
})();
</script>

</x-student-layout>
