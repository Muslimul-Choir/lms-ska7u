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
        <div class="max-w-4xl mx-auto space-y-5">
            <div class="bg-white rounded-[18px] shadow-[0_24px_60px_rgba(107,26,43,0.22),0_4px_16px_rgba(0,0,0,0.08)] overflow-hidden border border-[rgba(107,26,43,0.1)]">
                
               
                <div class="px-6 py-[18px] flex items-center justify-between relative overflow-hidden"
                    style="background: linear-gradient(135deg,#6B1A2B 0%,#4A0F1E 55%,#2D0810 100%);">
                    <div class="absolute w-[120px] h-[120px] rounded-full top-[-40px] right-[10px] border border-[rgba(232,147,10,0.2)] pointer-events-none"></div>
                    <div class="absolute w-[70px] h-[70px] rounded-full top-[10px] right-[70px] border border-[rgba(232,147,10,0.12)] pointer-events-none"></div>

                    <div class="flex items-center gap-3 relative">
                        <div class="w-[38px] h-[38px] rounded-[10px] bg-[rgba(232,147,10,0.2)] flex items-center justify-center flex-shrink-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F5A623" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-[15px] m-0 mb-[2px]">Buat Kuis Baru</h3>
                            <p class="text-[rgba(255,255,255,0.5)] text-[11px] m-0">Isi informasi kuis pembelajaran</p>
                        </div>
                    </div>
                </div>

             
                <div class="h-[3px]" style="background: linear-gradient(90deg,#E8930A,#F5A623,#E8930A);"></div>

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

                    <form action="{{ route('kuis.store') }}" method="POST"
                        x-data="{ autoRelease: {{ old('auto_release', 1) }} }">
                        @csrf

                        <div class="flex flex-col gap-[18px]">
                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Judul Kuis <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="judul" value="{{ old('judul') }}" required maxlength="200"
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white"
                                    placeholder="Contoh: Kuis Matematika Bab 1">
                            </div>

                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Deskripsi <span class="text-gray-400">(Opsional)</span>
                                </label>
                                <textarea name="deskripsi" rows="3"
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white"
                                    placeholder="Deskripsi singkat tentang kuis ini...">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Pertemuan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="id_pertemuan" required
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                        <option value="">-- Pilih Pertemuan --</option>
                                        @foreach ($pertemuanList as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('id_pertemuan') == $p->id ? 'selected' : '' }}>
                                                Pertemuan {{ $p->nomor_pertemuan }} - [{{ $p->JadwalBelajar?->Kelas?->nama_kelas ?? 'Tanpa Kelas' }}] - {{ $p->JadwalBelajar?->GuruMapel?->Mapel?->nama_mapel ?? '-' }}
                                                @if($p->tanggal)
                                                    | {{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}
                                                @endif
                                                @if($p->JadwalBelajar?->JamBelajar)
                                                    | {{ \Carbon\Carbon::parse($p->JadwalBelajar->JamBelajar->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($p->JadwalBelajar->JamBelajar->jam_selesai)->format('H:i') }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 italic">💡 Kuis hanya untuk siswa di kelas yang dipilih</p>
                                </div>

                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Mata Pelajaran <span class="text-red-500">*</span>
                                    </label>
                                    <select name="id_guru_mapel" required
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
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

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Durasi (Menit) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="durasi" value="{{ old('durasi', 30) }}" required min="1"
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white"
                                        placeholder="30">
                                    <p class="text-xs text-gray-500">Waktu pengerjaan dalam menit</p>
                                </div>

                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Nilai Maksimal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="nilai_maksimal" value="{{ old('nilai_maksimal', 100) }}"
                                        required min="1" max="100" step="0.1"
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white"
                                        placeholder="100">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Batas Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="datetime-local" name="batas_mulai" value="{{ old('batas_mulai') }}"
                                        required id="batas_mulai"
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                    <p class="text-xs text-gray-500">Tidak boleh sebelum tanggal pertemuan</p>
                                </div>

                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Batas Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="datetime-local" name="batas_selesai" value="{{ old('batas_selesai') }}"
                                        required id="batas_selesai"
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                </div>
                            </div>

                            {{-- Scheduled Release Section --}}
                            <div class="border-t border-gray-200 pt-4 mt-2">
                                <h4 class="text-[12px] font-bold text-gray-700 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Pengaturan Waktu Rilis
                                </h4>

                                {{-- Auto Release Toggle --}}
                                <div class="flex items-start gap-3 mb-4 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                                    <input type="checkbox" name="auto_release" id="auto_release" value="1" x-model="autoRelease" checked
                                        class="mt-0.5 w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                                    <div class="flex-1">
                                        <label for="auto_release" class="text-[13px] font-semibold text-gray-700 cursor-pointer">
                                            Rilis Otomatis Sesuai Jadwal Pertemuan
                                        </label>
                                        <p class="text-[11px] text-gray-600 mt-0.5">
                                            Kuis akan otomatis dirilis sesuai waktu mulai jam belajar pertemuan yang dipilih
                                        </p>
                                    </div>
                                </div>

                                {{-- Manual Release Time --}}
                                <div x-show="!autoRelease" x-cloak class="space-y-3">
                                    <div class="flex flex-col gap-[7px]">
                                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                            Waktu Rilis Manual
                                        </label>
                                        <input type="datetime-local" name="waktu_rilis" value="{{ old('waktu_rilis') }}"
                                            class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                    </div>

                                    <div class="flex flex-col gap-[7px]">
                                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                            Batas Waktu Absensi <span class="text-gray-400 font-normal normal-case tracking-normal">(opsional)</span>
                                        </label>
                                        <input type="datetime-local" name="batas_absensi" value="{{ old('batas_absensi') }}"
                                            class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                        <p class="text-xs text-gray-500">Default: 24 jam setelah waktu rilis</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 text-sm text-blue-700 bg-blue-50 border border-blue-200 rounded-xl flex items-start gap-2">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <strong>Catatan:</strong> Kuis akan dibuat dengan status <strong>Draft</strong>. 
                                    Setelah selesai menambahkan soal, Anda akan ditawarkan opsi untuk mempublikasikan kuis. 
                                    Kuis juga dapat dipublikasikan manual melalui halaman edit.
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-2">
                                <a href="{{ route('kuis.index') }}"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Batal
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl shadow-sm transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Buat Kuis & Tambah Soal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-alerts.success />

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data pertemuan untuk validasi
    const pertemuanData = @json($pertemuanList->mapWithKeys(function($p) {
        return [$p->id => [
            'tanggal' => $p->tanggal,
            'jam_mulai' => $p->JadwalBelajar?->JamBelajar?->jam_mulai,
            'jam_selesai' => $p->JadwalBelajar?->JamBelajar?->jam_selesai
        ]];
    }));
    
    const pertemuanSelect = document.querySelector('select[name="id_pertemuan"]');
    const batasMulaiInput = document.getElementById('batas_mulai');
    const batasSelesaiInput = document.getElementById('batas_selesai');
    
    // Validasi pertemuan
    if (pertemuanSelect && batasMulaiInput) {
        pertemuanSelect.addEventListener('change', function() {
            const pertemuanId = this.value;
            if (pertemuanId && pertemuanData[pertemuanId]) {
                const pertemuan = pertemuanData[pertemuanId];
                
                if (pertemuan.tanggal) {
                    // Set minimum date untuk batas_mulai
                    const tanggalPertemuan = pertemuan.tanggal;
                    batasMulaiInput.setAttribute('min', tanggalPertemuan + 'T00:00');
                    
                    // Auto-fill dengan tanggal pertemuan jika kosong
                    if (!batasMulaiInput.value && pertemuan.jam_mulai) {
                        batasMulaiInput.value = tanggalPertemuan + 'T' + pertemuan.jam_mulai;
                    }
                    if (!batasSelesaiInput.value && pertemuan.jam_selesai) {
                        batasSelesaiInput.value = tanggalPertemuan + 'T' + pertemuan.jam_selesai;
                    }
                }
            }
        });
        
        // Validasi batas_selesai > batas_mulai
        batasMulaiInput.addEventListener('change', function() {
            if (this.value) {
                batasSelesaiInput.setAttribute('min', this.value);
            }
        });
    }
});
</script>
