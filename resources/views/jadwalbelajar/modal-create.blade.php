<div id="modalCreate" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5">

    {{-- Overlay --}}
    <div onclick="closeCreateModal()"
        class="absolute inset-0 bg-[rgba(45,8,16,0.55)] backdrop-blur-[4px]">
    </div>

    {{-- Dialog --}}
    <div class="relative z-10 w-full max-w-lg">
        <div class="bg-white rounded-[18px] shadow-[0_24px_60px_rgba(107,26,43,0.22),0_4px_16px_rgba(0,0,0,0.08)] overflow-hidden border border-[rgba(107,26,43,0.1)]">

            {{-- Header --}}
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
                        <h3 class="text-white font-bold text-[15px] m-0 mb-[2px]">Tambah Jadwal Belajar</h3>
                        <p class="text-[rgba(255,255,255,0.5)] text-[11px] m-0">Isi data jadwal belajar baru</p>
                    </div>
                </div>

                <button type="button" onclick="closeCreateModal()"
                    class="w-[30px] h-[30px] rounded-lg bg-[rgba(255,255,255,0.12)] hover:bg-[rgba(255,255,255,0.22)] border-none cursor-pointer flex items-center justify-center relative transition-all duration-200">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Gold accent bar --}}
            <div class="h-[3px]" style="background: linear-gradient(90deg,#E8930A,#F5A623,#E8930A);"></div>

            {{-- Body --}}
            <form action="{{ route('jadwalbelajar.store') }}" id="createFormAction" method="POST"
                  class="p-6 flex flex-col gap-[18px] max-h-[75vh] overflow-y-auto">
                @csrf
                <input type="hidden" name="hari"   id="createHari">
                <input type="hidden" name="id_jam" id="createIdJam">

                {{-- Hari (readonly display) --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">Hari</label>
                    <div class="relative">
                        <span class="absolute left-[13px] top-1/2 -translate-y-1/2 pointer-events-none flex items-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </span>
                        <input type="text" id="createHariDisplay" readonly
                               class="w-full rounded-[10px] border border-gray-200 py-[10px] pl-[40px] pr-[14px] text-[14px] text-gray-400 bg-gray-50 outline-none cursor-not-allowed">
                    </div>
                </div>

                {{-- Jam Belajar (readonly display) --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">Jam Belajar</label>
                    <div class="relative">
                        <span class="absolute left-[13px] top-1/2 -translate-y-1/2 pointer-events-none flex items-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </span>
                        <input type="text" id="createJamDisplay" readonly
                               class="w-full rounded-[10px] border border-gray-200 py-[10px] pl-[40px] pr-[14px] text-[14px] text-gray-400 bg-gray-50 outline-none cursor-not-allowed">
                    </div>
                </div>

                {{-- Kelas --}}
                <div class="flex flex-col gap-[7px]">
                    <div class="flex items-center justify-between">
                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        {{-- Badge muncul ketika kelas di-lock dari filter --}}
                        <span id="createKelasBadge"
                              class="hidden items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 border border-amber-200">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Dari Filter
                        </span>
                    </div>
                    <select name="id_kelas" id="createIdKelas"
                        class="w-full rounded-[10px] border py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white
                        {{ $errors->has('id_kelas') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ old('id_kelas') == $k->id ? 'selected' : '' }}>
                                {{ trim(($k->Tingkatan->nama_tingkatan ?? '') . ' ' . ($k->Jurusan->nama_jurusan ?? '') . ' ' . ($k->Bagian->nama_bagian ?? '')) }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('id_kelas'))
                        <p class="flex items-center gap-1 text-xs text-red-600">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $errors->first('id_kelas') }}
                        </p>
                    @endif
                </div>

                {{-- Guru Mata Pelajaran --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">Guru Mata Pelajaran</label>
                    <select name="id_guru_mapel" id="createIdGuruMapel"
                        class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                        <option value="">-- Pilih Guru (opsional) --</option>
                        @foreach($guruMapelList as $guru)
                            <option value="{{ $guru->id }}"
                                    data-mapel-id="{{ $guru->Mapel->id ?? '' }}"
                                    data-mapel-nama="{{ $guru->Mapel->nama_mapel ?? '' }}"
                                    {{ old('id_guru_mapel') == $guru->id ? 'selected' : '' }}>
                                {{ ($guru->Guru->nama_lengkap ?? '') . ' — ' . ($guru->Mapel->nama_mapel ?? '') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Mata Pelajaran --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                        Mata Pelajaran <span class="text-gray-400 font-normal normal-case tracking-normal">(jika tanpa guru)</span>
                    </label>
                    <div class="relative">
                        <select name="id_mapel" id="createIdMapel"
                            class="w-full rounded-[10px] border border-gray-200 py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white">
                            <option value="">-- Pilih Mapel (opsional) --</option>
                            @foreach($mapelList as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('id_mapel') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        <span id="createMapelBadge"
                              class="hidden absolute right-[13px] top-1/2 -translate-y-1/2 text-[10px] font-bold px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 pointer-events-none">
                            Otomatis
                        </span>
                    </div>
                    <p id="createMapelHint" class="hidden items-center gap-1 text-[11px] text-blue-500">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        Terisi otomatis dari mapel guru yang dipilih.
                    </p>
                </div>

                {{-- Nama Kegiatan --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                        Nama Kegiatan <span class="text-gray-400 font-normal normal-case tracking-normal">(jika bukan mapel)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-[13px] top-1/2 -translate-y-1/2 pointer-events-none flex items-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </span>
                        <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}"
                               placeholder="cth: Istirahat, Upacara..."
                               class="w-full rounded-[10px] border py-[10px] pl-[40px] pr-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white
                               {{ $errors->has('nama_kegiatan') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                    </div>
                    @if ($errors->has('nama_kegiatan'))
                        <p class="flex items-center gap-1 text-xs text-red-600">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $errors->first('nama_kegiatan') }}
                        </p>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-[10px] pt-[6px] border-t border-gray-100">
                    <button type="button" onclick="closeCreateModal()"
                        class="inline-flex items-center gap-[6px] px-5 py-[9px] text-[13.5px] font-semibold bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-[10px] cursor-pointer transition-all duration-200">
                        Batal
                    </button>
                    <button type="submit" id="createSubmitBtn"
                        class="inline-flex items-center gap-[6px] px-[22px] py-[9px] text-[13.5px] font-bold text-white border-none rounded-[10px] cursor-pointer transition-all duration-200 shadow-[0_2px_8px_rgba(107,26,43,0.25)] disabled:opacity-60 disabled:cursor-not-allowed hover:opacity-90"
                        style="background: linear-gradient(135deg,#6B1A2B,#9B3045);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
function syncMapelFromGuru() {
    const guruSelect  = document.getElementById('createIdGuruMapel');
    const mapelSelect = document.getElementById('createIdMapel');
    const badge       = document.getElementById('createMapelBadge');
    const hint        = document.getElementById('createMapelHint');
    const selectedOpt = guruSelect.options[guruSelect.selectedIndex];
    const mapelId     = selectedOpt?.dataset?.mapelId ?? '';

    if (guruSelect.value && mapelId) {
        mapelSelect.value = mapelId;
        mapelSelect.classList.add('pointer-events-none', 'text-gray-400', 'cursor-not-allowed');
        badge.classList.remove('hidden');
        hint.classList.remove('hidden');
        hint.classList.add('flex');
    } else {
        mapelSelect.value = '';
        mapelSelect.classList.remove('pointer-events-none', 'text-gray-400', 'cursor-not-allowed');
        badge.classList.add('hidden');
        hint.classList.add('hidden');
        hint.classList.remove('flex');
    }
}

document.getElementById('createIdGuruMapel')?.addEventListener('change', syncMapelFromGuru);

document.addEventListener('DOMContentLoaded', () => {
    syncMapelFromGuru();

    const createForm = document.getElementById('createFormAction');
    const createBtn  = document.getElementById('createSubmitBtn');
    if (createForm && createBtn) {
        createForm.addEventListener('submit', () => {
            createBtn.disabled = true;
            createBtn.innerHTML = `
                <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                Menyimpan...
            `;
        });
    }
});
</script>
@endpush