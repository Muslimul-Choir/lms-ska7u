<!-- Modal Edit Soal -->
<div x-show="showEditModal" x-cloak class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showEditModal = false"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form :action="`{{ route('soal_kuis.index', $kuis) }}/${editData.id}`" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Soal</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Soal <span class="text-red-500">*</span></label>
                        <input type="number" name="nomor_soal" required min="1" x-model="editData.nomor_soal"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pertanyaan <span class="text-red-500">*</span></label>
                        <textarea name="pertanyaan" required rows="3" x-model="editData.pertanyaan"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan A <span class="text-red-500">*</span></label>
                            <input type="text" name="pilihan_a" required x-model="editData.pilihan_a"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan B <span class="text-red-500">*</span></label>
                            <input type="text" name="pilihan_b" required x-model="editData.pilihan_b"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan C <span class="text-red-500">*</span></label>
                            <input type="text" name="pilihan_c" required x-model="editData.pilihan_c"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan D <span class="text-red-500">*</span></label>
                            <input type="text" name="pilihan_d" required x-model="editData.pilihan_d"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kunci Jawaban <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="kunci_jawaban" value="A" required x-model="editData.kunci_jawaban" class="form-radio text-blue-600">
                                <span class="ml-2">A</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="kunci_jawaban" value="B" required x-model="editData.kunci_jawaban" class="form-radio text-blue-600">
                                <span class="ml-2">B</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="kunci_jawaban" value="C" required x-model="editData.kunci_jawaban" class="form-radio text-blue-600">
                                <span class="ml-2">C</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="kunci_jawaban" value="D" required x-model="editData.kunci_jawaban" class="form-radio text-blue-600">
                                <span class="ml-2">D</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Simpan Perubahan
                    </button>
                    <button type="button" @click="showEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
