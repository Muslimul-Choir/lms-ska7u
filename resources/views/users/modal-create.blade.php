<div id="modalCreateUser" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5">

    {{-- Overlay --}}
    <div onclick="closeCreateUserModal()" class="absolute inset-0 bg-black/50 backdrop-blur-sm">
    </div>

    {{-- Dialog --}}
    <div class="relative z-10 w-full max-w-lg">
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">

            {{-- Header --}}
            <div
                class="flex items-center justify-between px-5 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-700 dark:to-indigo-800">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-sm leading-tight tracking-wide">Tambah User</h3>
                        <p class="text-[11px] mt-0.5" style="color:rgba(199, 210, 254, 0.7)">Buat akun Super Admin &
                            Admin</p>
                    </div>
                </div>
                <button type="button" onclick="closeCreateUserModal()"
                    class="w-7 h-7 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 text-white/70 hover:text-white transition-all duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Notice bar --}}
            <div
                class="flex items-center gap-2 px-5 py-3 bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-700/40">
                <svg class="w-3.5 h-3.5 text-blue-500 dark:text-blue-400 flex-shrink-0" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-blue-700 dark:text-blue-200 text-[11px] font-medium">
                    Data akan langsung disimpan ke database.
                </p>
            </div>

            {{-- Body --}}
            <form id="createFormAction" action="{{ route('users.store') }}" method="POST" class="px-5 py-5">
                @csrf
                <input type="hidden" name="_modal" value="create">

                <div class="grid grid-cols-1 gap-4">

                    {{-- Nama --}}
                    <div class="flex flex-col gap-1.5">
                        <label
                            class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Nama <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', '') }}"
                            placeholder="Masukkan nama lengkap"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none
                                   focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 dark:focus:border-indigo-400
                                   {{ $errors->has('name') && old('_modal') === 'create' ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600' : 'border-slate-300 dark:border-slate-600' }}">
                        @if ($errors->has('name') && old('_modal') === 'create')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                    </div>

                    {{-- Email --}}
                    <div class="flex flex-col gap-1.5">
                        <label
                            class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Email <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', '') }}"
                            placeholder="contoh@sekolah.sch.id"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none
                                   focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 dark:focus:border-indigo-400
                                   {{ $errors->has('email') && old('_modal') === 'create' ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600' : 'border-slate-300 dark:border-slate-600' }}">
                        @if ($errors->has('email') && old('_modal') === 'create')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>

                    {{-- Password --}}
                    <div class="flex flex-col gap-1.5">
                        <label
                            class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Password <span class="text-red-400">*</span>
                        </label>
                        <input type="password" name="password" placeholder="Masukkan password"
                            autocomplete="new-password"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none
                                   focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 dark:focus:border-indigo-400
                                   {{ $errors->has('password') && old('_modal') === 'create' ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600' : 'border-slate-300 dark:border-slate-600' }}">
                        @if ($errors->has('password') && old('_modal') === 'create')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $errors->first('password') }}
                            </p>
                        @endif
                    </div>

                    {{-- Password Confirmation --}}
                    <div class="flex flex-col gap-1.5">
                        <label
                            class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Konfirmasi Password <span class="text-red-400">*</span>
                        </label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password"
                            autocomplete="new-password"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none
                                   focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 dark:focus:border-indigo-400
                                   {{ $errors->has('password_confirmation') && old('_modal') === 'create' ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600' : 'border-slate-300 dark:border-slate-600' }}">
                        @if ($errors->has('password_confirmation') && old('_modal') === 'create')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $errors->first('password_confirmation') }}
                            </p>
                        @endif
                    </div>

                    {{-- Role --}}
                    <div class="flex flex-col gap-1.5">
                        <label
                            class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Role <span class="text-red-400">*</span>
                        </label>
                        <select name="role"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none cursor-pointer
                                   focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 dark:focus:border-indigo-400
                                   {{ $errors->has('role') && old('_modal') === 'create' ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600' : 'border-slate-300 dark:border-slate-600' }}">
                            <option value="">-- Pilih Role --</option>
                            <option value="super_admin"
                                {{ old('role') == 'super_admin' && old('_modal') === 'create' ? 'selected' : '' }}>
                                Super Admin
                            </option>
                            <option value="admin"
                                {{ old('role') == 'admin' && old('_modal') === 'create' ? 'selected' : '' }}>
                                Admin
                            </option>
                        </select>
                        @if ($errors->has('role') && old('_modal') === 'create')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $errors->first('role') }}
                            </p>
                        @endif
                    </div>

                </div>

                {{-- Footer --}}
                <div
                    class="flex items-center justify-end gap-2 pt-5 mt-1 border-t border-slate-100 dark:border-slate-700/60">
                    <button type="button" onclick="closeCreateUserModal()"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium rounded-xl
                               bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-300
                               transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </button>

                    <button type="submit" id="createSubmitBtn"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-semibold rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition-all duration-200
                        disabled:opacity-60 disabled:cursor-not-allowed">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
