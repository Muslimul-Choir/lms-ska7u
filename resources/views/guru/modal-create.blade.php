{{-- modal-create guru --}}
<div id="modalCreateGuru" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5">

    {{-- Overlay --}}
    <div onclick="closeCreateGuruModal()"
        class="absolute inset-0 bg-black/50 backdrop-blur-sm">
    </div>

    {{-- Dialog --}}
    <div class="relative z-10 w-full max-w-lg">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">

            {{-- ── Header ── --}}
            <div class="flex items-center justify-between px-5 py-4 bg-gradient-to-r from-indigo-700 to-indigo-500 dark:from-indigo-900 dark:to-indigo-700">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-sm leading-tight tracking-wide">Tambah Guru</h3>
                        <p class="text-[11px] mt-0.5 text-indigo-200/80">Isi data guru baru</p>
                    </div>
                </div>
                <button type="button" onclick="closeCreateGuruModal()"
                    class="w-7 h-7 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 text-white/70 hover:text-white transition-all duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- ── Body ── --}}
            <form action="{{ route('guru.store') }}" id="createGuruFormAction" method="POST" class="px-5 py-5">
                @csrf
                <input type="hidden" name="_modal" value="create">

                <div class="grid grid-cols-1 gap-4">

                    {{-- Nama Lengkap --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Nama Lengkap <span class="text-red-400">*</span>
                        </label>
                        <input type="text"
                            id="create_nama_lengkap"
                            name="nama_lengkap"
                            value="{{ old('_modal') === 'create' ? old('nama_lengkap') : '' }}"
                            placeholder="Masukkan nama lengkap"
                            autocomplete="off"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none
                                   focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-500
                                   {{ $errors->has('nama_lengkap') && old('_modal') === 'create'
                                       ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600'
                                       : 'border-slate-300 dark:border-slate-600' }}">
                        @if ($errors->has('nama_lengkap') && old('_modal') === 'create')
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
                            id="create_email"
                            name="email"
                            value="{{ old('_modal') === 'create' ? old('email') : '' }}"
                            placeholder="contoh@sekolah.sch.id"
                            autocomplete="off"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none
                                   focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-500
                                   {{ $errors->has('email') && old('_modal') === 'create'
                                       ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600'
                                       : 'border-slate-300 dark:border-slate-600' }}">
                        @if ($errors->has('email') && old('_modal') === 'create')
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
                        <select id="create_status_pengajar" name="status_pengajar"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none cursor-pointer
                                   focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-500
                                   {{ $errors->has('status_pengajar') && old('_modal') === 'create'
                                       ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600'
                                       : 'border-slate-300 dark:border-slate-600' }}">
                            <option value="">Pilih Status</option>
                            @foreach(['pengajar' => 'Pengajar', 'walikelas' => 'Wali Kelas', 'keduanya' => 'Keduanya'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('_modal') === 'create' && old('status_pengajar') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('status_pengajar') && old('_modal') === 'create')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('status_pengajar') }}
                            </p>
                        @endif
                    </div>

                    {{-- Info password --}}
                    <div class="flex items-start gap-2 rounded-xl border border-sky-200 dark:border-sky-700/50 bg-sky-50 dark:bg-sky-900/20 px-3.5 py-3">
                        <svg class="w-3.5 h-3.5 text-sky-500 dark:text-sky-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-sky-700 dark:text-sky-300">
                            Password akan dibuat otomatis (acak) dan dapat dikirim ke email guru via tombol <strong>Kirim Email</strong>.
                        </p>
                    </div>

                </div>

                {{-- ── Footer ── --}}
                <div class="flex items-center justify-end gap-2 pt-5 mt-1 border-t border-slate-100 dark:border-slate-700/60">
                    <button type="button" onclick="closeCreateGuruModal()"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium rounded-xl
                               bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700
                               text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600
                               transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="submit" id="createGuruSubmitBtn"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-semibold rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition-all duration-200
                        disabled:opacity-60 disabled:cursor-not-allowed">
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