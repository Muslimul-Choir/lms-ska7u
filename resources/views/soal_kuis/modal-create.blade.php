<!-- Modal Create Soal -->
<div x-show="showCreateModal" x-cloak class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showCreateModal = false"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form action="{{ route('soal_kuis.store', $kuis) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Soal Baru</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Soal <span class="text-red-500">*</span></label>
                        <input type="number" name="nomor_soal" required min="1"
                            value="{{ $soalList->count() + 1 }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pertanyaan <span class="text-red-500">*</span></label>
                        <textarea name="pertanyaan" required rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Tulis pertanyaan di sini..."></textarea>
                    </div>

                    {{-- Upload Gambar Soal --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Soal (Opsional)
                            <span class="text-xs text-gray-500 font-normal">- Untuk soal yang membutuhkan gambar</span>
                        </label>
                        <div class="mt-1 flex items-center gap-3">
                            <label class="flex-1 cursor-pointer">
                                <div class="flex items-center justify-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-lg appearance-none hover:border-rose-500 focus:outline-none">
                                    <div class="flex flex-col items-center space-y-2">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-sm text-gray-500">
                                            <span class="font-semibold text-rose-600">Klik untuk upload</span> atau drag & drop
                                        </span>
                                        <span class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</span>
                                    </div>
                                </div>
                                <input type="file" name="gambar_soal" accept="image/png,image/jpeg,image/jpg" class="hidden" onchange="previewImageCreate(this)">
                            </label>
                        </div>
                        {{-- Image Preview --}}
                        <div id="image-preview-create" class="mt-3 hidden">
                            <div class="relative inline-block">
                                <img id="preview-img-create" src="" alt="Preview" class="h-32 rounded-lg border-2 border-gray-300 shadow-sm">
                                <button type="button" onclick="removeImageCreate()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan A <span class="text-red-500">*</span></label>
                            <input type="text" name="pilihan_a" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan B <span class="text-red-500">*</span></label>
                            <input type="text" name="pilihan_b" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan C <span class="text-red-500">*</span></label>
                            <input type="text" name="pilihan_c" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan D <span class="text-red-500">*</span></label>
                            <input type="text" name="pilihan_d" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kunci Jawaban <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="kunci_jawaban" value="A" required class="form-radio text-blue-600">
                                <span class="ml-2">A</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="kunci_jawaban" value="B" required class="form-radio text-blue-600">
                                <span class="ml-2">B</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="kunci_jawaban" value="C" required class="form-radio text-blue-600">
                                <span class="ml-2">C</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="kunci_jawaban" value="D" required class="form-radio text-blue-600">
                                <span class="ml-2">D</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Simpan Soal
                    </button>
                    <button type="button" @click="showCreateModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript for Image Preview --}}
<script>
function previewImageCreate(input) {
    const preview = document.getElementById('image-preview-create');
    const previewImg = document.getElementById('preview-img-create');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImageCreate() {
    const input = document.querySelector('input[name="gambar_soal"]');
    const preview = document.getElementById('image-preview-create');
    
    input.value = '';
    preview.classList.add('hidden');
}
</script>
