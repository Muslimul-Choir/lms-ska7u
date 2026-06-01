<div id="modalEditUser" class="hidden fixed inset-0 z-[999] flex items-center justify-center p-3 sm:p-5">

    {{-- Overlay --}}
    <div onclick="closeEditUserModal()"
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-[15px] m-0 mb-[2px]">Edit Akun</h3>
                        <p class="text-[rgba(255,255,255,0.5)] text-[11px] m-0">Perbarui data akun</p>
                    </div>
                </div>

                <button type="button" onclick="closeEditUserModal()"
                    class="w-[30px] h-[30px] rounded-lg bg-[rgba(255,255,255,0.12)] hover:bg-[rgba(255,255,255,0.22)] border-none cursor-pointer flex items-center justify-center transition-all duration-200">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Gold accent bar --}}
            <div class="h-[3px]" style="background: linear-gradient(90deg,#E8930A,#F5A623,#E8930A);"></div>

            {{-- Body --}}
            <form id="editFormAction" action="" method="POST" class="p-6 flex flex-col gap-[18px]">
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="edit">
                <input type="hidden" id="edit_route" name="_edit_route" value="{{ old('_edit_route', '') }}">
                <input type="hidden" id="edit_user_id" name="edit_id" value="{{ old('edit_id') }}">

                <div class="grid grid-cols-1 gap-4">

                    {{-- Nama --}}
                    <div class="flex flex-col gap-[7px]">
                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit_name" name="name"
                            value="{{ old('_modal') === 'edit' ? old('name') : '' }}"
                            placeholder="Masukkan nama lengkap"
                            class="w-full rounded-[10px] border py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white
                            {{ $errors->has('name') && old('_modal') === 'edit' ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                        @if ($errors->has('name') && old('_modal') === 'edit')
                            <p class="flex items-center gap-1 text-xs text-red-600">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                    </div>

                    {{-- Email --}}
                    <div class="flex flex-col gap-[7px]">
                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="edit_email" name="email"
                            value="{{ old('_modal') === 'edit' ? old('email') : '' }}"
                            placeholder="contoh@sekolah.sch.id"
                            class="w-full rounded-[10px] border py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white
                            {{ $errors->has('email') && old('_modal') === 'edit' ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                        @if ($errors->has('email') && old('_modal') === 'edit')
                            <p class="flex items-center gap-1 text-xs text-red-600">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>

                    {{-- Password --}}
                    <div class="flex flex-col gap-[7px]">
                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                            Password
                            <span class="font-normal text-gray-400 text-[10px] normal-case tracking-normal">(opsional)</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="edit_password" name="password"
                                placeholder="Kosongkan jika tidak diubah" autocomplete="new-password"
                                class="w-full rounded-[10px] border py-[10px] pl-[14px] pr-[40px] text-[14px] text-gray-900 bg-gray-50 outline-none transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white
                                {{ $errors->has('password') && old('_modal') === 'edit' ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            <button type="button" onclick="togglePassword('edit_password', 'eye_edit_password')"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg id="eye_edit_password" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @if ($errors->has('password') && old('_modal') === 'edit')
                            <p class="flex items-center gap-1 text-xs text-red-600">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $errors->first('password') }}
                            </p>
                        @endif
                    </div>

                    {{-- Role --}}
                    <div class="flex flex-col gap-[7px]">
                        <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="edit_role" name="role"
                            class="w-full rounded-[10px] border py-[10px] px-[14px] text-[14px] text-gray-900 bg-gray-50 outline-none cursor-pointer transition-all duration-200 focus:border-[#E8930A] focus:shadow-[0_0_0_3px_rgba(232,147,10,0.13)] focus:bg-white
                            {{ $errors->has('role') && old('_modal') === 'edit' ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            <option value="">-- Pilih Role --</option>
                            <option value="super_admin" {{ old('_modal') === 'edit' && old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ old('_modal') === 'edit' && old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @if ($errors->has('role') && old('_modal') === 'edit')
                            <p class="flex items-center gap-1 text-xs text-red-600">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $errors->first('role') }}
                            </p>
                        @endif
                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-[10px] pt-[6px] border-t border-gray-100">
                    <button type="button" onclick="closeEditUserModal()"
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