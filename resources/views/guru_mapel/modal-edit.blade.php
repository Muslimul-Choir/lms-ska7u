<div id="modalEdit" class="hidden fixed inset-0 z-[999] flex items-center justify-center p-3 sm:p-5">

    {{-- Overlay --}}
    <div onclick="closeEditModal()"
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
                    <div id="editHeaderIconLocked" class="hidden w-[38px] h-[38px] rounded-[10px] bg-[rgba(156,163,175,0.25)] flex items-center justify-center flex-shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2.5">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                    </div>
                    <div id="editHeaderIconEdit" class="w-[38px] h-[38px] rounded-[10px] bg-[rgba(232,147,10,0.2)] flex items-center justify-center flex-shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F5A623" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 id="editModalTitle" class="text-white font-bold text-[15px] m-0 mb-[2px]">Edit Guru Mapel</h3>
                        <p id="editModalSubtitle" class="text-[rgba(255,255,255,0.5)] text-[11px] m-0">Perbarui data penugasan guru ke mapel</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditModal()"
                    class="w-[30px] h-[30px] rounded-lg bg-[rgba(255,255,255,0.12)] hover:bg-[rgba(255,255,255,0.22)] border-none cursor-pointer flex items-center justify-center relative transition-all duration-200">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Gold accent bar --}}
            <div class="h-[3px]" style="background: linear-gradient(90deg,#E8930A,#F5A623,#E8930A);"></div>

            {{-- Notice bar: LOCKED --}}
            <div id="editNoticeLocked" class="hidden flex items-start gap-3 px-6 py-[11px] bg-red-50 border-b border-red-200">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-[1px]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-red-700 text-[12px] font-semibold m-0 mb-[2px]">Data tidak dapat diubah</p>
                    <p class="text-red-600 text-[11.5px] m-0 leading-[1.5]">
                        Guru Mapel ini sudah digunakan di <strong>jadwal belajar</strong>, <strong>materi</strong>, atau <strong>kuis</strong>.
                        Hapus referensi tersebut terlebih dahulu untuk mengubah data ini.
                    </p>
                </div>
            </div>

            {{-- Notice bar: NORMAL --}}
            <div id="editNoticeNormal" class="flex items-center gap-2 px-6 py-[9px] bg-amber-50 border-b border-amber-200">
                <svg class="w-3.5 h-3.5 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-amber-800 text-[11.5px] font-medium m-0">
                    Satu guru dapat mengajar lebih dari satu mapel, namun kombinasi guru dan mapel harus unik.
                </p>
            </div>

            {{-- Body --}}
            <form id="editFormAction" action="" method="POST" class="p-6 flex flex-col gap-[16px]">
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="edit">
                <input type="hidden" id="edit_route" name="_edit_route" value="{{ old('_edit_route', '') }}">

                {{-- Mata Pelajaran --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                        Mata Pelajaran <span class="text-red-500">*</span>
                    </label>
                    <select id="edit_id_mapel" name="id_mapel"
                        class="w-full rounded-[10px] border py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 border-gray-200 outline-none cursor-pointer transition-all duration-200
                               focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white
                               {{ $errors->has('id_mapel') && old('_modal') === 'edit' ? 'border-red-300 bg-red-50' : '' }}">
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}"
                                {{ old('id_mapel', '') == $mapel->id && old('_modal') === 'edit' ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" id="edit_id_mapel_hidden" name="id_mapel_locked">
                    @if ($errors->has('id_mapel') && old('_modal') === 'edit')
                        <p class="flex items-center gap-1 text-xs text-red-600">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $errors->first('id_mapel') }}
                        </p>
                    @endif
                </div>

                {{-- Guru --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                        Guru <span class="text-red-500">*</span>
                    </label>

                    {{-- Unlocked: dropdown semua guru --}}
                    <select id="edit_id_guru" name="id_guru"
                        class="w-full rounded-[10px] border py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200
                               focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white
                               {{ $errors->has('id_guru') && old('_modal') === 'edit' ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                        <option value="">Pilih Guru</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}"
                                {{ old('id_guru', '') == $guru->id && old('_modal') === 'edit' ? 'selected' : '' }}>
                                {{ $guru->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Locked: display label + hidden input --}}
                    <div id="editGuruLockedDisplay" class="hidden w-full rounded-[10px] border border-gray-200 bg-gray-100 py-[10px] px-[14px] flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        <span id="edit_guru_label" class="text-[14px] text-gray-500 font-medium"></span>
                    </div>
                    <input type="hidden" id="edit_id_guru_locked" name="id_guru_locked">

                    @if ($errors->has('id_guru') && old('_modal') === 'edit')
                        <p class="flex items-center gap-1 text-xs text-red-600">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $errors->first('id_guru') }}
                        </p>
                    @endif
                </div>

                {{-- Semester --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                        Semester <span class="text-red-500">*</span>
                    </label>
                    <select id="edit_id_semester" name="id_semester"
                        class="w-full rounded-[10px] border py-[10px] px-[14px] text-[14px] outline-none transition-all duration-200
                               bg-gray-50 border-gray-200 cursor-pointer
                               focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white
                               {{ $errors->has('id_semester') && old('_modal') === 'edit' ? 'border-red-300 bg-red-50' : '' }}">
                        <option value="">Pilih Semester</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}"
                                {{ old('id_semester', '') == $semester->id && old('_modal') === 'edit' ? 'selected' : '' }}>
                                {{ $semester->nama_semester }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" id="edit_id_semester_hidden" name="id_semester_locked">
                    @if ($errors->has('id_semester') && old('_modal') === 'edit')
                        <p class="flex items-center gap-1 text-xs text-red-600">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $errors->first('id_semester') }}
                        </p>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-[10px] pt-[6px] border-t border-gray-100">
                    <button type="button" id="editCancelBtn" onclick="closeEditModal()"
                        class="inline-flex items-center gap-[6px] px-5 py-[9px] text-[13.5px] font-semibold bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-[10px] cursor-pointer transition-all duration-200">
                        Batal
                    </button>
                    <button type="submit" id="editSubmitBtn"
                        class="inline-flex items-center gap-[6px] px-[22px] py-[9px] text-[13.5px] font-bold text-white border-none rounded-[10px] cursor-pointer transition-all duration-200 shadow-[0_2px_8px_rgba(107,26,43,0.25)] disabled:opacity-60 disabled:cursor-not-allowed hover:opacity-90"
                        style="background: linear-gradient(135deg,#6B1A2B,#9B3045);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Update
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>