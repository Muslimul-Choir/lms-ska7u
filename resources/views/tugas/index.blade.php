<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Tugas</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>
                @endif

                <button onclick="document.getElementById('modal-create').classList.remove('hidden')" class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buat Tugas</button>
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Tugas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mapel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru Mapel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tugas as $t)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $t->judul }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $t->Mapel?->nama_mapel ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $t->GuruMapel?->Guru?->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap uppercase">{{ $t->tipe_tugas }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($t->batas_waktu)->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($t->status) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('tugas.destroy', $t->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus tugas ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $tugas->links() }}</div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div id="modal-create" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modal-create').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Buat Tugas Baru</h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Pertemuan</label>
                                <select name="id_pertemuan" id="id_pertemuan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="updateMapelAndGuruMapel()">
                                    <option value="">-- Pilih Pertemuan --</option>
                                    @foreach($pertemuans as $p)
                                        <option value="{{ $p->id }}" data-guru-mapel-id="{{ $p->JadwalBelajar?->id_guru_mapel }}" data-mapel-id="{{ $p->JadwalBelajar?->id_mapel }}">Pertemuan {{ $p->nomor_pertemuan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Guru</label>
                                <select name="id_guru" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->id }}">{{ $g->user->name ?? 'Guru '.$g->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Mapel</label>
                                <select name="id_mapel" id="id_mapel" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Auto dari Pertemuan --</option>
                                    @foreach($mapels as $m)
                                        <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Guru Mapel</label>
                                <select name="id_guru_mapel" id="id_guru_mapel" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Auto dari Pertemuan --</option>
                                    @foreach($guruMapels as $gm)
                                        <option value="{{ $gm->id }}">{{ $gm->Mapel?->nama_mapel ?? '-' }} - {{ $gm->Guru?->user->name ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Judul Tugas</label>
                            <input type="text" name="judul" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Tipe Tugas</label>
                                <select name="tipe_tugas" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="individu">Individu</option>
                                    <option value="kelompok">Kelompok</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Tipe File</label>
                                <select name="tipe_file" id="tipe_file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="toggleFileInput()">
                                    <option value="file">Upload File</option>
                                    <option value="link">Tautan/Link</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Batas Waktu</label>
                            <input type="datetime-local" name="batas_waktu" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Nilai Maksimal</label>
                                <input type="number" name="nilai_maksimal" value="100" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>

                        <!-- File Input -->
                        <div id="file-upload-section" class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">File Lampiran Tugas</label>
                            <input type="file" name="file_url" id="file_url" class="mt-1 block w-full">
                        </div>

                        <!-- Link Input -->
                        <div id="link-input-section" class="mt-4 hidden">
                            <label class="block text-sm font-medium text-gray-700">Tautan (URL)</label>
                            <input type="url" name="file_url_link" id="file_url_link" placeholder="https://..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mt-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="allow_late" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                                <span class="ml-2 text-sm text-gray-600">Izinkan Pengumpulan Terlambat?</span>
                            </label>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                        <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateMapelAndGuruMapel() {
            const select = document.getElementById('id_pertemuan');
            const selected = select.options[select.selectedIndex];
            const guruMapelId = selected.dataset.guruMapelId;
            const mapelId = selected.dataset.mapelId;

            if (guruMapelId) {
                document.getElementById('id_guru_mapel').value = guruMapelId;
            }
            if (mapelId) {
                document.getElementById('id_mapel').value = mapelId;
            }
        }

        function toggleFileInput() {
            const tipeFile = document.getElementById('tipe_file').value;
            const fileUploadSection = document.getElementById('file-upload-section');
            const linkInputSection = document.getElementById('link-input-section');
            const fileInput = document.getElementById('file_url');
            const linkInput = document.getElementById('file_url_link');

            if (tipeFile === 'file') {
                fileUploadSection.classList.remove('hidden');
                linkInputSection.classList.add('hidden');
                fileInput.name = 'file_url';
                fileInput.required = true;
                linkInput.name = '';
                linkInput.required = false;
            } else {
                fileUploadSection.classList.add('hidden');
                linkInputSection.classList.remove('hidden');
                fileInput.name = '';
                fileInput.required = false;
                linkInput.name = 'file_url';
                linkInput.required = true;
            }
        }
    </script>
</x-app-layout>