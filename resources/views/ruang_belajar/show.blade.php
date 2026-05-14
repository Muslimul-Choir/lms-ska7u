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
                    Ruang Belajar
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">{{ $jadwalbelajar->mapel->nama_mapel ?? 'Mata Pelajaran' }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5 flex flex-col md:flex-row gap-6">
            
            <!-- Sidebar: Daftar Modul & Materi -->
            <div class="w-full md:w-1/3 lg:w-1/4">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B] text-white font-semibold text-sm tracking-wide">
                        Daftar Materi
                    </div>
                    <div class="overflow-y-auto max-h-[70vh]">
                        @foreach ($jadwalbelajar->pertemuan as $pertemuan)
                            <div class="border-b border-slate-100 last:border-0">
                                <div class="px-4 py-3 bg-slate-50 text-xs font-bold text-slate-700 uppercase tracking-widest">
                                    Pertemuan {{ $pertemuan->nomor_pertemuan }}
                                </div>
                                <ul>
                                    @foreach ($pertemuan->materi as $m)
                                        <li>
                                            <a href="{{ route('ruang-belajar.show', ['jadwalbelajar' => $jadwalbelajar->id, 'materi' => $m->id]) }}" 
                                               class="flex items-center justify-between px-4 py-3 text-sm hover:bg-[#1B3A6B]/5 transition-colors {{ $materi->id === $m->id ? 'bg-[#1B3A6B]/10 border-l-4 border-[#1B3A6B] font-semibold text-[#0F2145]' : 'text-slate-600' }}">
                                                <div class="flex items-center">
                                                    @if($m->tipe_materi == 'video')
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    @elseif($m->tipe_materi == 'dokumen')
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                    @else
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                    @endif
                                                    <span class="truncate">{{ $m->judul }}</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Content: Ruang Belajar -->
            <div class="w-full md:w-2/3 lg:w-3/4 flex flex-col gap-6">
                
                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </div>
                @endif

                <!-- Content Area -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h1 class="text-2xl font-bold text-[#0F2145] mb-2">{{ $materi->judul }}</h1>
                        <p class="text-slate-500 mb-6 text-xs font-medium tracking-wide uppercase">Pertemuan {{ $materi->pertemuan->nomor_pertemuan }} &bull; Tipe: {{ ucfirst($materi->tipe_materi) }}</p>

                        <!-- Media Display -->
                        <div class="w-full bg-slate-50 rounded-lg border border-slate-200 overflow-hidden mb-6 flex items-center justify-center min-h-[400px]">
                            @if($materi->tipe_materi == 'video')
                                @if($materi->file_url)
                                    <video controls class="w-full max-h-[500px]">
                                        <source src="{{ asset('storage/' . $materi->file_url) }}" type="video/mp4">
                                        Browser Anda tidak mendukung video HTML5.
                                    </video>
                                @else
                                    <div class="text-slate-400 font-medium">Video belum diunggah.</div>
                                @endif
                            @elseif($materi->tipe_materi == 'dokumen')
                                @if($materi->file_url)
                                    <iframe src="{{ asset('storage/' . $materi->file_url) }}" class="w-full h-[600px]" frameborder="0"></iframe>
                                @else
                                    <div class="text-slate-400 font-medium">Dokumen PDF belum diunggah.</div>
                                @endif
                            @else
                                <div class="p-8 prose max-w-none w-full bg-white text-slate-700">
                                    {!! nl2br(e($materi->deskripsi)) !!}
                                </div>
                            @endif
                        </div>

                        <!-- Deskripsi -->
                        @if($materi->tipe_materi != 'lainnya' && $materi->deskripsi)
                            <div class="prose max-w-none text-slate-700 text-sm">
                                <h3 class="text-lg font-bold text-[#0F2145] mb-2">Deskripsi Materi</h3>
                                <p>{!! nl2br(e($materi->deskripsi)) !!}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Lesson: Navigasi & Tandai Selesai -->
                <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div>
                        @if($prevMateri)
                            <a href="{{ route('ruang-belajar.show', ['jadwalbelajar' => $jadwalbelajar->id, 'materi' => $prevMateri->id]) }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold tracking-wide transition">
                                &laquo; Sebelumnya
                            </a>
                        @endif
                    </div>
                    
                    <form action="{{ route('ruang-belajar.mark-done', $materi->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-[#C8992A] hover:bg-[#b5861f] text-white rounded-lg text-xs font-bold tracking-wide transition shadow-md shadow-amber-900/20">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Tandai Selesai
                        </button>
                    </form>

                    <div>
                        @if($nextMateri)
                            <a href="{{ route('ruang-belajar.show', ['jadwalbelajar' => $jadwalbelajar->id, 'materi' => $nextMateri->id]) }}" class="inline-flex items-center px-4 py-2 bg-[#1B3A6B] hover:bg-[#0F2145] text-white rounded-lg text-xs font-semibold tracking-wide transition">
                                Berikutnya &raquo;
                            </a>
                        @else
                            <span class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-400 rounded-lg text-xs font-semibold tracking-wide cursor-not-allowed">
                                Berikutnya &raquo;
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
