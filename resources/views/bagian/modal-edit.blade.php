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
                {{-- Deco circles --}}
                <div style="position:absolute; width:120px; height:120px; border-radius:50%; top:-40px; right:10px; border:1.5px solid rgba(232,147,10,0.2); pointer-events:none;"></div>
                <div style="position:absolute; width:70px;  height:70px;  border-radius:50%; top:10px;  right:70px; border:1.5px solid rgba(232,147,10,0.12); pointer-events:none;"></div>

                <div style="display:flex; align-items:center; gap:12px; position:relative;">
                    <div style="width:38px; height:38px; border-radius:10px; background:rgba(232,147,10,0.2); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F5A623" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 style="color:#fff; font-weight:700; font-size:15px; margin:0 0 2px;">Edit Bagian</h3>
                        <p style="color:rgba(255,255,255,0.5); font-size:11px; margin:0;">Perbarui data unit / divisi</p>
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
                <svg width="14" height="14" viewBox="0 0 20 20" fill="#D97706" flex-shrink="0">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p style="font-size:11.5px; color:#92400E; font-weight:500; margin:0;">Perubahan akan langsung disimpan ke database.</p>
            </div>

            {{-- ── Body ── --}}
            <form id="formEdit" action="" method="POST" style="padding:24px; display:flex; flex-direction:column; gap:18px;">
                @csrf
                @method('PUT')

                {{-- Nama Bagian --}}
                <div>
                    <label style="display:block; font-size:11.5px; font-weight:700; color:#6B7280; text-transform:uppercase; letter-spacing:.55px; margin-bottom:7px;">
                        Nama Bagian <span style="color:#EF4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:13px; top:50%; transform:translateY(-50%); pointer-events:none; display:flex; align-items:center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </span>
                        <input type="text"
                               id="editNamaBagian"
                               name="nama_bagian"
                               placeholder="Contoh: Lerning, Axio, Gamelab dll..."
                               style="width:100%; padding:10px 14px 10px 40px; border:1.5px solid #E5E7EB; border-radius:10px; font-size:14px; color:#111827; background:#F9FAFB; outline:none; box-sizing:border-box; transition:border-color .2s, box-shadow .2s;"
                               onfocus="this.style.borderColor='#E8930A'; this.style.boxShadow='0 0 0 3px rgba(232,147,10,0.13)'; this.style.background='#fff';"
                               onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'; this.style.background='#F9FAFB';">
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label style="display:block; font-size:11.5px; font-weight:700; color:#6B7280; text-transform:uppercase; letter-spacing:.55px; margin-bottom:7px;">
                        Deskripsi
                        <span style="font-weight:400; color:#9CA3AF; text-transform:none; letter-spacing:0;">(opsional)</span>
                    </label>
                    <textarea id="editDeskripsi"
                              name="deskripsi"
                              rows="3"
                              placeholder="Tuliskan deskripsi singkat mengenai bagian ini..."
                              style="width:100%; padding:10px 14px; border:1.5px solid #E5E7EB; border-radius:10px; font-size:14px; color:#111827; background:#F9FAFB; outline:none; resize:none; box-sizing:border-box; font-family:inherit; transition:border-color .2s, box-shadow .2s;"
                              onfocus="this.style.borderColor='#E8930A'; this.style.boxShadow='0 0 0 3px rgba(232,147,10,0.13)'; this.style.background='#fff';"
                              onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'; this.style.background='#F9FAFB';"></textarea>
                </div>

                {{-- ── Footer Buttons ── --}}
                <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; padding-top:6px; border-top:1px solid #F3F4F6;">
                    <button type="button" onclick="closeEditModal()"
                            style="display:inline-flex; align-items:center; gap:6px; padding:9px 20px; font-size:13.5px; font-weight:600; background:#F9FAFB; color:#374151; border:1.5px solid #E5E7EB; border-radius:10px; cursor:pointer; transition:background .2s;"
                            onmouseover="this.style.background='#F3F4F6'"
                            onmouseout="this.style.background='#F9FAFB'">
                        Batal
                    </button>
                    <button type="submit"
                            style="display:inline-flex; align-items:center; gap:6px; padding:9px 22px; font-size:13.5px; font-weight:700; background:linear-gradient(135deg,#6B1A2B,#9B3045); color:#fff; border:none; border-radius:10px; cursor:pointer; transition:opacity .2s; box-shadow:0 2px 8px rgba(107,26,43,0.25);"
                            onmouseover="this.style.opacity='.88'"
                            onmouseout="this.style.opacity='1'">
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
function openEditModal(id, namaBagian, deskripsi) {
    var m = document.getElementById('modalEdit');
    document.getElementById('formEdit').action = '/bagian/' + id;
    document.getElementById('editNamaBagian').value  = namaBagian  || '';
    document.getElementById('editDeskripsi').value   = deskripsi   || '';
    m.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    var m = document.getElementById('modalEdit');
    m.style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeEditModal();
});
</script>