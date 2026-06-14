<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Preview Materi
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
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('materi.index') }}" class="text-amber-600 hover:text-amber-700 transition">Materi</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-600 font-semibold">Preview</span>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- Info Card --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $materi->judul }}</h1>
                            @if ($materi->deskripsi)
                                <p class="text-gray-600 mb-4">{{ $materi->deskripsi }}</p>
                            @endif
                        </div>
                        <a href="{{ route('materi.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                            <div class="text-xs text-gray-600 mb-1 font-semibold uppercase tracking-wider">Pertemuan</div>
                            <div class="font-bold text-gray-900">Pertemuan {{ $materi->Pertemuan?->nomor_pertemuan ?? '-' }}</div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-xl border border-purple-100">
                            <div class="text-xs text-gray-600 mb-1 font-semibold uppercase tracking-wider">Kelas</div>
                            <div class="font-bold text-gray-900">{{ $materi->Pertemuan?->JadwalBelajar?->Kelas?->nama_kelas ?? '-' }}</div>
                        </div>
                        <div class="bg-amber-50 p-4 rounded-xl border border-amber-100">
                            <div class="text-xs text-gray-600 mb-1 font-semibold uppercase tracking-wider">Mata Pelajaran</div>
                            <div class="font-bold text-gray-900">{{ $materi->Pertemuan?->JadwalBelajar?->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</div>
                        </div>
                        <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-100">
                            <div class="text-xs text-gray-600 mb-1 font-semibold uppercase tracking-wider">Tipe Materi</div>
                            <div class="font-bold text-gray-900 capitalize">{{ $materi->tipe_materi }}</div>
                        </div>
                    </div>
                </div>

                {{-- Preview Section --}}
                <div class="p-6">
                    @php
                        $fileUrl = str_starts_with($materi->file_url, 'http') 
                            ? $materi->file_url 
                            : asset('storage/' . $materi->file_url);
                        $isExternal = str_starts_with($materi->file_url, 'http');
                        $fileExtension = pathinfo($materi->file_url, PATHINFO_EXTENSION);
                    @endphp

                    {{-- PDF Documents --}}
                    @if (in_array(strtolower($fileExtension), ['pdf']))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                    </svg>
                                    Dokumen PDF
                                </h3>
                                <a href="{{ $fileUrl }}" target="_blank" download
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download PDF
                                </a>
                            </div>
                            <div class="bg-white rounded-lg overflow-hidden border-2 border-gray-300" style="height: 800px;">
                                <iframe src="{{ $fileUrl }}" 
                                    class="w-full h-full" 
                                    frameborder="0"
                                    title="PDF Preview">
                                </iframe>
                            </div>
                        </div>

                    {{-- Word Documents --}}
                    @elseif (in_array(strtolower($fileExtension), ['doc', 'docx']))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                    </svg>
                                    Dokumen Word
                                </h3>
                                <a href="{{ $fileUrl }}" target="_blank" download
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-xl transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download DOC
                                </a>
                            </div>
                            <div class="bg-white rounded-lg overflow-hidden border-2 border-gray-300" style="height: 800px;">
                                <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}" 
                                    class="w-full h-full" 
                                    frameborder="0"
                                    title="Word Preview">
                                </iframe>
                            </div>
                        </div>

                    {{-- Video Files --}}
                    @elseif (in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg']) || $materi->tipe_materi === 'video')
                        <div class="bg-gray-900 rounded-xl overflow-hidden">
                            <video controls class="w-full" style="max-height: 600px;">
                                <source src="{{ $fileUrl }}" type="video/{{ $fileExtension }}">
                                Browser Anda tidak mendukung tag video.
                            </video>
                        </div>

                    {{-- YouTube or External Video Link --}}
                    @elseif ($isExternal && (str_contains($materi->file_url, 'youtube.com') || str_contains($materi->file_url, 'youtu.be')))
                        @php
                            // Extract YouTube video ID
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $materi->file_url, $matches);
                            $videoId = $matches[1] ?? null;
                        @endphp
                        @if ($videoId)
                            <div class="bg-gray-900 rounded-xl overflow-hidden">
                                <div class="relative" style="padding-bottom: 56.25%; height: 0;">
                                    <iframe 
                                        src="https://www.youtube.com/embed/{{ $videoId }}" 
                                        class="absolute top-0 left-0 w-full h-full"
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen
                                        title="YouTube Video">
                                    </iframe>
                                </div>
                            </div>
                        @else
                            <div class="bg-blue-50 rounded-xl p-8 border border-blue-200 text-center">
                                <svg class="w-16 h-16 mx-auto mb-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                </svg>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Link Video Eksternal</h3>
                                <p class="text-gray-600 mb-4">Klik tombol di bawah untuk membuka video</p>
                                <a href="{{ $fileUrl }}" target="_blank"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Buka Video
                                </a>
                            </div>
                        @endif

                    {{-- External Links --}}
                    @elseif ($isExternal || $materi->tipe_materi === 'link')
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-8 border border-amber-200 text-center">
                            <div class="w-20 h-20 mx-auto mb-4 bg-amber-100 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Materi Link Eksternal</h3>
                            <p class="text-gray-600 mb-2 max-w-md mx-auto break-words">{{ $fileUrl }}</p>
                            <p class="text-sm text-gray-500 mb-6">Klik tombol di bawah untuk membuka link materi</p>
                            <a href="{{ $fileUrl }}" target="_blank"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-sm transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Buka Link
                            </a>
                        </div>

                    {{-- Other Files --}}
                    @else
                        <div class="bg-gray-50 rounded-xl p-8 border border-gray-200 text-center">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">File Materi</h3>
                            <p class="text-gray-600 mb-4">Preview tidak tersedia untuk tipe file ini</p>
                            <a href="{{ $fileUrl }}" target="_blank" download
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-700 hover:bg-gray-800 text-white font-semibold rounded-xl transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download File
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
