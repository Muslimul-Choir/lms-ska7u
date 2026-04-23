@php
    // Saat reopen dari error validasi, Blade set action langsung
    $editAction = (old('_modal') === 'edit' && old('edit_id'))
        ? route('kelas.update', old('edit_id'))
        : '';
@endphp

<div id="modalEdit"
    class="fixed inset-0 z-50 hidden overflow-y-auto"
    aria-labelledby="modalEditTitle"
    role="dialog"
    aria-modal="true">

    {{-- Backdrop --}}
    <div onclick="closeEditModal()"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

    {{-- Panel --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-xl dark:bg-gray-800 transition-all">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900">
                        <svg class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h3 id="modalEditTitle" class="text-base font-semibold text-gray-900 dark:text-white">
                        Edit Kelas
                    </h3>
                </div>
                <button type="button" onclick="closeEditModal()"
                    class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-200 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="editFormAction" action="{{ $editAction }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="edit">
                {{-- Kunci: id kelas disimpan di sini, diisi JS saat buka normal, diisi old() saat reopen error --}}
                <input type="hidden" name="edit_id" id="edit_id" value="{{ old('edit_id') }}">

                <div class="space-y-4 px-6 py-5">

                    {{-- Tingkatan --}}
                    <div>
                        <label for="edit_id_tingkatan" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Tingkatan <span class="text-red-500">*</span>
                        </label>
                        <select id="edit_id_tingkatan" name="id_tingkatan"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-amber-500
                            {{ $errors->has('id_tingkatan') && old('_modal') === 'edit' ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Tingkatan --</option>
                            @foreach ($tingkatanList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_tingkatan', '') == $item->id && old('_modal') === 'edit' ? 'selected' : '' }}>
                                    {{ $item->nama_tingkatan }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_tingkatan') && old('_modal') === 'edit')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $errors->first('id_tingkatan') }}</p>
                        @endif
                    </div>

                    {{-- Jurusan --}}
                    <div>
                        <label for="edit_id_jurusan" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Jurusan <span class="text-red-500">*</span>
                        </label>
                        <select id="edit_id_jurusan" name="id_jurusan"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-amber-500
                            {{ $errors->has('id_jurusan') && old('_modal') === 'edit' ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach ($jurusanList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_jurusan', '') == $item->id && old('_modal') === 'edit' ? 'selected' : '' }}>
                                    {{ $item->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_jurusan') && old('_modal') === 'edit')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $errors->first('id_jurusan') }}</p>
                        @endif
                    </div>

                    {{-- Bagian --}}
                    <div>
                        <label for="edit_id_bagian" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Bagian<span class="text-red-500">*</span>
                        </label>
                        <select id="edit_id_bagian" name="id_bagian"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-amber-500
                            {{ $errors->has('id_bagian') && old('_modal') === 'edit' ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Bagian --</option>
                            @foreach ($bagianList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_bagian', '') == $item->id && old('_modal') === 'edit' ? 'selected' : '' }}>
                                    {{ $item->nama_bagian }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_bagian') && old('_modal') === 'edit')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $errors->first('id_bagian') }}</p>
                        @endif
                    </div>

                    {{-- Tahun Ajaran --}}
                    <div>
                        <label for="edit_id_tahun_ajaran" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <select id="edit_id_tahun_ajaran" name="id_tahun_ajaran"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-amber-500
                            {{ $errors->has('id_tahun_ajaran') && old('_modal') === 'edit' ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach ($tahunAjaranList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_tahun_ajaran', '') == $item->id && old('_modal') === 'edit' ? 'selected' : '' }}>
                                    {{ $item->nama_tahun }} {{ $item->is_aktif ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_tahun_ajaran') && old('_modal') === 'edit')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $errors->first('id_tahun_ajaran') }}</p>
                        @endif
                    </div>

                    {{-- Wali Kelas --}}
                    <div>
                        <label for="edit_id_wali_kelas" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Wali Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="edit_id_wali_kelas" name="id_wali_kelas"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-amber-500
                            {{ $errors->has('id_wali_kelas') && old('_modal') === 'edit' ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach ($guruList as $guru)
                                <option value="{{ $guru->id }}"
                                    {{ old('id_wali_kelas', '') == $guru->id && old('_modal') === 'edit' ? 'selected' : '' }}>
                                    {{ $guru->nama_lengkap }}
                                    ({{ $guru->status_pengajar === 'walikelas' ? 'Wali Kelas' : 'Wali Kelas & Pengajar' }})
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_wali_kelas') && old('_modal') === 'edit')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $errors->first('id_wali_kelas') }}</p>
                        @endif
                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 border-t border-gray-200 px-6 py-4 dark:border-gray-700">
                    <button type="button" onclick="closeEditModal()"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>