<div id="modalCreate" style="display:none; position:fixed; inset:0; z-index:9999;">
    
    {{-- Overlay --}}
    <div id="overlayCreate"
         class="absolute inset-0 bg-black/50 backdrop-blur-sm transition"></div>

    {{-- Modal --}}
    <div class="relative z-10 flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 
                        bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                
                <div>
                    <h3 class="text-white font-semibold text-sm tracking-wide">
                        Tambah Semester
                    </h3>
                    <p class="text-blue-200 text-xs mt-0.5">
                        Tambahkan data semester baru
                    </p>
                </div>

                <button type="button" id="closeCreate"
                        class="text-white/70 hover:text-white text-xl font-bold transition">
                    &times;
                </button>
            </div>

            {{-- Body --}}
            <form action="{{ route('semester.store') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf

                {{-- Field --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">
                        Nama Semester <span class="text-red-500">*</span>
                    </label>

                    <select name="nama_semester"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm 
                               text-slate-700 bg-white
                               focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 
                               focus:border-[#1B3A6B] transition
                               @error('nama_semester') border-red-400 @enderror">
                        
                        <option value="">-- Pilih Semester --</option>
                        <option value="Ganjil" {{ old('nama_semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('nama_semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>

                    @error('nama_semester')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action --}}
                <div class="flex items-center justify-end gap-2 pt-1">
                    <button type="button" id="cancelCreate"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium
                                   bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition border border-slate-200">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold
                                   bg-[#C8992A] hover:bg-[#b5861f] text-white rounded-lg transition shadow-sm shadow-amber-900/20">
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