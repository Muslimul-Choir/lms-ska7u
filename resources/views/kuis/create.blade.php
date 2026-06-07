<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Buat Kuis Baru
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
        <a href="{{ route('kuis.index') }}" class="text-amber-600 hover:text-amber-700 transition">Kuis</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-600 font-semibold">Buat Baru</span>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">

                    @if ($errors->any())
                        <div
                            class="flex items-center justify-between px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm mb-4">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="font-medium mb-1">Terdapat kesalahan:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('kuis.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Judul Kuis <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="judul" value="{{ old('judul') }}" required maxlength="200"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: Kuis Matematika Bab 1">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Deskripsi singkat tentang kuis ini...">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pertemuan <span
                                        class="text-red-500">*</span></label>
                                <select name="id_pertemuan" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Pilih Pertemuan --</option>
                                    @foreach ($pertemuanList as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('id_pertemuan') == $p->id ? 'selected' : '' }}>
                                            Pertemuan {{ $p->nomor_pertemuan }} - 🎓 [{{ $p->JadwalBelajar?->Kelas?->nama_kelas ?? 'Tanpa Kelas' }}] - {{ $p->JadwalBelajar?->GuruMapel?->Mapel?->nama_mapel ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 italic mt-1">💡 Kuis hanya untuk siswa di kelas yang dipilih</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran <span
                                        class="text-red-500">*</span></label>
                                <select name="id_guru_mapel" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    @foreach ($guruMapelList as $gm)
                                        <option value="{{ $gm->id }}"
                                            {{ old('id_guru_mapel') == $gm->id ? 'selected' : '' }}>
                                            {{ $gm->Mapel?->nama_mapel ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Durasi (Menit) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="durasi" value="{{ old('durasi', 30) }}" required
                                    min="1"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="30">
                                <p class="text-xs text-gray-500 mt-1">Waktu pengerjaan dalam menit</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Maksimal <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="nilai_maksimal" value="{{ old('nilai_maksimal', 100) }}"
                                    required min="1" max="100" step="0.1"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="100">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Batas Mulai <span
                                        class="text-red-500">*</span></label>
                                <input type="datetime-local" name="batas_mulai" value="{{ old('batas_mulai') }}"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Batas Selesai <span
                                        class="text-red-500">*</span></label>
                                <input type="datetime-local" name="batas_selesai" value="{{ old('batas_selesai') }}"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg flex items-start gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <strong>Catatan:</strong> Kuis akan dibuat dengan status <strong>Draft</strong>. Anda
                                dapat menambahkan soal terlebih dahulu sebelum mempublikasikan.
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('kuis.index') }}"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-lg inline-flex items-center gap-2 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 px-4 rounded-lg inline-flex items-center gap-2 shadow-sm transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Buat Kuis & Tambah Soal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
