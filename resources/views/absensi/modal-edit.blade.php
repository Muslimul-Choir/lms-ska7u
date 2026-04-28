<div id="modalEdit" style="display:none; position:fixed; inset:0; z-index:9999;">

    <div id="overlayEdit"
         style="position:absolute; inset:0; background:rgba(10,25,60,0.55); backdrop-filter:blur(3px);">
    </div>

    <div style="position:relative; z-index:10; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden ring-1 ring-slate-200">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-[#7A5500] to-[#C8992A]">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-md bg-white/15 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Edit Absensi</h3>
                        <p class="text-amber-100 text-[11px]">Perbarui data kehadiran siswa</p>
                    </div>
                </div>
                <button type="button" id="closeEdit"
                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/25 text-white transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Notice --}}
            <div class="flex items-center gap-2 px-6 py-2.5 bg-amber-50 border-b border-amber-100">
                <svg class="w-3.5 h-3.5 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-amber-700 text-[11px] font-medium">Perubahan akan langsung disimpan ke database.</p>
            </div>

            {{-- Body --}}
            <form id="formEdit" action="" method="POST" class="px-6 py-5 space-y-4">
                @csrf
                @method('PUT')

                {{-- Pertemuan --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Pertemuan <span class="text-red-400">*</span>
                    </label>
                    <select id="editIdPertemuan" name="id_pertemuan"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#C8992A]/30 focus:border-[#C8992A] transition">
                        <option value="">-- Pilih Pertemuan --</option>
                        @foreach(\App\Models\Pertemuan::all() as $pertemuan)
                            <option value="{{ $pertemuan->id }}">
                                Pertemuan {{ $pertemuan->nomor_pertemuan }}
                                @if($pertemuan->tanggal) — {{ \Carbon\Carbon::parse($pertemuan->tanggal)->format('d M Y') }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Siswa --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Siswa <span class="text-red-400">*</span>
                    </label>
                    <select id="editIdSiswa" name="id_siswa"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#C8992A]/30 focus:border-[#C8992A] transition">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach(\App\Models\Siswa::all() as $siswa)
                            <option value="{{ $siswa->id }}">
                                {{ $siswa->nama_lengkap }}  {{-- ✅ pakai nama_lengkap --}}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Status <span class="text-red-400">*</span>
                    </label>
                    <div class="grid grid-cols-4 gap-2">

                        {{-- Hadir --}}
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="hadir" class="peer sr-only edit-status-radio">
                            <div class="text-center py-2 rounded-lg border-2 text-xs font-bold uppercase tracking-wide transition
                                        border-slate-200 text-slate-400
                                        peer-checked:border-green-400 peer-checked:bg-green-50 peer-checked:text-green-700">
                                Hadir
                            </div>
                        </label>

                        {{-- Izin --}}
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="izin" class="peer sr-only edit-status-radio">
                            <div class="text-center py-2 rounded-lg border-2 text-xs font-bold uppercase tracking-wide transition
                                        border-slate-200 text-slate-400
                                        peer-checked:border-blue-400 peer-checked:bg-blue-50 peer-checked:text-blue-700">
                                Izin
                            </div>
                        </label>

                        {{-- Sakit --}}
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="sakit" class="peer sr-only edit-status-radio">
                            <div class="text-center py-2 rounded-lg border-2 text-xs font-bold uppercase tracking-wide transition
                                        border-slate-200 text-slate-400
                                        peer-checked:border-amber-400 peer-checked:bg-amber-50 peer-checked:text-amber-700">
                                Sakit
                            </div>
                        </label>

                        {{-- Alpha --}}
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="alpha" class="peer sr-only edit-status-radio">
                            <div class="text-center py-2 rounded-lg border-2 text-xs font-bold uppercase tracking-wide transition
                                        border-slate-200 text-slate-400
                                        peer-checked:border-red-400 peer-checked:bg-red-50 peer-checked:text-red-700">
                                Alpha
                            </div>
                        </label>

                    </div>
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Keterangan <span class="text-slate-300 font-normal normal-case tracking-normal">(opsional)</span>
                    </label>
                    <textarea id="editKeterangan" name="keterangan" rows="3"
                              placeholder="Tambahkan keterangan jika ada..."
                              class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 placeholder-slate-300
                                     focus:outline-none focus:ring-2 focus:ring-[#C8992A]/30 focus:border-[#C8992A] transition resize-none"></textarea>
                </div>

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

{{-- Script Edit Modal --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modalEdit  = document.getElementById('modalEdit');
    const closeEdit  = document.getElementById('closeEdit');
    const cancelEdit = document.getElementById('cancelEdit');
    const overlayEdit = document.getElementById('overlayEdit');

    // Buka modal & isi data
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            // Isi form
            document.getElementById('editIdPertemuan').value = this.dataset.id_pertemuan;
            document.getElementById('editIdSiswa').value     = this.dataset.id_siswa;
            document.getElementById('editKeterangan').value  = this.dataset.keterangan ?? '';
            document.getElementById('formEdit').action       = `/absensi/${this.dataset.id}`;

            // Set radio status
            const status = this.dataset.status;
            document.querySelectorAll('.edit-status-radio').forEach(radio => {
                radio.checked = (radio.value === status);
            });

            modalEdit.style.display = 'block';
        });
    });

    // Tutup modal
    function closeModal() {
        modalEdit.style.display = 'none';
    }

    closeEdit.addEventListener('click', closeModal);
    cancelEdit.addEventListener('click', closeModal);
    overlayEdit.addEventListener('click', closeModal);
});
</script>