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
                        <h3 class="text-white font-semibold text-sm tracking-wide">Tambah Bagian</h3>
                        <p class="text-blue-200 text-[11px]">Isi data unit/divisi baru</p>
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
            <form action="{{ route('bagian.store') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf

                {{-- Nama Bagian --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Nama Bagian <span class="text-red-400">*</span>
                    </label>
                    <input type="text"
                           name="nama_bagian"
                           value="{{ old('nama_bagian') }}"
                           placeholder="Contoh: HRD, Keuangan, IT..."
                           class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                  placeholder-slate-300
                                  focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B]
                                  transition
                                  @error('nama_bagian') border-red-400 bg-red-50 @else border-slate-200 @enderror">
                    @error('nama_bagian')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Deskripsi
                        <span class="normal-case font-normal text-slate-400 tracking-normal ml-1">(opsional)</span>
                    </label>
                    <textarea name="deskripsi"
                              rows="3"
                              placeholder="Deskripsi singkat mengenai bagian ini..."
                              class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                     placeholder-slate-300 resize-none
                                     focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B]
                                     transition
                                     @error('deskripsi') border-red-400 bg-red-50 @else border-slate-200 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
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
                                   bg-[#C8992A] hover:bg-[#b5861f] text-white
                                   rounded-lg transition shadow-sm shadow-amber-900/20">
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