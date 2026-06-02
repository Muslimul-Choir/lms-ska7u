<div id="modalCreate" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5">

    {{-- Overlay --}}
    <div onclick="closeCreateModal()"
        class="absolute inset-0 bg-[rgba(45,8,16,0.55)] backdrop-blur-[4px]">
    </div>

    {{-- Dialog --}}
    <div class="relative z-10 w-full max-w-lg">
        <div class="bg-white rounded-[18px] shadow-[0_24px_60px_rgba(107,26,43,0.22),0_4px_16px_rgba(0,0,0,0.08)] overflow-hidden border border-[rgba(107,26,43,0.1)]">

            {{-- Header --}}
            <div class="px-6 py-[18px] flex items-center justify-between relative overflow-hidden"
                style="background: linear-gradient(135deg,#6B1A2B 0%,#4A0F1E 55%,#2D0810 100%);">
                <div class="absolute w-[120px] h-[120px] rounded-full top-[-40px] right-[10px] border border-[rgba(232,147,10,0.2)] pointer-events-none"></div>
                <div class="absolute w-[70px] h-[70px] rounded-full top-[10px] right-[70px] border border-[rgba(232,147,10,0.12)] pointer-events-none"></div>

                <div class="flex items-center gap-3 relative">
                    <div class="w-[38px] h-[38px] rounded-[10px] bg-[rgba(232,147,10,0.2)] flex items-center justify-center flex-shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F5A623" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-[15px] m-0 mb-[2px]">Tambah Semester</h3>
                        <p class="text-[rgba(255,255,255,0.5)] text-[11px] m-0">Isi data semester baru</p>
                    </div>
                </div>

                <button type="button" onclick="closeCreateModal()"
                    class="w-[30px] h-[30px] rounded-lg bg-[rgba(255,255,255,0.12)] hover:bg-[rgba(255,255,255,0.22)] border-none cursor-pointer flex items-center justify-center relative transition-all duration-200">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Gold accent bar --}}
            <div class="h-[3px]" style="background: linear-gradient(90deg,#E8930A,#F5A623,#E8930A);"></div>

            {{-- Body --}}
            <form action="{{ route('semester.store') }}" id="createFormAction" method="POST" class="p-6 flex flex-col gap-[18px]">
                @csrf
                <input type="hidden" name="_modal" value="create">

                {{-- Nama Semester --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                        Nama Semester <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-[13px] top-1/2 -translate-y-1/2 pointer-events-none flex items-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input type="text"
                            name="nama_semester"
                            value="{{ old('nama_semester') }}"
                            placeholder="Contoh: Semester 1, Ganjil..."
                            class="w-full rounded-[10px] border py-[10px] pl-[40px] pr-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white
                            {{ $errors->has('nama_semester') && old('_modal') === 'create' ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                    </div>
                    @if ($errors->has('nama_semester') && old('_modal') === 'create')
                        <p class="flex items-center gap-1 text-xs text-red-600">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $errors->first('nama_semester') }}
                        </p>
                    @endif
                </div>

                {{-- Tahun Ajaran --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                        Tahun Ajaran <span class="text-red-500">*</span>
                    </label>
                    <select name="id_tahun_ajaran"
                        class="w-full rounded-[10px] border py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white
                        {{ $errors->has('id_tahun_ajaran') && old('_modal') === 'create' ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach(\App\Models\TahunAjaran::all() as $tahun)
                            <option value="{{ $tahun->id }}" {{ old('id_tahun_ajaran') == $tahun->id ? 'selected' : '' }}>
                                {{ $tahun->nama_tahun }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('id_tahun_ajaran') && old('_modal') === 'create')
                        <p class="flex items-center gap-1 text-xs text-red-600">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $errors->first('id_tahun_ajaran') }}
                        </p>
                    @endif
                </div>

                {{-- Status Aktif --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">Status</label>
                    <label class="flex items-center gap-[10px] cursor-pointer px-[14px] py-[12px] bg-gray-50 border border-gray-200 rounded-[10px] transition-all duration-200 hover:border-[#E8930A] hover:bg-amber-50">
                        <input type="checkbox"
                            name="is_aktif"
                            value="1"
                            {{ old('is_aktif') ? 'checked' : '' }}
                            class="w-4 h-4 rounded accent-[#E8930A] cursor-pointer flex-shrink-0">
                        <div>
                            <span class="text-[13px] font-semibold text-gray-700 block">Semester Aktif</span>
                            <span class="text-[11px] text-gray-400">Jadikan sebagai semester yang sedang berjalan</span>
                        </div>
                    </label>
                    @if ($errors->has('is_aktif') && old('_modal') === 'create')
                        <p class="flex items-center gap-1 text-xs text-red-600">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $errors->first('is_aktif') }}
                        </p>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-[10px] pt-[6px] border-t border-gray-100">
                    <button type="button" onclick="closeCreateModal()"
                        class="inline-flex items-center gap-[6px] px-5 py-[9px] text-[13.5px] font-semibold bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-[10px] cursor-pointer transition-all duration-200">
                        Batal
                    </button>
                    <button type="submit" id="createSubmitBtn"
                        class="inline-flex items-center gap-[6px] px-[22px] py-[9px] text-[13.5px] font-bold text-white border-none rounded-[10px] cursor-pointer transition-all duration-200 shadow-[0_2px_8px_rgba(107,26,43,0.25)] disabled:opacity-60 disabled:cursor-not-allowed hover:opacity-90"
                        style="background: linear-gradient(135deg,#6B1A2B,#9B3045);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>