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
                    Edit Kuis
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
        <span class="text-gray-600 font-semibold">Edit</span>
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-[15px] m-0 mb-[2px]">Edit Kuis</h3>
                            <p class="text-[rgba(255,255,255,0.5)] text-[11px] m-0">Perbarui informasi kuis</p>
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

                    <form action="{{ route('kuis.update', $kuis) }}" method="POST" onsubmit="return handleUpdate(event)"
                        x-data="{ autoRelease: {{ old('auto_release', $kuis->auto_release ? 1 : 0) }} }">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-col gap-[18px]">
                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Judul Kuis <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="judul" value="{{ old('judul', $kuis->judul) }}" required
                                    maxlength="200"
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                            </div>

                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Deskripsi <span class="text-gray-400">(Opsional)</span>
                                </label>
                                <textarea name="deskripsi" rows="3"
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">{{ old('deskripsi', $kuis->deskripsi) }}</textarea>
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
                                                {{ old('id_pertemuan', $kuis->id_pertemuan) == $p->id ? 'selected' : '' }}>
                                                Pertemuan {{ $p->nomor_pertemuan }} -  [{{ $p->JadwalBelajar?->Kelas?->nama_kelas ?? 'Tanpa Kelas' }}] - {{ $p->JadwalBelajar?->GuruMapel?->Mapel?->nama_mapel ?? '-' }}
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
                                                {{ old('id_guru_mapel', $kuis->id_guru_mapel) == $gm->id ? 'selected' : '' }}>
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
                                    <input type="number" name="durasi" value="{{ old('durasi', $kuis->durasi) }}"
                                        required min="1"
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                </div>

                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Nilai Maksimal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="nilai_maksimal"
                                        value="{{ old('nilai_maksimal', $kuis->nilai_maksimal) }}" required min="1"
                                        max="100" step="0.1"
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Batas Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="datetime-local" name="batas_mulai"
                                        value="{{ old('batas_mulai', \Carbon\Carbon::parse($kuis->batas_mulai)->format('Y-m-d\TH:i')) }}"
                                        required
                                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                </div>

                                <div class="flex flex-col gap-[7px]">
                                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                        Batas Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="datetime-local" name="batas_selesai"
                                        value="{{ old('batas_selesai', \Carbon\Carbon::parse($kuis->batas_selesai)->format('Y-m-d\TH:i')) }}"
                                        required
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
                                    <input type="checkbox" name="auto_release" id="auto_release" value="1" x-model="autoRelease" 
                                        {{ old('auto_release', $kuis->auto_release) ? 'checked' : '' }}
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
                                        <input type="datetime-local" name="waktu_rilis" 
                                            value="{{ old('waktu_rilis', $kuis->waktu_rilis ? \Carbon\Carbon::parse($kuis->waktu_rilis)->format('Y-m-d\TH:i') : '') }}"
                                            class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                    </div>

                                    <div class="flex flex-col gap-[7px]">
                                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                            Batas Waktu Absensi <span class="text-gray-400 font-normal normal-case tracking-normal">(opsional)</span>
                                        </label>
                                        <input type="datetime-local" name="batas_absensi" 
                                            value="{{ old('batas_absensi', $kuis->batas_absensi ? \Carbon\Carbon::parse($kuis->batas_absensi)->format('Y-m-d\TH:i') : '') }}"
                                            class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                        <p class="text-xs text-gray-500">Default: 24 jam setelah waktu rilis</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-[7px]">
                                <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" required
                                    class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                                    <option value="draft"
                                        {{ old('status', $kuis->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published"
                                        {{ old('status', $kuis->status) === 'published' ? 'selected' : '' }}>Published
                                    </option>
                                    <option value="closed"
                                        {{ old('status', $kuis->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                                <p class="text-xs text-gray-500">
                                    Kuis harus memiliki minimal 1 soal untuk dapat dipublikasikan. 
                                    Status "Published" akan membuat kuis terlihat oleh siswa.
                                </p>
                            </div>

                            <div class="flex justify-between items-center pt-2">
                                <a href="{{ route('kuis.show', $kuis) }}"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Batal
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl shadow-sm transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Simpan Perubahan
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
<x-alerts.confirm-update />

@push('scripts')
    <script>
        function handleUpdate(event) {
            event.preventDefault();
            showConfirmUpdate().then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
            return false;
        }
    </script>
@endpush
