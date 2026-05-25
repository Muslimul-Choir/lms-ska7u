<div id="modalEdit" style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center;">

    {{-- Overlay --}}
    <div id="overlayEdit"
         style="position:absolute; inset:0; background:rgba(45,8,16,0.55); backdrop-filter:blur(4px);"
         onclick="closeEditModal()">
    </div>

    {{-- Dialog --}}
    <div style="position:relative; z-index:10; width:100%; max-width:480px; margin:1rem;">
        <div style="background:#fff; border-radius:18px; box-shadow:0 24px 60px rgba(107,26,43,0.22), 0 4px 16px rgba(0,0,0,0.08); overflow:hidden; border:1px solid rgba(107,26,43,0.1);">

            {{-- ── Header ── --}}
            <div style="padding:18px 24px; background:linear-gradient(135deg,#6B1A2B 0%,#4A0F1E 55%,#2D0810 100%); display:flex; align-items:center; justify-content:space-between; position:relative; overflow:hidden;">
                <div style="position:absolute; width:120px; height:120px; border-radius:50%; top:-40px; right:10px; border:1.5px solid rgba(232,147,10,0.2); pointer-events:none;"></div>
                <div style="position:absolute; width:70px; height:70px; border-radius:50%; top:10px; right:70px; border:1.5px solid rgba(232,147,10,0.12); pointer-events:none;"></div>
                <div style="display:flex; align-items:center; gap:12px; position:relative;">
                    <div style="width:38px; height:38px; border-radius:10px; background:rgba(232,147,10,0.2); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F5A623" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 style="color:#fff; font-weight:700; font-size:15px; margin:0 0 2px;">Edit Pertemuan</h3>
                        <p style="color:rgba(255,255,255,0.5); font-size:11px; margin:0;">Perbarui data pertemuan</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditModal()"
                        style="width:30px; height:30px; border-radius:8px; background:rgba(255,255,255,0.12); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; position:relative;"
                        onmouseover="this.style.background='rgba(255,255,255,0.22)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- ── Gold accent bar ── --}}
            <div style="height:3px; background:linear-gradient(90deg,#E8930A,#F5A623,#E8930A);"></div>

            {{-- ── Notice bar ── --}}
            <div style="display:flex; align-items:center; gap:8px; padding:9px 24px; background:#FFFBEB; border-bottom:1px solid #FDE68A;">
                <svg width="14" height="14" viewBox="0 0 20 20" fill="#D97706" style="flex-shrink:0;">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p style="font-size:11.5px; color:#92400E; font-weight:500; margin:0;">Perubahan akan langsung disimpan ke database.</p>
            </div>

            {{-- ── Body ── --}}
            <form id="formEdit" action="" method="POST" style="padding:24px; display:flex; flex-direction:column; gap:18px;">
                @csrf
                @method('PUT')

                {{-- Jadwal Belajar --}}
                <div>
                    <label style="display:block; font-size:11.5px; font-weight:700; color:#6B7280; text-transform:uppercase; letter-spacing:.55px; margin-bottom:7px;">
                        Jadwal Belajar <span style="color:#EF4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:13px; top:50%; transform:translateY(-50%); pointer-events:none; display:flex; align-items:center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <select id="editIdJadwal" name="id_jadwal"
                                style="width:100%; padding:10px 36px 10px 40px; border:1.5px solid #E5E7EB; border-radius:10px; font-size:14px; color:#111827; background:#F9FAFB; outline:none; box-sizing:border-box; transition:border-color .2s, box-shadow .2s; appearance:none; cursor:pointer;"
                                onfocus="this.style.borderColor='#E8930A'; this.style.boxShadow='0 0 0 3px rgba(232,147,10,0.13)'; this.style.background='#fff';"
                                onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'; this.style.background='#F9FAFB';">
                            <option value="">-- Pilih Jadwal --</option>
                            @foreach(\App\Models\JadwalBelajar::all() as $jadwal)
                                <option value="{{ $jadwal->id }}">
                                    {{ $jadwal->nama_jadwal ?? 'Jadwal #' . $jadwal->id }}
                                </option>
                            @endforeach
                        </select>
                        <span style="position:absolute; right:13px; top:50%; transform:translateY(-50%); pointer-events:none;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></span>
                    </div>
                </div>

                {{-- Nomor Pertemuan --}}
                <div>
                    <label style="display:block; font-size:11.5px; font-weight:700; color:#6B7280; text-transform:uppercase; letter-spacing:.55px; margin-bottom:7px;">
                        Nomor Pertemuan <span style="color:#EF4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:13px; top:50%; transform:translateY(-50%); pointer-events:none; display:flex; align-items:center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                        </span>
                        <input type="number" id="editNomorPertemuan" name="nomor_pertemuan"
                               min="1" max="255" placeholder="Contoh: 1"
                               style="width:100%; padding:10px 14px 10px 40px; border:1.5px solid #E5E7EB; border-radius:10px; font-size:14px; color:#111827; background:#F9FAFB; outline:none; box-sizing:border-box; transition:border-color .2s, box-shadow .2s;"
                               onfocus="this.style.borderColor='#E8930A'; this.style.boxShadow='0 0 0 3px rgba(232,147,10,0.13)'; this.style.background='#fff';"
                               onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'; this.style.background='#F9FAFB';">
                    </div>
                </div>

                {{-- Tanggal --}}
                <div>
                    <label style="display:block; font-size:11.5px; font-weight:700; color:#6B7280; text-transform:uppercase; letter-spacing:.55px; margin-bottom:7px;">
                        Tanggal
                        <span style="font-weight:400; color:#9CA3AF; text-transform:none; letter-spacing:0;">(opsional)</span>
                    </label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:13px; top:50%; transform:translateY(-50%); pointer-events:none; display:flex; align-items:center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </span>
                        <input type="date" id="editTanggal" name="tanggal"
                               style="width:100%; padding:10px 14px 10px 40px; border:1.5px solid #E5E7EB; border-radius:10px; font-size:14px; color:#111827; background:#F9FAFB; outline:none; box-sizing:border-box; transition:border-color .2s, box-shadow .2s;"
                               onfocus="this.style.borderColor='#E8930A'; this.style.boxShadow='0 0 0 3px rgba(232,147,10,0.13)'; this.style.background='#fff';"
                               onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'; this.style.background='#F9FAFB';">
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label style="display:block; font-size:11.5px; font-weight:700; color:#6B7280; text-transform:uppercase; letter-spacing:.55px; margin-bottom:7px;">
                        Status <span style="color:#EF4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:13px; top:50%; transform:translateY(-50%); pointer-events:none; display:flex; align-items:center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </span>
                        <select id="editStatus" name="status"
                                style="width:100%; padding:10px 36px 10px 40px; border:1.5px solid #E5E7EB; border-radius:10px; font-size:14px; color:#111827; background:#F9FAFB; outline:none; box-sizing:border-box; transition:border-color .2s, box-shadow .2s; appearance:none; cursor:pointer;"
                                onfocus="this.style.borderColor='#E8930A'; this.style.boxShadow='0 0 0 3px rgba(232,147,10,0.13)'; this.style.background='#fff';"
                                onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'; this.style.background='#F9FAFB';">
                            <option value="dijadwalkan">Dijadwalkan</option>
                            <option value="berlangsung">Berlangsung</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                        <span style="position:absolute; right:13px; top:50%; transform:translateY(-50%); pointer-events:none;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></span>
                    </div>
                </div>

                {{-- ── Footer Buttons ── --}}
                <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; padding-top:6px; border-top:1px solid #F3F4F6;">
                    <button type="button" onclick="closeEditModal()"
                            style="display:inline-flex; align-items:center; gap:6px; padding:9px 20px; font-size:13.5px; font-weight:600; background:#F9FAFB; color:#374151; border:1.5px solid #E5E7EB; border-radius:10px; cursor:pointer; transition:background .2s;"
                            onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='#F9FAFB'">
                        Batal
                    </button>
                    <button type="submit"
                            style="display:inline-flex; align-items:center; gap:6px; padding:9px 22px; font-size:13.5px; font-weight:700; background:linear-gradient(135deg,#6B1A2B,#9B3045); color:#fff; border:none; border-radius:10px; cursor:pointer; transition:opacity .2s; box-shadow:0 2px 8px rgba(107,26,43,0.25);"
                            onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function closeEditModal() {
    document.getElementById('modalEdit').style.display = 'none';
    document.body.style.overflow = '';
}
function openEditModal(id, idJadwal, nomorPertemuan, tanggal, status) {
    document.getElementById('formEdit').action          = '/pertemuan/' + id;
    document.getElementById('editIdJadwal').value       = idJadwal        || '';
    document.getElementById('editNomorPertemuan').value = nomorPertemuan  || '';
    document.getElementById('editTanggal').value        = tanggal         || '';
    document.getElementById('editStatus').value         = status          || 'dijadwalkan';
    document.getElementById('modalEdit').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeEditModal();
});
</script>