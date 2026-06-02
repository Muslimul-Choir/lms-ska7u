{{-- Modal Edit Mapel --}}
<div id="modalEdit" style="display:none; position:fixed; inset:0; z-index:999; align-items:center; justify-content:center;">

    {{-- Overlay --}}
    <div id="overlayEdit"
         style="position:absolute; inset:0; background:rgba(45,8,16,0.55); backdrop-filter:blur(4px);"
         onclick="closeEditModal()">
    </div>

    {{-- Dialog --}}
    <div style="position:relative; z-index:10; width:100%; max-width:520px; margin:1rem;">
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
                        <h3 style="color:#fff; font-weight:700; font-size:15px; margin:0 0 2px;">Edit Mapel</h3>
                        <p style="color:rgba(255,255,255,0.5); font-size:11px; margin:0;">Perbarui data mata pelajaran</p>
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
            <form id="formEdit" method="POST" enctype="multipart/form-data"
                  style="padding:24px; display:flex; flex-direction:column; gap:18px;">
                @csrf
                @method('PUT')

                {{-- Kode Mapel --}}
                <div>
                    <label style="display:block; font-size:11.5px; font-weight:700; color:#6B7280; text-transform:uppercase; letter-spacing:.55px; margin-bottom:7px;">
                        Kode Mapel <span style="color:#EF4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:13px; top:50%; transform:translateY(-50%); pointer-events:none; display:flex; align-items:center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </span>
                        <input type="text"
                               id="editKodeMapel"
                               name="kode_mapel"
                               placeholder="Contoh: MTK, IPA, IPS..."
                               style="width:100%; padding:10px 14px 10px 40px; border:1.5px solid #E5E7EB; border-radius:10px; font-size:14px; color:#111827; background:#F9FAFB; outline:none; box-sizing:border-box; transition:border-color .2s, box-shadow .2s;"
                               onfocus="this.style.borderColor='#E8930A'; this.style.boxShadow='0 0 0 3px rgba(232,147,10,0.13)'; this.style.background='#fff';"
                               onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'; this.style.background='#F9FAFB';">
                    </div>
                </div>

                {{-- Nama Mapel --}}
                <div>
                    <label style="display:block; font-size:11.5px; font-weight:700; color:#6B7280; text-transform:uppercase; letter-spacing:.55px; margin-bottom:7px;">
                        Nama Mapel <span style="color:#EF4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:13px; top:50%; transform:translateY(-50%); pointer-events:none; display:flex; align-items:center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </span>
                        <input type="text"
                               id="editNamaMapel"
                               name="nama_mapel"
                               placeholder="Contoh: Matematika, Bahasa Indonesia..."
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
                              placeholder="Deskripsi singkat mata pelajaran..."
                              style="width:100%; padding:10px 14px; border:1.5px solid #E5E7EB; border-radius:10px; font-size:14px; color:#111827; background:#F9FAFB; outline:none; resize:none; box-sizing:border-box; font-family:inherit; transition:border-color .2s, box-shadow .2s;"
                              onfocus="this.style.borderColor='#E8930A'; this.style.boxShadow='0 0 0 3px rgba(232,147,10,0.13)'; this.style.background='#fff';"
                              onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'; this.style.background='#F9FAFB';"></textarea>
                </div>

                {{-- Foto --}}
                <div>
                    <label style="display:block; font-size:11.5px; font-weight:700; color:#6B7280; text-transform:uppercase; letter-spacing:.55px; margin-bottom:7px;">
                        Foto
                        <span style="font-weight:400; color:#9CA3AF; text-transform:none; letter-spacing:0;">(opsional)</span>
                    </label>

                    {{-- Preview foto saat ini --}}
                    <div id="editFotoPreviewWrap" style="display:none; margin-bottom:10px;">
                        <img id="editFotoPreview"
                             src=""
                             alt="Foto Mapel"
                             style="width:80px; height:80px; object-fit:cover; border-radius:10px; border:2px solid #E5E7EB;">
                        <p style="font-size:11px; color:#9CA3AF; margin:4px 0 0;">Foto saat ini</p>
                    </div>

                    <div style="border:1.5px dashed #E5E7EB; border-radius:10px; padding:14px 16px; background:#F9FAFB; display:flex; align-items:center; gap:12px; transition:border-color .2s;"
                         onmouseover="this.style.borderColor='#E8930A'"
                         onmouseout="this.style.borderColor='#E5E7EB'">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <div style="flex:1;">
                            <input type="file"
                                   name="foto"
                                   accept="image/*"
                                   style="width:100%; font-size:13px; color:#374151; cursor:pointer; outline:none; border:none; background:transparent;">
                            <p style="font-size:11px; color:#9CA3AF; margin:3px 0 0;">Format: JPG, PNG, GIF. Maks 2MB. Kosongkan jika tidak ingin mengubah.</p>
                        </div>
                    </div>
                </div>

                {{-- ── Footer Buttons ── --}}
                <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; padding-top:6px; border-top:1px solid #F3F4F6;">
                    <button type="button" onclick="closeEditModal()"
                            style="display:inline-flex; align-items:center; gap:6px; padding:9px 20px; font-size:13.5px; font-weight:600; background:#F9FAFB; color:#374151; border:1.5px solid #E5E7EB; border-radius:10px; cursor:pointer; transition:background .2s;"
                            onmouseover="this.style.background='#F3F4F6'"
                            onmouseout="this.style.background='#F9FAFB'">
                        Batal
                    </button>
                    <button type="submit" id="submitEditBtn"
                    class="inline-flex items-center gap-[6px] px-[22px] py-[9px] text-[13.5px] font-bold text-white border-none rounded-[10px] cursor-pointer transition-all duration-200 shadow-[0_2px_8px_rgba(107,26,43,0.25)] disabled:opacity-60 disabled:cursor-not-allowed hover:opacity-90"
                        style="background: linear-gradient(135deg,#6B1A2B,#9B3045);">
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
function openEditModal(id, kodeMapel, namaMapel, deskripsi, fotoUrl) {
    var m = document.getElementById('modalEdit');
    document.getElementById('formEdit').action    = '/mapel/' + id;
    document.getElementById('editKodeMapel').value = kodeMapel  || '';
    document.getElementById('editNamaMapel').value = namaMapel  || '';
    document.getElementById('editDeskripsi').value = deskripsi  || '';

    var previewWrap = document.getElementById('editFotoPreviewWrap');
    var previewImg  = document.getElementById('editFotoPreview');
    if (fotoUrl) {
        previewImg.src        = fotoUrl;
        previewWrap.style.display = 'block';
    } else {
        previewWrap.style.display = 'none';
    }

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

 // CONFIRM UPDATE
        document.addEventListener('DOMContentLoaded', () => {
            const editForm = document.getElementById('formEdit');
            const submitBtn = document.getElementById('submitEditBtn');

            if (editForm && submitBtn) {
                editForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    showConfirmUpdate().then((result) => {
                        if (result.isConfirmed) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = `
                                <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                    </svg>
                                    Menyimpan...
                                `;
                            editForm.submit();
                        }
                    });
                });
            }
        });
</script>