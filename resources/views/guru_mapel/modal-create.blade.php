<div id="modalCreate" style="display:none; position:fixed; inset:0; z-index:9999;">

    {{-- Overlay --}}
    <div id="overlayCreate"
         style="position:absolute; inset:0; background:rgba(10,25,60,0.55); backdrop-filter:blur(3px);">
    </div>

    {{-- Dialog wrapper --}}
    <div style="position:relative; z-index:10; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:1rem;">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden
                    ring-1 ring-slate-200">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4
                        bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-md bg-white/15 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Tambah Guru Mapel</h3>
                        <p class="text-blue-200 text-[11px]">Isi data penugasan guru ke mapel</p>
                    </div>
                </div>
                <button type="button" id="closeCreate"
                        class="w-7 h-7 flex items-center justify-center rounded-lg
                               bg-white/10 hover:bg-white/25 text-white transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <form action="{{ route('guru_mapel.store') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf

                {{-- Mapel --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Mata Pelajaran <span class="text-red-400">*</span>
                    </label>
                    <select name="id_mapel"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B]
                                   transition
                                   @error('id_mapel') border-red-400 bg-red-50 @else border-slate-200 @enderror">
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}" {{ old('id_mapel') == $mapel->id ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_mapel')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Guru --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Guru <span class="text-red-400">*</span>
                    </label>
                    <select name="id_guru"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B]
                                   transition
                                   @error('id_guru') border-red-400 bg-red-50 @else border-slate-200 @enderror">
                        <option value="">Pilih Guru</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ old('id_guru') == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_guru')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Kelas <span class="text-red-400">*</span>
                    </label>
                    <select name="id_kelas"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B]
                                   transition
                                   @error('id_kelas') border-red-400 bg-red-50 @else border-slate-200 @enderror">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $kls)
                            <option value="{{ $kls->id }}" {{ old('id_kelas') == $kls->id ? 'selected' : '' }}>
                                {{ $kls->nama_kelas }}
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

                {{-- Semester --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Semester <span class="text-red-400">*</span>
                    </label>
                    <select name="id_semester"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B]
                                   transition
                                   @error('id_semester') border-red-400 bg-red-50 @else border-slate-200 @enderror">
                        <option value="">Pilih Semester</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ old('id_semester') == $semester->id ? 'selected' : '' }}>
                                {{ $semester->nama_semester }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_semester')
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
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium
                                   bg-slate-100 hover:bg-slate-200 text-slate-600
                                   rounded-lg transition border border-slate-200">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold
                                   bg-[#1B3A6B] hover:bg-[#0F2145] text-white
                                   rounded-lg transition shadow-md">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>