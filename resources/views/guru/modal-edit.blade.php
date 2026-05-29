{{-- modal-edit guru --}}
<div id="modalEditGuru" class="hidden fixed inset-0 z-[999] flex items-center justify-center p-3 sm:p-5">

    {{-- Overlay --}}
    <div onclick="closeEditGuruModal()" class="absolute inset-0 bg-black/50 backdrop-blur-sm">
    </div>

    {{-- Dialog --}}
    <div class="relative z-10 w-full max-w-lg">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">

            {{-- ── Header ── --}}
            <div class="flex items-center justify-between px-5 py-4 bg-gradient-to-r from-amber-600 to-amber-400 dark:from-amber-800 dark:to-amber-600">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-sm leading-tight tracking-wide">Edit Guru</h3>
                        <p class="text-[11px] mt-0.5 text-amber-100/80">Perbarui data guru</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditGuruModal()"
                    class="w-7 h-7 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 text-white/70 hover:text-white transition-all duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- ── Notice bar ── --}}
            <div class="flex items-center gap-2 px-5 py-3 bg-amber-50 dark:bg-amber-900/20 border-b border-amber-200 dark:border-amber-700/40">
                <svg class="w-3.5 h-3.5 text-amber-500 dark:text-amber-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-amber-700 dark:text-amber-200 text-[11px] font-medium">
                    Perubahan akan langsung disimpan ke database.
                </p>
            </div>

            {{-- ── Body ── --}}
            <form id="editGuruForm" action="" method="POST" class="px-5 py-5">
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="edit">
                <input type="hidden" id="edit_route_guru" name="_edit_route" value="{{ old('_edit_route', '') }}">
                <input type="hidden" id="edit_guru_id" name="edit_id" value="{{ old('edit_id', '') }}">

                <div class="grid grid-cols-1 gap-4">

                    {{-- Nama Lengkap --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Nama Lengkap <span class="text-red-400">*</span>
                        </label>
                        <input type="text"
                            id="edit_nama_lengkap"
                            name="nama_lengkap"
                            value="{{ old('_modal') === 'edit' ? old('nama_lengkap') : '' }}"
                            placeholder="Masukkan nama lengkap"
                            autocomplete="off"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none
                                   focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 dark:focus:border-amber-500
                                   {{ $errors->has('nama_lengkap') && old('_modal') === 'edit'
                                       ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600'
                                       : 'border-slate-300 dark:border-slate-600' }}">
                        @if ($errors->has('nama_lengkap') && old('_modal') === 'edit')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('nama_lengkap') }}
                            </p>
                        @endif
                    </div>

                    {{-- Email --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Email <span class="text-red-400">*</span>
                        </label>
                        <input type="email"
                            id="edit_email"
                            name="email"
                            value="{{ old('_modal') === 'edit' ? old('email') : '' }}"
                            placeholder="contoh@sekolah.sch.id"
                            autocomplete="off"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none
                                   focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 dark:focus:border-amber-500
                                   {{ $errors->has('email') && old('_modal') === 'edit'
                                       ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600'
                                       : 'border-slate-300 dark:border-slate-600' }}">
                        @if ($errors->has('email') && old('_modal') === 'edit')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>

                    {{-- Status Pengajar --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Status Pengajar <span class="text-red-400">*</span>
                        </label>
                        <select id="edit_status_pengajar" name="status_pengajar"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none cursor-pointer
                                   focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 dark:focus:border-amber-500
                                   {{ $errors->has('status_pengajar') && old('_modal') === 'edit'
                                       ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600'
                                       : 'border-slate-300 dark:border-slate-600' }}">
                            <option value="">Pilih Status</option>
                            @foreach(['pengajar' => 'Pengajar', 'walikelas' => 'Wali Kelas', 'keduanya' => 'Keduanya'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('_modal') === 'edit' && old('status_pengajar') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('status_pengajar') && old('_modal') === 'edit')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('status_pengajar') }}
                            </p>
                        @endif
                    </div>

                </div>

                {{-- ── Footer ── --}}
                <div class="flex items-center justify-end gap-2 pt-5 mt-1 border-t border-slate-100 dark:border-slate-700/60">
                    <button type="button" onclick="closeEditGuruModal()"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium rounded-xl
                               bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700
                               text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600
                               transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="submit" id="editGuruSubmitBtn"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-semibold rounded-xl bg-amber-500 hover:bg-amber-600 text-white shadow-sm transition-all duration-200
                        disabled:opacity-60 disabled:cursor-not-allowed">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>