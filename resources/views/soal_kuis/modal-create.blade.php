<!-- Modal Create Soal - Simplified Version -->
<div x-show="showCreateModal" x-cloak class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showCreateModal = false"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Soal Baru</h3>
                
                <!-- Simple Form without Alpine binding -->
                <form id="soal-form" action="{{ route('soal_kuis.store', $kuis) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Soal <span class="text-red-500">*</span></label>
                            <input type="number" name="nomor_soal" required min="1" value="{{ $soalList->count() + 1 }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pertanyaan <span class="text-red-500">*</span></label>
                            <textarea name="pertanyaan" required rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Tulis pertanyaan di sini..."></textarea>
                        </div>

                        <!-- Simplified Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Soal (Opsional)</label>
                            <input type="file" name="gambar_soal" accept="image/*" 
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, JPEG (Max: 2MB)</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
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

                        <div>
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
                </form>
            </div>
            
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="submitSoalForm()"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Simpan Soal
                </button>
                <button type="button" @click="showCreateModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Simplified JavaScript --}}
<script>
function submitSoalForm() {
    console.log('Submit function called');
    
    const form = document.getElementById('soal-form');
    if (!form) {
        console.error('Form not found');
        return;
    }
    
    // Basic validation
    const pertanyaan = form.querySelector('textarea[name="pertanyaan"]');
    const pilihan_a = form.querySelector('input[name="pilihan_a"]');
    const pilihan_b = form.querySelector('input[name="pilihan_b"]');
    const pilihan_c = form.querySelector('input[name="pilihan_c"]');
    const pilihan_d = form.querySelector('input[name="pilihan_d"]');
    const kunci_jawaban = form.querySelector('input[name="kunci_jawaban"]:checked');
    
    if (!pertanyaan || !pertanyaan.value.trim()) {
        alert('Pertanyaan harus diisi');
        pertanyaan.focus();
        return;
    }
    
    if (!pilihan_a || !pilihan_a.value.trim()) {
        alert('Pilihan A harus diisi');
        pilihan_a.focus();
        return;
    }
    
    if (!pilihan_b || !pilihan_b.value.trim()) {
        alert('Pilihan B harus diisi');
        pilihan_b.focus();
        return;
    }
    
    if (!pilihan_c || !pilihan_c.value.trim()) {
        alert('Pilihan C harus diisi');
        pilihan_c.focus();
        return;
    }
    
    if (!pilihan_d || !pilihan_d.value.trim()) {
        alert('Pilihan D harus diisi');
        pilihan_d.focus();
        return;
    }
    
    if (!kunci_jawaban) {
        alert('Kunci jawaban harus dipilih');
        return;
    }
    
    console.log('Form validation passed, submitting...');
    console.log('Form action:', form.action);
    console.log('Form method:', form.method);
    
    // Log form data
    const formData = new FormData(form);
    for (let [key, value] of formData.entries()) {
        console.log(key + ':', value);
    }
    
    form.submit();
}
</script>