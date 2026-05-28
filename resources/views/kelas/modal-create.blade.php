<div id="modalCreate" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5">

    {{-- Overlay --}}
    <div onclick="closeCreateModal()"
        class="absolute inset-0 bg-black/50 backdrop-blur-sm">
    </div>

    {{-- Dialog --}}
    <div class="relative z-10 w-full max-w-lg">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">

            {{-- ── Header ── --}}
            <div class="flex items-center justify-between px-5 py-4 bg-gradient-to-r from-[#5C1020] to-[#43101A] dark:from-[#43101A] dark:to-[#2A0A12]">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-[#F3C969]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-sm leading-tight tracking-wide">Tambah Kelas</h3>
                        <p class="text-[11px] mt-0.5" style="color:rgba(243,201,105,0.7)">Isi data kelas baru</p>
                    </div>
                </div>
                <button type="button" onclick="closeCreateModal()"
                    class="w-7 h-7 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 text-white/70 hover:text-white transition-all duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- ── Body ── --}}
            <form action="{{ route('kelas.store') }}" id="createFormAction" method="POST" class="px-5 py-5">
                @csrf
                <input type="hidden" name="_modal" value="create">

                {{-- Grid 2 kolom untuk tablet ke atas --}}
                <div class="grid grid-cols-1 sm:grid-cols-6 gap-4">

                    {{-- Tingkatan --}}
                    <div class="flex flex-col gap-1.5 sm:col-span-2">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Tingkatan <span class="text-red-400">*</span>
                        </label>
                        <select name="id_tingkatan"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none cursor-pointer
                                   focus:ring-2 focus:ring-[#5C1020]/20 focus:border-[#5C1020] dark:focus:border-[#5C1020]
                                   {{ $errors->has('id_tingkatan') && old('_modal') === 'create'
                                       ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600'
                                       : 'border-slate-300 dark:border-slate-600' }}">
                            <option value=""> Pilih Tingkatan </option>
                            @foreach ($tingkatanList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_tingkatan') == $item->id && old('_modal') === 'create' ? 'selected' : '' }}>
                                    {{ $item->nama_tingkatan }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_tingkatan') && old('_modal') === 'create')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('id_tingkatan') }}
                            </p>
                        @endif
                    </div>


                    {{-- Jurusan --}}
                    <div class="flex flex-col gap-1.5 sm:col-span-2">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Jurusan <span class="text-red-400">*</span>
                        </label>
                        <select name="id_jurusan"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none cursor-pointer
                                   focus:ring-2 focus:ring-[#5C1020]/20 focus:border-[#5C1020] dark:focus:border-[#5C1020]
                                   {{ $errors->has('id_jurusan') && old('_modal') === 'create'
                                       ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600'
                                       : 'border-slate-300 dark:border-slate-600' }}">
                            <option value=""> Pilih Jurusan </option>
                            @foreach ($jurusanList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_jurusan') == $item->id && old('_modal') === 'create' ? 'selected' : '' }}>
                                    {{ $item->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_jurusan') && old('_modal') === 'create')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('id_jurusan') }}
                            </p>
                        @endif
                    </div>

                    {{-- Bagian --}}
                    <div class="flex flex-col gap-1.5 sm:col-span-2">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Bagian <span class="text-red-400">*</span>
                        </label>
                        <select name="id_bagian"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none cursor-pointer
                                   focus:ring-2 focus:ring-[#5C1020]/20 focus:border-[#5C1020] dark:focus:border-[#5C1020]
                                   {{ $errors->has('id_bagian') && old('_modal') === 'create'
                                       ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600'
                                       : 'border-slate-300 dark:border-slate-600' }}">
                            <option value=""> Pilih Bagian </option>
                            @foreach ($bagianList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_bagian') == $item->id && old('_modal') === 'create' ? 'selected' : '' }}>
                                    {{ $item->nama_bagian }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_bagian') && old('_modal') === 'create')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('id_bagian') }}
                            </p>
                        @endif
                    </div>

                    {{-- Tahun Ajaran --}}
                    <div class="flex flex-col gap-1.5 sm:col-span-3">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Tahun Ajaran <span class="text-red-400">*</span>
                        </label>
                        <select name="id_tahun_ajaran"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none cursor-pointer
                                   focus:ring-2 focus:ring-[#5C1020]/20 focus:border-[#5C1020] dark:focus:border-[#5C1020]
                                   {{ $errors->has('id_tahun_ajaran') && old('_modal') === 'create'
                                       ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600'
                                       : 'border-slate-300 dark:border-slate-600' }}">
                            <option value=""> Pilih Tahun Ajaran </option>
                            @foreach ($tahunAjaranList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('_modal') === 'create'
                                        ? (old('id_tahun_ajaran') == $item->id ? 'selected' : '')
                                        : ($item->is_aktif ? 'selected' : '') }}>
                                    {{ $item->nama_tahun }}{{ $item->is_aktif ? ' (Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_tahun_ajaran') && old('_modal') === 'create')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('id_tahun_ajaran') }}
                            </p>
                        @endif
                    </div>

                    {{-- Wali Kelas --}}
                    <div class="flex flex-col gap-1.5 sm:col-span-3">
                        <label class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Wali Kelas <span class="text-red-400">*</span>
                        </label>
                        <select name="id_wali_kelas"
                            class="w-full rounded-xl border bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none cursor-pointer
                                   focus:ring-2 focus:ring-[#5C1020]/20 focus:border-[#5C1020] dark:focus:border-[#5C1020]
                                   {{ $errors->has('id_wali_kelas') && old('_modal') === 'create'
                                       ? 'border-red-400 bg-red-50 dark:bg-red-900/20 dark:border-red-600'
                                       : 'border-slate-300 dark:border-slate-600' }}">
                            <option value=""> Pilih Wali Kelas </option>
                            @foreach ($guruList as $guru)
                                <option value="{{ $guru->id }}"
                                    {{ old('id_wali_kelas') == $guru->id && old('_modal') === 'create' ? 'selected' : '' }}>
                                    {{ $guru->nama_lengkap }}
                                    ({{ $guru->status_pengajar === 'walikelas' ? 'Wali Kelas' : 'Wali Kelas & Pengajar' }})
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_wali_kelas') && old('_modal') === 'create')
                            <p class="flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('id_wali_kelas') }}
                            </p>
                        @endif
                    </div>

                </div>

                {{-- ── Footer ── --}}
                <div class="flex items-center justify-end gap-2 pt-5 mt-1 border-t border-slate-100 dark:border-slate-700/60">
                    <button type="button" onclick="closeCreateModal()"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium rounded-xl
                               bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700
                               text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600
                               transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="submit" id="createSubmitBtn"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-semibold rounded-xl bg-[#5C1020] hover:bg-[#43101A] text-white shadow-sm transition-all duration-200
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