<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Manajemen Tugas
                </h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">
                    Konten & Evaluasi
                </p>
            </div>
        </div>
    </x-slot>

    <x-slot name="breadcrumb">
        <a href="{{ route('dashboard') }}" class="text-amber-600 hover:text-amber-700 transition">Dashboard</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 font-semibold">Tugas</span>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            
            @if(session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-base">Daftar Tugas</h3>
                    <button onclick="document.getElementById('modal-create').classList.remove('hidden')" 
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Tugas
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Judul Tugas</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Mapel</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Guru Mapel</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Tipe</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Batas Waktu</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($tugas as $t)
                        <tr class="hover:bg-amber-50/40 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900 text-sm">{{ $t->judul }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $t->Mapel?->nama_mapel ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $t->GuruMapel?->Guru?->user->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border-amber-200 uppercase">
                                    {{ $t->tipe_tugas }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700 text-sm">{{ \Carbon\Carbon::parse($t->batas_waktu)->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">
                                @if($t->status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border-emerald-200">Published</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold bg-gray-100 text-gray-700 border-gray-200">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('tugas.rekap', $t->id) }}" 
                                       class="inline-flex items-center gap-1.5 px-3 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 border border-purple-200 rounded-lg transition text-xs font-semibold"
                                       title="Lihat Rekap & Nilai Siswa">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                        </svg>
                                        Rekap & Nilai
                                    </a>
                                    <form action="{{ route('tugas.destroy', $t->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition" 
                                                onclick="return confirm('Hapus tugas ini?')"
                                                title="Hapus">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $tugas->links() }}
                </div>
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