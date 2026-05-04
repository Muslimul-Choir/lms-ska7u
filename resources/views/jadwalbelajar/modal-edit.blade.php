<div id="modalEdit" style="display:none; position:fixed; inset:0; z-index:9999;">

    {{-- Overlay --}}
    <div id="overlayEdit"
         style="position:absolute; inset:0; background:rgba(10,25,60,0.55); backdrop-filter:blur(3px);">
    </div>

    {{-- Dialog wrapper --}}
    <div style="position:relative; z-index:10; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:1rem;">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden ring-1 ring-slate-200">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-[#7A5500] to-[#C8992A]">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-md bg-white/15 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Edit Jadwal Belajar</h3>
                        <p class="text-amber-100 text-[11px]">Perbarui data jadwal belajar</p>
                    </div>
                </div>
                <button type="button" id="closeEdit"
                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/25 text-white transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Notice bar --}}
            <div class="flex items-center gap-2 px-6 py-2.5 bg-amber-50 border-b border-amber-100">
                <svg class="w-3.5 h-3.5 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-amber-700 text-[11px] font-medium">Perubahan akan langsung disimpan ke database.</p>
            </div>

            {{-- Modal Body --}}
            <form id="formEdit" action="" method="POST" class="px-6 py-5 space-y-4">
                @csrf
                @method('PUT')

                {{-- Hari --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Hari <span class="text-red-400">*</span>
                    </label>
                    <select id="editHari" name="hari"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#C8992A]/30 focus:border-[#C8992A] transition">
                        <option value="">-- Pilih Hari --</option>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                            <option value="{{ $h }}">{{ $h }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Jam Belajar --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Jam Belajar <span class="text-red-400">*</span>
                    </label>
                    <select id="editIdJam" name="id_jam"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#C8992A]/30 focus:border-[#C8992A] transition">
                        <option value="">-- Pilih Jam --</option>
                        @foreach($jamList as $jam)
                            <option value="{{ $jam->id }}">{{ $jam->jam_mulai }} – {{ $jam->jam_selesai }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Kelas <span class="text-red-400">*</span>
                    </label>
                    <select id="editIdKelas" name="id_kelas"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#C8992A]/30 focus:border-[#C8992A] transition">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}">
                                {{ trim(($k->Tingkatan->nama_tingkatan ?? '') . ' ' . ($k->Jurusan->nama_jurusan ?? '') . ' ' . ($k->Bagian->nama_bagian ?? '')) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Guru Mata Pelajaran --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Guru Mata Pelajaran
                    </label>
                    <select id="editIdGuruMapel" name="id_guru_mapel"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#C8992A]/30 focus:border-[#C8992A] transition">
                        <option value="">-- Pilih Guru (opsional) --</option>
                        @foreach($guruMapelList as $guru)
                            {{-- Simpan id_mapel sebagai data attribute, sama seperti modal Create --}}
                            <option value="{{ $guru->id }}"
                                    data-mapel-id="{{ $guru->Mapel->id ?? '' }}"
                                    data-mapel-nama="{{ $guru->Mapel->nama_mapel ?? '' }}">
                                {{ ($guru->Guru->nama_lengkap ?? '') . ' — ' . ($guru->Mapel->nama_mapel ?? '') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Mata Pelajaran (otomatis terisi dari guru mapel) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Mata Pelajaran
                        <span class="text-slate-400 normal-case font-normal tracking-normal">(jika tanpa guru)</span>
                    </label>
                    {{-- Wrapper posisi relatif untuk badge "otomatis" --}}
                    <div class="relative">
                        <select id="editIdMapel" name="id_mapel"
                                class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700 bg-white
                                       focus:outline-none focus:ring-2 focus:ring-[#C8992A]/30 focus:border-[#C8992A] transition
                                       border-slate-200">
                            <option value="">-- Pilih Mapel (opsional) --</option>
                            @foreach($mapelList as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                            @endforeach
                        </select>

                        {{-- Badge muncul saat mapel dikunci oleh guru --}}
                        <span id="editMapelBadge"
                              class="hidden absolute right-2 top-1/2 -translate-y-1/2
                                     text-[10px] font-semibold px-1.5 py-0.5 rounded
                                     bg-blue-100 text-blue-700 pointer-events-none">
                            Otomatis
                        </span>
                    </div>

                    {{-- Info hint --}}
                    <p id="editMapelHint" class="hidden mt-1.5 text-[11px] text-blue-500 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Terisi otomatis dari mapel guru yang dipilih. Kosongkan pilihan guru untuk mengubah.
                    </p>
                </div>

                {{-- Nama Kegiatan --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Nama Kegiatan
                        <span class="text-slate-400 normal-case font-normal tracking-normal">(jika bukan mapel)</span>
                    </label>
                    <input type="text" id="editNamaKegiatan" name="nama_kegiatan"
                           placeholder="cth: Istirahat, Upacara..."
                           class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 bg-white
                                  focus:outline-none focus:ring-2 focus:ring-[#C8992A]/30 focus:border-[#C8992A] transition">
                </div>

                {{-- Divider --}}
                <div class="border-t border-slate-100"></div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-2 pt-1">
                    <button type="button" id="cancelEdit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition border border-slate-200">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold bg-[#1B3A6B] hover:bg-[#0F2145] text-white rounded-lg transition shadow-sm shadow-blue-900/20">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Update
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    /**
     * Sinkronisasi select id_mapel berdasarkan pilihan guru mapel — versi Edit.
     * Logika identik dengan syncMapelFromGuru() pada modal Create.
     */
    function syncMapelFromGuruEdit() {
        const guruSelect  = document.getElementById('editIdGuruMapel');
        const mapelSelect = document.getElementById('editIdMapel');
        const badge       = document.getElementById('editMapelBadge');
        const hint        = document.getElementById('editMapelHint');

        const selectedOpt = guruSelect.options[guruSelect.selectedIndex];
        const mapelId     = selectedOpt?.dataset?.mapelId ?? '';

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
            mapelSelect.disabled = false;
            mapelSelect.classList.remove('bg-slate-50', 'cursor-not-allowed', 'text-slate-400');
            mapelSelect.classList.add('bg-white', 'text-slate-700');
            badge.classList.add('hidden');
            hint.classList.add('hidden');
        }
    }

    // Jalankan setiap kali guru mapel berubah
    document.getElementById('editIdGuruMapel')
        ?.addEventListener('change', syncMapelFromGuruEdit);

    /**
     * openModalEdit — dipanggil dari tombol edit di tabel.
     * @param {object} data — objek berisi semua field jadwal yang akan diedit
     * data: { id, hari, id_jam, id_kelas, id_guru_mapel, id_mapel, nama_kegiatan }
     */
    window.openModalEdit = function(data) {
        // Set action form ke route update
        document.getElementById('formEdit').action = `/jadwalbelajar/${data.id}`;

        // Isi field
        document.getElementById('editHari').value          = data.hari          ?? '';
        document.getElementById('editIdJam').value         = data.id_jam        ?? '';
        document.getElementById('editIdKelas').value       = data.id_kelas      ?? '';
        document.getElementById('editNamaKegiatan').value  = data.nama_kegiatan ?? '';

        // Set guru dulu, lalu jalankan sync agar mapel ikut terkunci jika perlu
        document.getElementById('editIdGuruMapel').value   = data.id_guru_mapel ?? '';
        syncMapelFromGuruEdit();

        // Jika guru tidak dipilih (atau guru tidak punya mapel), set mapel manual
        const mapelSelect = document.getElementById('editIdMapel');
        if (!mapelSelect.disabled) {
            mapelSelect.value = data.id_mapel ?? '';
        }

        document.getElementById('modalEdit').style.display = 'block';
    };

    // Tombol tutup modal
    document.getElementById('closeEdit')?.addEventListener('click',  () => document.getElementById('modalEdit').style.display = 'none');
    document.getElementById('cancelEdit')?.addEventListener('click', () => document.getElementById('modalEdit').style.display = 'none');
    document.getElementById('overlayEdit')?.addEventListener('click', () => document.getElementById('modalEdit').style.display = 'none');
</script>