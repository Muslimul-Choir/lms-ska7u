<div id="modalEdit" style="display:none; position:fixed; inset:0; z-index:9999;">
    <div style="position:absolute; inset:0; background:rgba(0,0,0,0.45);" id="overlayEdit"></div>
    <div style="position:relative; z-index:10; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Edit Semester</h3>
                <button type="button" id="closeEdit" class="text-gray-400 hover:text-gray-700 text-2xl leading-none font-bold">&times;</button>
            </div>

            <form id="formEdit" action="" method="POST" class="px-6 py-5 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Semester <span class="text-red-500">*</span>
                    </label>

                    <select id="editNamaSemester" name="nama_semester"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        
                        <option value="">-- Pilih Semester --</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>

                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" id="cancelEdit"
                            class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition">
                        Update
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>