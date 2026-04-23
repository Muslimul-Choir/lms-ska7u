<div id="modalCreate" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modalCreateTitle" role="dialog"
    aria-modal="true">

    {{-- Backdrop --}}
    <div onclick="closeCreateModal()" 
        class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

    {{-- Panel --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-xl dark:bg-gray-800 transition-all">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900">
                        <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h3 id="modalCreateTitle" class="text-base font-semibold text-gray-900 dark:text-white">
                        Tambah Kelas Baru
                    </h3>
                </div>
                <button type="button" onclick="closeCreateModal()"
                    class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-200 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ route('kelas.store') }}" method="POST" novalidate>
                @csrf
                {{-- Penanda modal untuk buka kembali saat error --}}
                <input type="hidden" name="_modal" value="create">

                <div class="space-y-4 px-6 py-5">

                    {{-- Global error summary --}}
                    {{-- @if ($errors->any() && old('_modal') === 'create')
                        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 dark:border-red-800 dark:bg-red-900/30">
                            <p class="mb-1 text-xs font-semibold text-red-700 dark:text-red-400">Terdapat kesalahan:</p>
                            <ul class="list-inside list-disc space-y-0.5 text-xs text-red-600 dark:text-red-400">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    {{-- Tingkatan --}}
                    <div>
                        <label for="create_id_tingkatan"
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Tingkatan <span class="text-red-500">*</span>
                        </label>
                        <select id="create_id_tingkatan" name="id_tingkatan"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500
                            {{ $errors->has('id_tingkatan') && old('_modal') === 'create' ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Tingkatan --</option>
                            @foreach ($tingkatanList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_tingkatan') == $item->id && old('_modal') === 'create' ? 'selected' : '' }}>
                                    {{ $item->nama_tingkatan }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_tingkatan') && old('_modal') === 'create')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $errors->first('id_tingkatan') }}
                            </p>
                        @endif
                    </div>

                    {{-- Jurusan --}}
                    <div>
                        <label for="create_id_jurusan"
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Jurusan <span class="text-red-500">*</span>
                        </label>
                        <select id="create_id_jurusan" name="id_jurusan"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500
                            {{ $errors->has('id_jurusan') && old('_modal') === 'create' ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach ($jurusanList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_jurusan') == $item->id && old('_modal') === 'create' ? 'selected' : '' }}>
                                    {{ $item->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_jurusan') && old('_modal') === 'create')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $errors->first('id_jurusan') }}
                            </p>
                        @endif
                    </div>

                    {{-- Bagian --}}
                    <div>
                        <label for="create_id_bagian"
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Bagian <span class="text-red-500">*</span>
                        </label>
                        <select id="create_id_bagian" name="id_bagian"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500
                            {{ $errors->has('id_bagian') && old('_modal') === 'create' ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Bagian --</option>
                            @foreach ($bagianList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_bagian') == $item->id && old('_modal') === 'create' ? 'selected' : '' }}>
                                    {{ $item->nama_bagian }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_bagian') && old('_modal') === 'create')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $errors->first('id_bagian') }}
                            </p>
                        @endif
                    </div>

                    {{-- Tahun Ajaran --}}
                    <div>
                        <label for="create_id_tahun_ajaran"
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <select id="create_id_tahun_ajaran" name="id_tahun_ajaran"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500
                            {{ $errors->has('id_tahun_ajaran') && old('_modal') === 'create' ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach ($tahunAjaranList as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('_modal') === 'create'
                                        ? (old('id_tahun_ajaran') == $item->id
                                            ? 'selected'
                                            : '')
                                        : ($item->is_aktif
                                            ? 'selected'
                                            : '') }}>
                                    {{ $item->nama_tahun }} {{ $item->is_aktif ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_tahun_ajaran') && old('_modal') === 'create')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">
                                {{ $errors->first('id_tahun_ajaran') }}</p>
                        @endif
                    </div>

                    {{-- Wali Kelas --}}
                    <div>
                        <label for="create_id_wali_kelas"
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Wali Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="create_id_wali_kelas" name="id_wali_kelas"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500
                            {{ $errors->has('id_wali_kelas') && old('_modal') === 'create' ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
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
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">
                                {{ $errors->first('id_wali_kelas') }}</p>
                        @endif
                    </div>

                </div>

                {{-- Footer --}}
                <div
                    class="flex items-center justify-end gap-3 border-t border-gray-200 px-6 py-4 dark:border-gray-700">
                    <button type="button" onclick="closeCreateModal()"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
