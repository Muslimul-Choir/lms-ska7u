<div id="modalImportGuru" class="fixed inset-0 z-50 hidden">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeImportGuruModal()"></div>

    <!-- Modal -->
    <div class="relative flex items-center justify-center min-h-full p-4 pointer-events-none">

        <!-- Panel -->
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl pointer-events-auto">

            <!-- Header -->
            <div class="flex justify-between items-center px-5 py-4 border-b">
                <h3 class="text-sm font-semibold">Import Data Guru</h3>
                <button onclick="closeImportGuruModal()">✕</button>
            </div>

            <!-- Body -->
            <div class="p-5">
                <div class="bg-blue-50 border mb-4 border-blue-200 rounded-lg p-4 text-xs text-blue-800">
                    <p class="font-semibold mb-1">Format Excel:</p>
                    <code class="block mt-1 bg-white px-2 py-1 rounded border text-[11px]">
                        nama_lengkap | email | status_pengajar
                    </code>
                    <p class="mt-2">Status: <b>pengajar</b>, <b>walikelas</b>, atau <b>keduanya</b></p>
                </div>
                
                <form action="{{ route('guru.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_modal" value="import">

                    <input type="file" name="file" class="w-full border rounded px-3 py-2 mb-3">

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeImportGuruModal()" class="px-3 py-1 bg-gray-200 rounded">
                            Batal
                        </button>

                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">
                            Import
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
