<div id="modalCreateSiswa"
    class="fixed inset-0 z-50 hidden overflow-y-auto"
    aria-labelledby="modalCreateSiswaTitle"
    role="dialog"
    aria-modal="true">

    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"
         onclick="closeCreateSiswaModal()"></div>

    {{-- Panel --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-xl dark:bg-gray-800">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900">
                        <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h3 id="modalCreateSiswaTitle" class="text-base font-semibold text-gray-900 dark:text-white">
                        Tambah Siswa
                    </h3>
                </div>
                <button type="button" onclick="closeCreateSiswaModal()"
                    class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ route('siswa.store') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="_modal" value="create">

                <div class="space-y-4 px-6 py-5">

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="create_nama_lengkap" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            id="create_nama_lengkap"
                            name="nama_lengkap"
                            value="{{ old('_modal') === 'create' ? old('nama_lengkap') : '' }}"
                            placeholder="Masukkan nama lengkap"
                            autocomplete="off"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500
                            {{ $errors->has('nama_lengkap') && old('_modal') === 'create' ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                        @if ($errors->has('nama_lengkap') && old('_modal') === 'create')
                            <p class="mt-1 text-xs text-red-600">{{ $errors->first('nama_lengkap') }}</p>
                        @endif
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="create_email" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                            id="create_email"
                            name="email"
                            value="{{ old('_modal') === 'create' ? old('email') : '' }}"
                            placeholder="contoh@sekolah.sch.id"
                            autocomplete="off"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500
                            {{ $errors->has('email') && old('_modal') === 'create' ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                        @if ($errors->has('email') && old('_modal') === 'create')
                            <p class="mt-1 text-xs text-red-600">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    {{-- Agama --}}
                    <div>
                        <label for="create_agama" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Agama <span class="text-red-500">*</span>
                        </label>
                        <select id="create_agama" name="agama"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500
                            {{ $errors->has('agama') && old('_modal') === 'create' ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Agama --</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                <option value="{{ $agama }}"
                                    {{ old('_modal') === 'create' && old('agama') === $agama ? 'selected' : '' }}>
                                    {{ $agama }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('agama') && old('_modal') === 'create')
                            <p class="mt-1 text-xs text-red-600">{{ $errors->first('agama') }}</p>
                        @endif
                    </div>

                    {{-- Kelas --}}
                    <div>
                        <label for="create_id_kelas" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="create_id_kelas" name="id_kelas"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500
                            {{ $errors->has('id_kelas') && old('_modal') === 'create' ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}"
                                    {{ old('_modal') === 'create' && old('id_kelas') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_kelas') && old('_modal') === 'create')
                            <p class="mt-1 text-xs text-red-600">{{ $errors->first('id_kelas') }}</p>
                        @endif
                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 border-t border-gray-200 px-6 py-4 dark:border-gray-700">
                    <button type="button" onclick="closeCreateSiswaModal()"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>