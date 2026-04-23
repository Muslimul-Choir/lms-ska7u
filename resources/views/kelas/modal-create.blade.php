<div id="modalCreate" style="display:none; position:fixed; inset:0; z-index:9999;">

    {{-- Overlay --}}
    <div onclick="closeCreateModal()"
         style="position:absolute; inset:0; background:rgba(10,25,60,0.55); backdrop-filter:blur(3px);">
    </div>

    {{-- Dialog --}}
    <div style="position:relative; z-index:10; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden ring-1 ring-slate-200">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-md bg-white/15 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Tambah Kelas</h3>
                        <p class="text-blue-200 text-[11px]">Isi data kelas baru</p>
                    </div>
                </div>
                <button type="button" onclick="closeCreateModal()"
                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/25 text-white transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <form action="{{ route('kelas.store') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf
                <input type="hidden" name="_modal" value="create">

                {{-- Tingkatan --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Tingkatan <span class="text-red-400">*</span>
                    </label>
                    <select name="id_tingkatan"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition
                                   {{ $errors->has('id_tingkatan') && old('_modal') === 'create' ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        <option value="">-- Pilih Tingkatan --</option>
                        @foreach ($tingkatanList as $item)
                            <option value="{{ $item->id }}"
                                {{ old('id_tingkatan') == $item->id && old('_modal') === 'create' ? 'selected' : '' }}>
                                {{ $item->nama_tingkatan }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('id_tingkatan') && old('_modal') === 'create')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $errors->first('id_tingkatan') }}
                        </p>
                    @endif
                </div>

                {{-- Jurusan --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Jurusan <span class="text-red-400">*</span>
                    </label>
                    <select name="id_jurusan"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition
                                   {{ $errors->has('id_jurusan') && old('_modal') === 'create' ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach ($jurusanList as $item)
                            <option value="{{ $item->id }}"
                                {{ old('id_jurusan') == $item->id && old('_modal') === 'create' ? 'selected' : '' }}>
                                {{ $item->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('id_jurusan') && old('_modal') === 'create')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $errors->first('id_jurusan') }}
                        </p>
                    @endif
                </div>

                {{-- Bagian --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Bagian <span class="text-red-400">*</span>
                    </label>
                    <select name="id_bagian"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition
                                   {{ $errors->has('id_bagian') && old('_modal') === 'create' ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        <option value="">-- Pilih Bagian --</option>
                        @foreach ($bagianList as $item)
                            <option value="{{ $item->id }}"
                                {{ old('id_bagian') == $item->id && old('_modal') === 'create' ? 'selected' : '' }}>
                                {{ $item->nama_bagian }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('id_bagian') && old('_modal') === 'create')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $errors->first('id_bagian') }}
                        </p>
                    @endif
                </div>

                {{-- Tahun Ajaran --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Tahun Ajaran <span class="text-red-400">*</span>
                    </label>
                    <select name="id_tahun_ajaran"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition
                                   {{ $errors->has('id_tahun_ajaran') && old('_modal') === 'create' ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        <option value="">-- Pilih Tahun Ajaran --</option>
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
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $errors->first('id_tahun_ajaran') }}
                        </p>
                    @endif
                </div>

                {{-- Wali Kelas --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">
                        Wali Kelas <span class="text-red-400">*</span>
                    </label>
                    <select name="id_wali_kelas"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B] transition
                                   {{ $errors->has('id_wali_kelas') && old('_modal') === 'create' ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        <option value="">-- Pilih Wali Kelas --</option>
                        @foreach ($guruList as $guru)
                            <option value="{{ $guru->id }}"
                                {{ old('id_wali_kelas') == $guru->id && old('_modal') === 'create' ? 'selected' : '' }}>
                                {{ $guru->nama_lengkap }}
                                ({{ $guru->status_pengajar === 'walikelas' ? 'Wali Kelas' : 'Wali Kelas & Pengajar' }})
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('id_wali_kelas') && old('_modal') === 'create')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $errors->first('id_wali_kelas') }}
                        </p>
                    @endif
                </div>

                <div class="border-t border-slate-100"></div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-2 pt-1">
                    <button type="button" onclick="closeCreateModal()"
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
                        Simpan Kelas
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>