<x-student-layout>
<x-slot name="heading">{{ Str::limit($kuis->judul, 30) }}</x-slot>

{{-- Timer Bar - Static at top --}}
<div id="timer-bar">
    <div style="max-width:960px;margin:0 auto;padding:12px 16px;">
        <div style="display:flex;align-items:center;justify-content:between;gap:16px;">
            {{-- Timer Display --}}
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);display:flex;align-items:center;justify-content:center;color:#c9982a;flex-shrink:0;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:10px;color:#64748b;font-weight:700;text-transform:uppercase;">Sisa Waktu</div>
                    <div id="timer-display" style="font-size:16px;font-weight:900;color:#c9982a;font-family:monospace;">--:--</div>
                </div>
            </div>

            {{-- Progress --}}
            <div style="flex:1;max-width:400px;margin-left:auto;display:flex;flex-direction:column;gap:4px;">
                <div style="display:flex;align-items:center;justify-content:space-between;font-size:11px;font-weight:700;color:#64748b;">
                    <span>Progress Pengerjaan</span>
                    <span id="progress-text">0 / {{ $soalList->count() }}</span>
                </div>
                <div style="height:8px;background:rgba(255,255,255,0.05);border-radius:99px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);">
                    <div id="progress-bar" style="height:100%;width:0%;background:linear-gradient(90deg,#c9982a,#f0be3d);border-radius:99px;transition:width .3s;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form-kuis" action="{{ route('siswa.kuis.submit', $kuis->id) }}" method="POST">
    @csrf

    {{-- Questions Container --}}
    <div style="max-width:720px;margin:0 auto;padding:20px 16px;">
        @foreach($soalList as $index => $soal)
        <div class="quiz-question-card {{ $index === 0 ? '' : 'hidden' }}" 
             data-question="{{ $index + 1 }}"
             id="question-{{ $index + 1 }}"
             style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,0.35);">
            
            {{-- Question Header --}}
            <div style="background:linear-gradient(135deg,#6B1A2B,#3D0A13);padding:14px 20px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:space-between;gap:12px;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:30px;height:30px;border-radius:8px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:14px;">
                        {{ $soal->nomor_soal }}
                    </div>
                    <span style="font-size:13px;font-weight:700;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;">Soal {{ $soal->nomor_soal }} dari {{ $soalList->count() }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:6px;padding:3px 10px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:99px;font-size:10px;font-weight:800;color:#e2e8f0;text-transform:uppercase;letter-spacing:.05em;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                    </svg>
                    <span>Pilih 1 Jawaban</span>
                </div>
            </div>

            {{-- Question Content --}}
            <div style="padding:20px;">
                {{-- Question Text --}}
                <div style="margin-bottom:20px;">
                    <p style="font-size:16px;font-weight:700;color:#f1f5f9;line-height:1.6;margin:0 0 10px;">{!! nl2br(e($soal->pertanyaan)) !!}</p>
                    
                    {{-- Question Image --}}
                    @if($soal->gambar_soal)
                    <div style="margin-top:12px;border-radius:12px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.02);padding:6px;">
                        <img src="{{ Storage::url($soal->gambar_soal) }}" 
                             alt="Gambar Soal {{ $soal->nomor_soal }}" 
                             style="width:100%;height:auto;max-height:300px;object-fit:contain;border-radius:8px;"
                             loading="lazy">
                    </div>
                    @endif
                </div>

                {{-- Answer Options --}}
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach(['A' => $soal->pilihan_a, 'B' => $soal->pilihan_b, 'C' => $soal->pilihan_c, 'D' => $soal->pilihan_d] as $huruf => $pilihan)
                    <label class="answer-option" style="position:relative;cursor:pointer;display:block;">
                        <input type="radio" 
                               name="jawaban[{{ $soal->nomor_soal }}]" 
                               value="{{ $huruf }}" 
                               style="position:absolute;opacity:0;width:0;height:0;"
                               class="peer"
                               onchange="handleAnswerSelect(this, {{ $index + 1 }}, {{ $soalList->count() }})">
                        
                        <div class="answer-option-div">
                            {{-- Option Letter Badge --}}
                            <div class="option-badge">
                                {{ $huruf }}
                            </div>

                            {{-- Option Text --}}
                            <div style="flex:1;min-width:0;">
                                <span style="font-size:13px;font-weight:500;line-height:1.4;">{{ $pilihan }}</span>
                            </div>

                            {{-- Checkmark Icon --}}
                            <div class="option-checkmark">
                                <svg width="12" height="12" fill="none" stroke="#1a0a00" viewBox="0 0 24 24" stroke-width="3.5">
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

        {{-- Navigation Controls --}}
        <div style="margin-top:16px;display:flex;align-items:center;justify-content:space-between;gap:12px;">
            <button type="button" 
                    id="btn-prev" 
                    onclick="navigateQuestion('prev')"
                    style="padding:10px 20px;background:rgba(255,255,255,0.05);color:#cbd5e1;border:1px solid rgba(255,255,255,0.08);border-radius:12px;font-weight:700;font-size:13px;cursor:pointer;display:flex;align-items:center;gap:6px;transition:all 0.2s;"
                    onmouseover="if(!this.disabled) {this.style.background='rgba(255,255,255,0.1)';}"
                    onmouseout="if(!this.disabled) {this.style.background='rgba(255,255,255,0.05)';}"
                    disabled>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Sebelumnya</span>
            </button>

            <div style="font-size:13px;font-weight:700;color:#64748b;font-family:monospace;">
                <span id="current-question" style="color:#f1f5f9;">1</span> / {{ $soalList->count() }}
            </div>

            <button type="button" 
                    id="btn-next" 
                    onclick="navigateQuestion('next')"
                    style="padding:10px 20px;background:linear-gradient(135deg,#6B1A2B,#9B3045);color:#fff;border:none;border-radius:12px;font-weight:700;font-size:13px;cursor:pointer;display:flex;align-items:center;gap:6px;transition:all 0.2s;"
                    onmouseover="if(!this.disabled) {this.style.opacity='0.9';}"
                    onmouseout="if(!this.disabled) {this.style.opacity='1';}">
                <span>Selanjutnya</span>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        {{-- Question Navigator Grid --}}
        <div style="margin-top:16px;background:rgba(22,28,45,0.7);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.08);border-radius:14px;padding:16px;">
            <h3 style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin:0 0 12px;display:flex;align-items:center;gap:6px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
                Navigasi Soal
            </h3>
            <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(34px, 1fr));gap:6px;">
                @foreach($soalList as $index => $soal)
                <button type="button"
                        onclick="jumpToQuestion({{ $index + 1 }})"
                        class="question-nav-btn"
                        style="height:34px;border-radius:8px;border:1.5px solid;font-weight:700;font-size:12px;transition:all 0.15s;cursor:pointer;display:flex;align-items:center;justify-content:center;"
                        data-question="{{ $index + 1 }}"
                        id="nav-btn-{{ $index + 1 }}">
                    {{ $soal->nomor_soal }}
                </button>
                @endforeach
            </div>
            <div style="margin-top:12px;display:flex;flex-wrap:wrap;gap:12px;font-size:11px;font-weight:600;color:#64748b;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <div style="width:12px;height:12px;border-radius:4px;border:1.5px solid #c9982a;background:rgba(201,152,42,0.2);"></div>
                    <span>Aktif</span>
                </div>
                <div style="display:flex;align-items:center;gap:6px;">
                    <div style="width:12px;height:12px;border-radius:4px;border:1.5px solid #10b981;background:rgba(16,185,129,0.12);"></div>
                    <span>Dijawab</span>
                </div>
                <div style="display:flex;align-items:center;gap:6px;">
                    <div style="width:12px;height:12px;border-radius:4px;border:1.5px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.02);"></div>
                    <span>Belum</span>
                </div>
            </div>
        </div>

        {{-- Submit Panel --}}
        <div style="margin-top:20px;background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:24px;text-align:center;">
            <div style="display:flex;flex-direction:column;align-items:center;margin-bottom:16px;">
                <div style="width:52px;height:52px;border-radius:14px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);display:flex;align-items:center;justify-content:center;color:#c9982a;margin-bottom:12px;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                </div>
                <h3 style="font-size:16px;font-weight:800;color:#fff;margin:0 0 4px;font-family:'Plus Jakarta Sans',sans-serif;">Siap Mengumpulkan?</h3>
                <p style="font-size:12px;color:#94a3b8;margin:0;max-width:320px;line-height:1.5;">
                    Pastikan semua jawaban sudah terisi. Setelah dikumpulkan, Anda tidak dapat mengubah jawaban lagi.
                </p>
            </div>
            
            <button type="submit" 
                    onclick="return confirmSubmitKuis(event)"
                    style="width:100%;padding:12px;background:linear-gradient(135deg,#c9982a,#f0be3d);color:#1a0a00;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:opacity .2s;display:flex;align-items:center;justify-content:center;gap:8px;"
                    onmouseover="this.style.opacity='0.9'"
                    onmouseout="this.style.opacity='1'">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Kumpulkan Kuis Sekarang
            </button>
        </div>
    </div>
</form>

{{-- JavaScript for Quiz with Pagination --}}
<script>
(function() {
    // Quiz state
    const kuis_id = {{ $kuis->id }};
    const server_sisaDetik = {{ $sisaDetik }};
    const durasi_total = {{ $kuis->durasi * 60 }};
    
    // Calculate deadline timestamp from server data
    const serverTime = Date.now();
    const deadlineKey = 'quiz_deadline_' + kuis_id;
    
    // Check if we have stored deadline
    let deadline = localStorage.getItem(deadlineKey);
    
    if (!deadline) {
        // First time loading this quiz, set deadline based on server remaining time
        deadline = serverTime + (server_sisaDetik * 1000);
        localStorage.setItem(deadlineKey, deadline);
        console.log('🎯 Quiz deadline set:', new Date(deadline).toLocaleString());
    } else {
        deadline = parseInt(deadline);
        console.log('🎯 Quiz deadline loaded from storage:', new Date(deadline).toLocaleString());
    }
    
    // Calculate current remaining time based on deadline
    function getSisaDetik() {
        const now = Date.now();
        const remaining = Math.floor((deadline - now) / 1000);
        return Math.max(0, remaining);
    }
    
    let sisaDetik = getSisaDetik();
    let interval = null;
    const totalQuestions = {{ $soalList->count() }};
    let answeredQuestions = new Set();
    let currentQuestion = 1;
    
    console.log('🎯 Quiz initialized - ID:', kuis_id, 'Remaining:', sisaDetik, 'seconds');
    
    // Timer functions
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
        bar.classList.remove('timer-warning', 'timer-danger');
        display.classList.remove('timer-warning', 'timer-danger');
        
        // Update colors based on time
        if (sisaDetik < 60) {
            bar.classList.add('timer-danger');
            display.classList.add('timer-danger');
        } else if (sisaDetik < 300) {
            bar.classList.add('timer-warning');
            display.classList.add('timer-warning');
        }
    }
    
    function updateProgress() {
        const answered = answeredQuestions.size;
        const percentage = (answered / totalQuestions) * 100;
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        
        if (progressBar) progressBar.style.width = percentage + '%';
        if (progressText) progressText.textContent = answered + ' / ' + totalQuestions;
    }
    
    function startTimer() {
        updateTimerUI();
        
        interval = setInterval(() => {
            // Recalculate from deadline to prevent drift
            sisaDetik = getSisaDetik();
            
            if (sisaDetik <= 0) {
                clearInterval(interval);
                localStorage.removeItem(deadlineKey); // Clean up
                Swal.fire({
                    title: 'Waktu Habis!',
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
                    title: 'Perhatian!',
                    text: 'Sisa waktu 5 menit lagi!',
                    icon: 'warning',
                    confirmButtonColor: '#6B1A2B',
                    timer: 3000,
                    timerProgressBar: true
                });
            }
            
            if (sisaDetik === 60) {
                Swal.fire({
                    title: 'PERHATIAN!',
                    text: 'Sisa waktu 1 menit!',
                    icon: 'error',
                    confirmButtonColor: '#6B1A2B',
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        }, 1000);
    }
    
    // Navigation functions
    function updateNavigationButtons() {
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');
        const currentQuestionDisplay = document.getElementById('current-question');
        
        if (currentQuestionDisplay) {
            currentQuestionDisplay.textContent = currentQuestion;
        }
        
        // Update prev button
        if (btnPrev) {
            if (currentQuestion <= 1) {
                btnPrev.disabled = true;
                btnPrev.style.opacity = '0.5';
                btnPrev.style.cursor = 'not-allowed';
            } else {
                btnPrev.disabled = false;
                btnPrev.style.opacity = '1';
                btnPrev.style.cursor = 'pointer';
            }
        }
        
        // Update next button
        if (btnNext) {
            if (currentQuestion >= totalQuestions) {
                btnNext.disabled = true;
                btnNext.style.opacity = '0.5';
                btnNext.style.cursor = 'not-allowed';
            } else {
                btnNext.disabled = false;
                btnNext.style.opacity = '1';
                btnNext.style.cursor = 'pointer';
            }
        }
    }
    
    function updateQuestionNavButtons() {
        // Update all nav buttons
        for (let i = 1; i <= totalQuestions; i++) {
            const navBtn = document.getElementById('nav-btn-' + i);
            if (!navBtn) continue;
            
            // Remove all state classes
            navBtn.classList.remove('btn-nav-active', 'btn-nav-answered', 'btn-nav-unanswered');
            
            if (i === currentQuestion) {
                // Active question
                navBtn.classList.add('btn-nav-active');
            } else if (answeredQuestions.has(i)) {
                // Answered question
                navBtn.classList.add('btn-nav-answered');
            } else {
                // Unanswered question
                navBtn.classList.add('btn-nav-unanswered');
            }
        }
    }
    
    function showQuestion(questionNumber) {
        // Hide all questions
        document.querySelectorAll('.quiz-question-card').forEach(card => {
            card.classList.add('hidden');
        });
        
        // Show target question
        const targetQuestion = document.getElementById('question-' + questionNumber);
        if (targetQuestion) {
            targetQuestion.classList.remove('hidden');
            currentQuestion = questionNumber;
            updateNavigationButtons();
            updateQuestionNavButtons();
            
            // Scroll to top smoothly
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
    
    // Global navigation functions
    window.navigateQuestion = function(direction) {
        if (direction === 'next' && currentQuestion < totalQuestions) {
            showQuestion(currentQuestion + 1);
        } else if (direction === 'prev' && currentQuestion > 1) {
            showQuestion(currentQuestion - 1);
        }
    };
    
    window.jumpToQuestion = function(questionNumber) {
        if (questionNumber >= 1 && questionNumber <= totalQuestions) {
            showQuestion(questionNumber);
        }
    };
    
    // Answer selection handler
    window.handleAnswerSelect = function(input, questionNumber, totalQuestions) {
        const questionNum = parseInt(input.name.match(/\d+/)[0]);
        answeredQuestions.add(questionNum);
        updateProgress();
        updateQuestionNavButtons();
        
        console.log('Answer selected for question', questionNum, '- Total answered:', answeredQuestions.size);
    };
    
    // Confirm submit function
    window.confirmSubmitKuis = function(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        const answered = answeredQuestions.size;
        const unanswered = totalQuestions - answered;
        
        let html = `<div style="text-align:left;font-size:14px;color:#cbd5e1;">
            <p style="margin-bottom:12px;">Pastikan semua jawaban sudah terisi.</p>
            <div style="background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.25);border-radius:8px;padding:12px;margin-bottom:8px;display:flex;align-items:center;gap:6px;">
                <svg width="14" height="14" fill="none" stroke="#34d399" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                <strong style="color:#34d399;">Sudah dijawab: ${answered} soal</strong>
            </div>`;
        
        if (unanswered > 0) {
            html += `<div style="background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.25);border-radius:8px;padding:12px;margin-bottom:8px;display:flex;align-items:center;gap:6px;">
                <svg width="14" height="14" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                <strong style="color:#fbbf24;">Belum dijawab: ${unanswered} soal</strong>
            </div>`;
        }
        
        html += `<div style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.25);border-radius:8px;padding:12px;display:flex;align-items:center;gap:6px;">
                <svg width="14" height="14" fill="none" stroke="#f87171" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                <strong style="color:#f87171;">Jawaban tidak dapat diubah setelah dikumpulkan!</strong>
            </div>
        </div>`;
        
        Swal.fire({
            title: 'Kumpulkan Kuis?',
            html: html,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6B1A2B',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Kumpulkan',
            cancelButtonText: 'Periksa Lagi',
            reverseButtons: true,
            width: '500px'
        }).then((result) => {
            if (result.isConfirmed) {
                clearInterval(interval);
                localStorage.removeItem(deadlineKey); // Clean up
                form.submit();
            }
        });
        
        return false;
    };
    
    // Initialize
    function initialize() {
        // Initialize answered questions from existing selections
        document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
            const questionNum = parseInt(input.name.match(/\d+/)[0]);
            answeredQuestions.add(questionNum);
        });
        
        updateProgress();
        updateNavigationButtons();
        updateQuestionNavButtons();
        startTimer();
    }
    
    // Start quiz
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        initialize();
    }
    
    // Prevent accidental close
    window.addEventListener('beforeunload', function (e) {
        if (sisaDetik > 0) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowRight' && currentQuestion < totalQuestions) {
            navigateQuestion('next');
        } else if (e.key === 'ArrowLeft' && currentQuestion > 1) {
            navigateQuestion('prev');
        }
    });
})();
</script>

<style>
[x-cloak] { display: none !important; }

#timer-bar {
    position: sticky;
    top: 0;
    z-index: 50;
    background: rgba(11, 15, 25, 0.85);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-bottom: 2px solid rgba(255,255,255,0.08);
    transition: border-color .3s;
}
#timer-bar.timer-warning {
    border-bottom-color: #fbbf24;
}
#timer-bar.timer-danger {
    border-bottom-color: #ef4444;
}

#timer-display {
    transition: color .3s;
}
#timer-display.timer-warning {
    color: #fbbf24 !important;
}
#timer-display.timer-danger {
    color: #ef4444 !important;
}

.answer-option-div {
    position: relative;
    min-height: 60px;
    padding: 12px 16px;
    border-radius: 12px;
    border: 2px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.02);
    color: #e2e8f0;
    transition: all 0.25s;
    display: flex;
    align-items: center;
    gap: 14px;
}
.answer-option input:checked + .answer-option-div {
    border-color: #c9982a;
    background: rgba(201,152,42,0.1);
    box-shadow: 0 0 12px rgba(201,152,42,0.25);
    color: #fff;
}
.answer-option:hover .answer-option-div {
    border-color: rgba(255,255,255,0.18);
}
.answer-option input:checked:hover + .answer-option-div {
    border-color: #c9982a;
}

.option-badge {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: rgba(255,255,255,0.08);
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 15px;
    transition: all 0.25s;
}
.answer-option input:checked + .answer-option-div .option-badge {
    background: linear-gradient(135deg,#c9982a,#f0be3d);
    color: #1a0a00;
}
.option-checkmark {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #c9982a;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: scale(0.8);
    transition: all 0.2s;
}
.answer-option input:checked + .answer-option-div .option-checkmark {
    opacity: 1;
    transform: scale(1);
}

.btn-nav-active {
    border-color: #c9982a !important;
    background: rgba(201,152,42,0.2) !important;
    color: #f0be3d !important;
}
.btn-nav-answered {
    border-color: #10b981 !important;
    background: rgba(16,185,129,0.12) !important;
    color: #34d399 !important;
}
.btn-nav-unanswered {
    border-color: rgba(255,255,255,0.08) !important;
    background: rgba(255,255,255,0.02) !important;
    color: #94a3b8 !important;
}
</style>

</x-student-layout>
