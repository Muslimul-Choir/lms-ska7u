<div id="modalCreateGuru"
    class="fixed inset-0 z-50 hidden overflow-y-auto"
    aria-labelledby="modalCreateGuruTitle"
    role="dialog"
    aria-modal="true">

    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"
         onclick="closeCreateGuruModal()"></div>

    {{-- Panel --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-xl dark:bg-gray-800">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900">
                        <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <h3 id="modalCreateGuruTitle" class="text-base font-semibold text-gray-900 dark:text-white">
                        Tambah Guru Baru
                    </h3>
                </div>
                <button type="button" onclick="closeCreateGuruModal()"
                    class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ route('guru.store') }}" method="POST" novalidate>
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

                    {{-- Status Pengajar --}}
                    <div>
                        <label for="create_status_pengajar" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Status Pengajar <span class="text-red-500">*</span>
                        </label>
                        <select id="create_status_pengajar" name="status_pengajar"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500
                            {{ $errors->has('status_pengajar') && old('_modal') === 'create' ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                            <option value="">-- Pilih Status --</option>
                            @foreach(['pengajar' => 'Pengajar', 'walikelas' => 'Wali Kelas', 'keduanya' => 'Keduanya'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('_modal') === 'create' && old('status_pengajar') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('status_pengajar') && old('_modal') === 'create')
                            <p class="mt-1 text-xs text-red-600">{{ $errors->first('status_pengajar') }}</p>
                        @endif
                    </div>

                    {{-- Info password --}}
                    <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-xs text-blue-700 dark:border-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                        <svg class="mb-1 inline h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Password akan dibuat otomatis (acak) dan dapat dikirim ke email guru via tombol <strong>Send Email</strong>.
                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 border-t border-gray-200 px-6 py-4 dark:border-gray-700">
                    <button type="button" onclick="closeCreateGuruModal()"
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