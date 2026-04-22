<div id="modalCreate" style="display:none; position:fixed; inset:0; z-index:9999;">
    <div style="position:absolute; inset:0; background:rgba(0,0,0,0.45);" id="overlayCreate"></div>
    <div style="position:relative; z-index:10; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Tambah Tingkatan</h3>
                <button type="button" id="closeCreate" class="text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
            </div>

            <form action="{{ route('tingkatan.store') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf

                {{-- Nama Tingkatan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Tingkatan <span class="text-red-500">*</span>
                    </label>

                    <select name="nama_tingkatan"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 @error('nama_tingkatan') border-red-400 @enderror">
                        
                        <option value="">-- Pilih Tingkatan --</option>
                        <option value="X" {{ old('nama_tingkatan') == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ old('nama_tingkatan') == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ old('nama_tingkatan') == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>

                    @error('nama_tingkatan')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 @error('keterangan') border-red-400 @enderror"
                        placeholder="Contoh: Kelas 10">{{ old('keterangan') }}</textarea>

                    @error('keterangan')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" id="cancelCreate"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>