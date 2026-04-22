<div id="modalCreate" style="display:none; position:fixed; inset:0; z-index:9999;">
    <div style="position:absolute; inset:0; background:rgba(0,0,0,0.45);" id="overlayCreate"></div>
    <div style="position:relative; z-index:10; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Tambah Semester</h3>
                <button type="button" id="closeCreate" class="text-gray-400 hover:text-gray-700 text-2xl leading-none font-bold">&times;</button>
            </div>

            <form action="{{ route('semester.store') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Semester <span class="text-red-500">*</span>
                    </label>

                    <select name="nama_semester"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('nama_semester') border-red-400 @enderror">
                        
                        <option value="">-- Pilih Semester --</option>
                        <option value="Ganjil" {{ old('nama_semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('nama_semester') == 'Genap' ? 'selected' : '' }}>Genap</option>

                    </select>

                    @error('nama_semester')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" id="cancelCreate"
                            class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>