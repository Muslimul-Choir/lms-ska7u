<div id="modalCreate" style="display:none; position:fixed; inset:0; z-index:9999;">

    {{-- Overlay --}}
    <div id="overlayCreate"
         style="position:absolute; inset:0; background:rgba(10,25,60,0.55); backdrop-filter:blur(3px);">
    </div>

    {{-- Dialog wrapper --}}
    <div style="position:relative; z-index:10; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:1rem;">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden ring-1 ring-slate-200">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-md bg-white/15 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Tambah Jadwal Belajar</h3>
                        <p class="text-blue-200 text-[11px]">Isi data jadwal belajar baru</p>
                    </div>
                </div>
                <button type="button" id="closeCreate"
                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/25 text-white transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <form action="{{ route('jadwalbelajar.store') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf

                {{-- Hidden fields diisi otomatis saat klik tombol + --}}
                <input type="hidden" name="hari"   id="createHari">
                <input type="hidden" name="id_jam" id="createIdJam">

                {{-- Hari (readonly, terisi otomatis) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Hari
                    </label>
                    <input type="text" id="createHariDisplay" readonly
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 cursor-not-allowed">
                </div>

                {{-- Jam Belajar (readonly, terisi otomatis) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Jam Belajar
                    </label>
                    <input type="text" id="createJamDisplay" readonly
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 cursor-not-allowed">
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Kelas <span class="text-red-400">*</span>
                    </label>
                    <select name="id_kelas" id="createIdKelas"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700 bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition
                                   @error('id_kelas') border-red-400 bg-red-50 @else border-slate-200 @enderror">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ old('id_kelas') == $k->id ? 'selected' : '' }}>
                                {{ trim(($k->Tingkatan->nama_tingkatan ?? '') . ' ' . ($k->Jurusan->nama_jurusan ?? '') . ' ' . ($k->Bagian->nama_bagian ?? '')) }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kelas')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Guru Mata Pelajaran --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Guru Mata Pelajaran
                    </label>
                    <select name="id_guru_mapel" id="createIdGuruMapel"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700 bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition
                                   @error('id_guru_mapel') border-red-400 bg-red-50 @else border-slate-200 @enderror">
                        <option value="">-- Pilih Guru (opsional) --</option>
                        @foreach($guruMapelList as $guru)
                            {{-- Simpan id_mapel sebagai data attribute --}}
                            <option value="{{ $guru->id }}"
                                    data-mapel-id="{{ $guru->Mapel->id ?? '' }}"
                                    data-mapel-nama="{{ $guru->Mapel->nama_mapel ?? '' }}"
                                    {{ old('id_guru_mapel') == $guru->id ? 'selected' : '' }}>
                                {{ ($guru->Guru->nama_lengkap ?? '') . ' — ' . ($guru->Mapel->nama_mapel ?? '') }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_guru_mapel')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Mata Pelajaran (otomatis terisi dari guru mapel) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Mata Pelajaran
                        <span class="text-slate-400 normal-case font-normal tracking-normal">(jika tanpa guru)</span>
                    </label>
                    {{-- Wrapper posisi relatif untuk badge "otomatis" --}}
                    <div class="relative">
                        <select name="id_mapel" id="createIdMapel"
                                class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700 bg-white
                                       focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition
                                       border-slate-200">
                            <option value="">-- Pilih Mapel (opsional) --</option>
                            @foreach($mapelList as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('id_mapel') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Badge muncul saat mapel dikunci oleh guru --}}
                        <span id="createMapelBadge"
                              class="hidden absolute right-2 top-1/2 -translate-y-1/2
                                     text-[10px] font-semibold px-1.5 py-0.5 rounded
                                     bg-blue-100 text-blue-700 pointer-events-none">
                            Otomatis
                        </span>
                    </div>

                    {{-- Info hint --}}
                    <p id="createMapelHint" class="hidden mt-1.5 text-[11px] text-blue-500 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Terisi otomatis dari mapel guru yang dipilih. Kosongkan pilihan guru untuk mengubah.
                    </p>
                </div>

                {{-- Nama Kegiatan (untuk Istirahat, Upacara, dll) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Nama Kegiatan
                        <span class="text-slate-400 normal-case font-normal tracking-normal">(jika bukan mapel)</span>
                    </label>
                    <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}"
                           placeholder="cth: Istirahat, Upacara..."
                           class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 bg-white
                                  focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition
                                  @error('nama_kegiatan') border-red-400 bg-red-50 @enderror">
                    @error('nama_kegiatan')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Divider --}}
                <div class="border-t border-slate-100"></div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-2 pt-1">
                    <button type="button" id="cancelCreate"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition border border-slate-200">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold bg-[#C8992A] hover:bg-[#b5861f] text-white rounded-lg transition shadow-sm shadow-amber-900/20">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    const _origOpenModalCreate = window.openModalCreate;
    window.openModalCreate = function(hari, idJam) {
        document.getElementById('createHari').value  = hari;
        document.getElementById('createIdJam').value = idJam;
        document.getElementById('createHariDisplay').value = hari;

        const jamMap = {
            @foreach($jamList as $jam)
                "{{ $jam->id }}": "{{ $jam->jam_mulai }} – {{ $jam->jam_selesai }}",
            @endforeach
        };
        document.getElementById('createJamDisplay').value = jamMap[idJam] ?? idJam;

        const idKelasFilter = "{{ $idKelas ?? '' }}";
        if (idKelasFilter) {
            document.getElementById('createIdKelas').value = idKelasFilter;
        }

        // Reset guru & mapel saat modal dibuka ulang
        document.getElementById('createIdGuruMapel').value = '';
        syncMapelFromGuru();

        document.getElementById('modalCreate').style.display = 'block';
    };

    /**
     * Sinkronisasi select id_mapel berdasarkan pilihan guru mapel.
     * - Jika guru dipilih dan punya mapel → set & lock select mapel
     * - Jika guru dikosongkan → unlock select mapel
     */
    function syncMapelFromGuru() {
        const guruSelect  = document.getElementById('createIdGuruMapel');
        const mapelSelect = document.getElementById('createIdMapel');
        const badge       = document.getElementById('createMapelBadge');
        const hint        = document.getElementById('createMapelHint');

        const selectedOpt = guruSelect.options[guruSelect.selectedIndex];
        const mapelId     = selectedOpt?.dataset?.mapelId ?? '';
        const mapelNama   = selectedOpt?.dataset?.mapelNama ?? '';

        if (guruSelect.value && mapelId) {
            // Guru dipilih dan punya data mapel → kunci & isi mapel
            mapelSelect.value    = mapelId;
            mapelSelect.disabled = true;
            mapelSelect.classList.add('bg-slate-50', 'cursor-not-allowed', 'text-slate-400');
            mapelSelect.classList.remove('bg-white', 'text-slate-700');
            badge.classList.remove('hidden');
            hint.classList.remove('hidden');
        } else {
            // Guru tidak dipilih atau tidak punya mapel → bebaskan pilihan
            mapelSelect.value    = '';
            mapelSelect.disabled = false;
            mapelSelect.classList.remove('bg-slate-50', 'cursor-not-allowed', 'text-slate-400');
            mapelSelect.classList.add('bg-white', 'text-slate-700');
            badge.classList.add('hidden');
            hint.classList.add('hidden');
        }
    }

    // Jalankan setiap kali guru mapel berubah
    document.getElementById('createIdGuruMapel')
        ?.addEventListener('change', syncMapelFromGuru);

    // Jalankan sekali saat halaman load (untuk kasus old() setelah validasi gagal)
    document.addEventListener('DOMContentLoaded', syncMapelFromGuru);
</script>