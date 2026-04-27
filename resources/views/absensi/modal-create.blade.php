<div id="modalCreate" style="display:none; position:fixed; inset:0; z-index:9999;">

    <div id="overlayCreate"
         style="position:absolute; inset:0; background:rgba(10,25,60,0.55); backdrop-filter:blur(3px);">
    </div>

    <div style="position:relative; z-index:10; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden ring-1 ring-slate-200">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-md bg-white/15 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Tambah Absensi</h3>
                        <p class="text-blue-200 text-[11px]">Isi data kehadiran siswa</p>
                    </div>
                </div>
                <button type="button" id="closeCreate"
                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/25 text-white transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <form action="{{ route('absensi.store') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf

                {{-- Pertemuan --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Pertemuan <span class="text-red-400">*</span>
                    </label>
                    <select name="id_pertemuan"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition
                                   @error('id_pertemuan') border-red-400 bg-red-50 @else border-slate-200 @enderror">
                        <option value="">-- Pilih Pertemuan --</option>
                        @foreach(\App\Models\Pertemuan::all() as $pertemuan)
                            <option value="{{ $pertemuan->id }}" {{ old('id_pertemuan') == $pertemuan->id ? 'selected' : '' }}>
                                Pertemuan {{ $pertemuan->nomor_pertemuan }}
                                @if($pertemuan->tanggal) — {{ \Carbon\Carbon::parse($pertemuan->tanggal)->format('d M Y') }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('id_pertemuan')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Siswa --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Siswa <span class="text-red-400">*</span>
                    </label>
                    <select name="id_siswa"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition
                                @error('id_siswa') border-red-400 bg-red-50 @else border-slate-200 @enderror">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach(\App\Models\Siswa::all() as $siswa)
                            <option value="{{ $siswa->id }}" {{ old('id_siswa') == $siswa->id ? 'selected' : '' }}>
                                {{ $siswa->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_siswa')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Status <span class="text-red-400">*</span>
                    </label>
                    <div class="grid grid-cols-4 gap-2">

                        {{-- Hadir --}}
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="hadir"
                                {{ old('status', 'hadir') == 'hadir' ? 'checked' : '' }}
                                class="peer sr-only">
                            <div class="text-center py-2 rounded-lg border-2 text-xs font-bold uppercase tracking-wide transition
                                        border-slate-200 text-slate-400
                                        peer-checked:border-green-400 peer-checked:bg-green-50 peer-checked:text-green-700">
                                Hadir
                            </div>
                        </label>

                        {{-- Izin --}}
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="izin"
                                {{ old('status', 'hadir') == 'izin' ? 'checked' : '' }}
                                class="peer sr-only">
                            <div class="text-center py-2 rounded-lg border-2 text-xs font-bold uppercase tracking-wide transition
                                        border-slate-200 text-slate-400
                                        peer-checked:border-blue-400 peer-checked:bg-blue-50 peer-checked:text-blue-700">
                                Izin
                            </div>
                        </label>

                        {{-- Sakit --}}
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="sakit"
                                {{ old('status', 'hadir') == 'sakit' ? 'checked' : '' }}
                                class="peer sr-only">
                            <div class="text-center py-2 rounded-lg border-2 text-xs font-bold uppercase tracking-wide transition
                                        border-slate-200 text-slate-400
                                        peer-checked:border-amber-400 peer-checked:bg-amber-50 peer-checked:text-amber-700">
                                Sakit
                            </div>
                        </label>

                        {{-- Alpha --}}
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="alpha"
                                {{ old('status', 'hadir') == 'alpha' ? 'checked' : '' }}
                                class="peer sr-only">
                            <div class="text-center py-2 rounded-lg border-2 text-xs font-bold uppercase tracking-wide transition
                                        border-slate-200 text-slate-400
                                        peer-checked:border-red-400 peer-checked:bg-red-50 peer-checked:text-red-700">
                                Alpha
                            </div>
                        </label>

                    </div>
                    @error('status')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Keterangan <span class="text-slate-300 font-normal normal-case tracking-normal">(opsional)</span>
                    </label>
                    <textarea name="keterangan" rows="3"
                              placeholder="Tambahkan keterangan jika ada..."
                              class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 placeholder-slate-300
                                     focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition resize-none
                                     @error('keterangan') border-red-400 bg-red-50 @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

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