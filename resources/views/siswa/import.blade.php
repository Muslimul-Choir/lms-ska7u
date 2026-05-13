<div id="modalImportSiswa"
    class="fixed inset-0 z-50 hidden overflow-y-auto"
    aria-labelledby="modalImportSiswaTitle"
    role="dialog"
    aria-modal="true">

    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"
         onclick="closeImportSiswaModal()"></div>

    {{-- Panel --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-xl dark:bg-gray-800">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                    </div>
                    <h3 id="modalImportSiswaTitle" class="text-base font-semibold text-gray-900 dark:text-white">
                        Import Data Siswa
                    </h3>
                </div>
                <button type="button" onclick="closeImportSiswaModal()"
                    class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" name="_modal" value="import">

                <div class="space-y-4 px-6 py-5">

                    {{-- Info format --}}
                    <div class="rounded-lg bg-blue-50 border border-blue-200 p-4 text-xs text-blue-800 dark:bg-blue-900/30 dark:border-blue-700 dark:text-blue-300">
                        <p class="font-semibold mb-2">Format kolom Excel (baris pertama sebagai header):</p>
                        <code class="block bg-white dark:bg-gray-800 px-3 py-2 rounded border border-blue-200 dark:border-blue-700 font-mono">
                            NO <span class="italic">(opsional)</span> &nbsp;|&nbsp; Nama Lengkap &nbsp;|&nbsp; Email &nbsp;|&nbsp; Tanggal Lahir &nbsp;|&nbsp; Agama &nbsp;|&nbsp; Kelas
                        </code>
                        <ul class="mt-3 space-y-1 list-disc list-inside">
                            <li><strong>Tanggal Lahir</strong>: Format DD/MM/YYYY (contoh: 12/03/2005)</li>
                            <li>Nilai <strong>Agama (awalan kapital)</strong>: Islam, Kristen, Katolik, Hindu, Buddha, Konghucu</li>
                            <li>Nilai <strong>Kelas</strong>: Nama kelas persis seperti di database</li>
                            <li>Password otomatis dibuat dari tanggal lahir (DDMMYYYY)</li>
                            <li>Email yang sudah terdaftar akan dilewati</li>
                            <li>Email yang ada di trash akan di-restore otomatis</li>
                            
                        </ul>
                    </div>

                    {{-- File input --}}
                    <div>
                        <label for="import_file_siswa" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Pilih File <span class="text-red-500">*</span>
                        </label>
                        <input type="file"
                            id="import_file_siswa"
                            name="file"
                            accept=".xlsx,.xls,.csv"
                            class="w-full rounded-lg border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 focus:ring-blue-500
                            {{ $errors->has('file') && old('_modal') === 'import' ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-700 dark:text-white' }}">
                        @if ($errors->has('file') && old('_modal') === 'import')
                            <p class="mt-1 text-xs text-red-600">{{ $errors->first('file') }}</p>
                        @endif
                        <p class="mt-1 text-xs text-gray-400">Format: .xlsx, .xls, .csv — Maks. 5MB</p>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 border-t border-gray-200 px-6 py-4 dark:border-gray-700">
                    <button type="button" onclick="closeImportSiswaModal()"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Import
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>