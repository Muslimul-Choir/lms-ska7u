{{-- Modal Edit Mapel --}}
<div id="modalEdit" style="display:none; position:fixed; inset:0; z-index:9999;">

    {{-- Overlay --}}
    <div id="overlayEdit"
         style="position:absolute; inset:0; background:rgba(10,25,60,0.55); backdrop-filter:blur(3px);">
    </div>

    {{-- Dialog --}}
    <div style="position:relative; z-index:10; max-width:520px; margin:80px auto;">

        <div style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.2);">

            {{-- Header --}}
            <div style="background:linear-gradient(to right,#0F2145,#1B3A6B); padding:14px 18px; color:#fff;">
                <h2 style="font-size:14px; font-weight:600;">Edit Mapel</h2>
                <p style="font-size:11px; color:#cbd5e1;">Update data mata pelajaran</p>
            </div>

            {{-- Body --}}
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')

                <div style="padding:18px; display:flex; flex-direction:column; gap:12px;">

                    {{-- Kode Mapel --}}
                    <div>
                        <label style="font-size:12px; font-weight:600;">Kode Mapel</label>
                        <input type="text" id="editKodeMapel" name="kode_mapel"
                               style="width:100%; padding:8px; border:1px solid #e2e8f0; border-radius:8px;">
                    </div>

                    {{-- Nama Mapel --}}
                    <div>
                        <label style="font-size:12px; font-weight:600;">Nama Mapel</label>
                        <input type="text" id="editNamaMapel" name="nama_mapel"
                               style="width:100%; padding:8px; border:1px solid #e2e8f0; border-radius:8px;">
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label style="font-size:12px; font-weight:600;">Deskripsi</label>
                        <textarea id="editDeskripsi" name="deskripsi"
                                  style="width:100%; padding:8px; border:1px solid #e2e8f0; border-radius:8px;"></textarea>
                    </div>

                </div>

                {{-- Footer --}}
                <div style="padding:14px 18px; display:flex; justify-content:flex-end; gap:8px; background:#f8fafc;">

                    <button type="button" id="cancelEdit"
                            style="padding:8px 12px; background:#e2e8f0; border-radius:8px;">
                        Batal
                    </button>

                    <button type="submit"
                            style="padding:8px 12px; background:#1B3A6B; color:#fff; border-radius:8px;">
                        Update
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>