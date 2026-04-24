{{-- Modal Create Mapel --}}
<div id="modalCreate" style="display:none; position:fixed; inset:0; z-index:9999;">

    {{-- Overlay --}}
    <div id="overlayCreate"
         style="position:absolute; inset:0; background:rgba(10,25,60,0.55); backdrop-filter:blur(3px);">
    </div>

    {{-- Dialog --}}
    <div style="position:relative; z-index:10; max-width:520px; margin:80px auto;">

        <div style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.2);">

            {{-- Header --}}
            <div style="background:linear-gradient(to right,#0F2145,#1B3A6B); padding:14px 18px; color:#fff;">
                <h2 style="font-size:14px; font-weight:600;">Tambah Mapel</h2>
                <p style="font-size:11px; color:#cbd5e1;">Form input mata pelajaran</p>
            </div>

            {{-- Body --}}
            <form action="{{ route('mapel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="padding:18px; display:flex; flex-direction:column; gap:12px;">

                    {{-- Kode Mapel --}}
                    <div>
                        <label style="font-size:12px; font-weight:600;">Kode Mapel</label>
                        <input type="text" name="kode_mapel"
                               style="width:100%; padding:8px; border:1px solid #e2e8f0; border-radius:8px;"
                               placeholder="Contoh: MTK">
                        @error('kode_mapel')
                            <small style="color:red;">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Nama Mapel --}}
                    <div>
                        <label style="font-size:12px; font-weight:600;">Nama Mapel</label>
                        <input type="text" name="nama_mapel"
                               style="width:100%; padding:8px; border:1px solid #e2e8f0; border-radius:8px;"
                               placeholder="Contoh: Matematika">
                        @error('nama_mapel')
                            <small style="color:red;">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label style="font-size:12px; font-weight:600;">Deskripsi</label>
                        <textarea name="deskripsi"
                                  style="width:100%; padding:8px; border:1px solid #e2e8f0; border-radius:8px;"
                                  placeholder="Deskripsi mapel"></textarea>
                    </div>

                    {{-- Foto --}}
                    <div>
                        <label style="font-size:12px; font-weight:600;">Foto</label>
                        <input type="file" name="foto" accept="image/*"
                               style="width:100%; padding:8px; border:1px solid #e2e8f0; border-radius:8px;">
                        <small style="color:#64748b; font-size:11px;">Format: JPG, PNG, GIF. Max: 2MB</small>
                    </div>

                </div>

                {{-- Footer --}}
                <div style="padding:14px 18px; display:flex; justify-content:flex-end; gap:8px; background:#f8fafc;">

                    <button type="button" id="cancelCreate"
                            style="padding:8px 12px; background:#e2e8f0; border-radius:8px;">
                        Batal
                    </button>

                    <button type="submit"
                            style="padding:8px 12px; background:#C8992A; color:#fff; border-radius:8px;">
                        Simpan
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>