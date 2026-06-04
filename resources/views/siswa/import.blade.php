{{-- modal-import siswa --}}
<div id="modalImportSiswa" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5">

    {{-- Overlay --}}
    <div onclick="closeImportSiswaModal()"
        class="absolute inset-0 bg-[rgba(45,8,16,0.55)] backdrop-blur-[4px]">
    </div>

    {{-- Dialog --}}
    <div class="relative z-10 w-full max-w-lg">
        <div class="bg-white rounded-[18px] shadow-[0_24px_60px_rgba(107,26,43,0.22),0_4px_16px_rgba(0,0,0,0.08)] overflow-hidden border border-[rgba(107,26,43,0.1)]">

            {{-- Header --}}
            <div class="px-6 py-[18px] flex items-center justify-between relative overflow-hidden"
                style="background: linear-gradient(135deg,#6B1A2B 0%,#4A0F1E 55%,#2D0810 100%);">
                <div class="absolute w-[120px] h-[120px] rounded-full top-[-40px] right-[10px] border border-[rgba(232,147,10,0.2)] pointer-events-none"></div>
                <div class="absolute w-[70px] h-[70px] rounded-full top-[10px] right-[70px] border border-[rgba(232,147,10,0.12)] pointer-events-none"></div>

                <div class="flex items-center gap-3 relative">
                    <div class="w-[38px] h-[38px] rounded-[10px] bg-[rgba(232,147,10,0.2)] flex items-center justify-center flex-shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F5A623" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-[15px] m-0 mb-[2px]">Import Data Siswa</h3>
                        <p class="text-[rgba(255,255,255,0.5)] text-[11px] m-0">Upload file Excel siswa</p>
                    </div>
                </div>

                <button type="button" onclick="closeImportSiswaModal()"
                    class="w-[30px] h-[30px] rounded-lg bg-[rgba(255,255,255,0.12)] hover:bg-[rgba(255,255,255,0.22)] border-none cursor-pointer flex items-center justify-center transition-all duration-200">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Gold accent bar --}}
            <div class="h-[3px]" style="background: linear-gradient(90deg,#E8930A,#F5A623,#E8930A);"></div>

            {{-- Body --}}
            <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data"
                id="importSiswaFormAction" class="p-6 flex flex-col gap-4">
                @csrf
                <input type="hidden" name="_modal" value="import">

                {{-- Format info --}}
                <div class="flex items-start gap-2.5 rounded-xl border border-sky-200 bg-sky-50 px-3.5 py-3">
                    <svg class="w-3.5 h-3.5 text-sky-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex flex-col gap-1.5">
                        <p class="text-xs font-bold text-sky-700">Format Kolom Excel</p>
                        <code class="block bg-white border border-sky-200 rounded-lg px-3 py-1.5 text-[11px] text-sky-800 font-mono tracking-wide">
                            NO | Nama Lengkap | Email | Tanggal Lahir | Agama | Kelas
                        </code>
                        <ul class="flex flex-col gap-0.5 text-[11px] text-sky-600">
                            <li class="font-semibold">NO :<span class="text-amber-400"> OPSIONAL</span></li>
                            <li><span class="font-semibold">Tanggal Lahir</span> : Format DD/MM/YYYY</li>
                            <li><span class="font-semibold">Agama</span> : Islam, Kristen, Katolik, Hindu, Buddha, Konghucu</li>
                            <li><span class="font-semibold">Kelas</span> : Nama kelas persis seperti di database</li>
                            <li>Password otomatis dari tanggal lahir (DDMMYYYY)</li>
                            <li>Email di arsip akan di-restore otomatis</li>
                        </ul>
                    </div>
                </div>

                {{-- File input --}}
                <div class="flex flex-col gap-[7px]">
                    <label class="text-[11.5px] font-bold text-gray-500 uppercase tracking-[0.55px]">
                        File Excel <span class="text-red-500">*</span>
                    </label>
                    <label
                        class="flex flex-col items-center justify-center w-full rounded-[10px] border-2 border-dashed border-gray-200 bg-gray-50 py-6 px-4 cursor-pointer hover:border-[#E8930A] hover:bg-amber-50/40 transition-all duration-200 group"
                        id="importSiswaDropzone">
                        <input type="file" name="file" id="importSiswaFileInput" accept=".xlsx,.xls,.csv" class="hidden"
                            onchange="handleImportSiswaFileChange(this)">
                        <div id="importSiswaPlaceholder" class="flex flex-col items-center gap-2 text-center">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 group-hover:bg-amber-100 flex items-center justify-center transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 group-hover:text-amber-600 transition-colors duration-200">Klik untuk pilih file</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">.xlsx, .xls, atau .csv — Maks. 5MB</p>
                            </div>
                        </div>
                        <div id="importSiswaFilePreview" class="hidden flex-col items-center gap-2 text-center">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p id="importSiswaFileName" class="text-xs font-semibold text-emerald-600"></p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Klik untuk ganti file</p>
                            </div>
                        </div>
                    </label>
                    @if ($errors->has('file') && old('_modal') === 'import')
                        <p class="flex items-center gap-1 text-xs text-red-600">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $errors->first('file') }}
                        </p>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-[10px] pt-[6px] border-t border-gray-100">
                    <button type="button" onclick="closeImportSiswaModal()"
                        class="inline-flex items-center gap-[6px] px-5 py-[9px] text-[13.5px] font-semibold bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-[10px] cursor-pointer transition-all duration-200">
                        Batal
                    </button>
                    <button type="submit" id="importSiswaSubmitBtn"
                        class="inline-flex items-center gap-[6px] px-[22px] py-[9px] text-[13.5px] font-bold text-white border-none rounded-[10px] cursor-pointer transition-all duration-200 shadow-[0_2px_8px_rgba(107,26,43,0.25)] disabled:opacity-60 disabled:cursor-not-allowed hover:opacity-90"
                        style="background: linear-gradient(135deg,#6B1A2B,#9B3045);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                        Import
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function handleImportSiswaFileChange(input) {
        const placeholder = document.getElementById('importSiswaPlaceholder');
        const preview     = document.getElementById('importSiswaFilePreview');
        const fileName    = document.getElementById('importSiswaFileName');

        if (input.files && input.files[0]) {
            fileName.textContent = input.files[0].name;
            placeholder.classList.add('hidden');
            preview.classList.remove('hidden');
            preview.classList.add('flex');
        } else {
            placeholder.classList.remove('hidden');
            preview.classList.add('hidden');
            preview.classList.remove('flex');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const importForm = document.getElementById('importSiswaFormAction');
        const importBtn  = document.getElementById('importSiswaSubmitBtn');

        if (importForm) {
            importForm.addEventListener('submit', () => {
                importBtn.disabled = true;
                importBtn.innerHTML = `
                    <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                    Mengimpor...
                `;
            });
        }
    });
</script>