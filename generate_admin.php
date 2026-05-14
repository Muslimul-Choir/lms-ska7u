<?php

$dir = __DIR__;

// Controllers
$controllers = [
    'MateriController' => <<<'EOT'
<?php
namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        $materis = Materi::with('pertemuan')->latest()->paginate(10);
        $pertemuans = Pertemuan::all();
        return view('materi.index', compact('materis', 'pertemuans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_materi' => 'required|in:dokumen,video,link,lainnya',
            'file_url' => 'nullable|file|mimes:pdf,mp4,doc,docx|max:50000',
        ]);

        if ($request->hasFile('file_url')) {
            $validated['file_url'] = $request->file('file_url')->store('materi_files', 'public');
        }

        Materi::create($validated);
        return back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function update(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_materi' => 'required|in:dokumen,video,link,lainnya',
            'file_url' => 'nullable|file|mimes:pdf,mp4,doc,docx|max:50000',
        ]);

        if ($request->hasFile('file_url')) {
            if ($materi->file_url) Storage::disk('public')->delete($materi->file_url);
            $validated['file_url'] = $request->file('file_url')->store('materi_files', 'public');
        }

        $materi->update($validated);
        return back()->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        if ($materi->file_url) Storage::disk('public')->delete($materi->file_url);
        $materi->delete();
        return back()->with('success', 'Materi berhasil dihapus.');
    }
}
EOT,

    'TugasController' => <<<'EOT'
<?php
namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Pertemuan;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function index()
    {
        $tugas = Tugas::with(['pertemuan', 'guru'])->latest()->paginate(10);
        $pertemuans = Pertemuan::all();
        $gurus = Guru::all();
        return view('tugas.index', compact('tugas', 'pertemuans', 'gurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'id_guru' => 'required|exists:guru,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_tugas' => 'required|in:individu,kelompok',
            'batas_waktu' => 'required|date',
            'nilai_maksimal' => 'required|numeric',
            'status' => 'required|in:draft,published,closed',
            'allow_late' => 'boolean',
            'file_url' => 'nullable|file|max:50000',
        ]);

        $validated['allow_late'] = $request->has('allow_late');

        if ($request->hasFile('file_url')) {
            $validated['file_url'] = $request->file('file_url')->store('tugas_files', 'public');
        }

        Tugas::create($validated);
        return back()->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function update(Request $request, Tugas $tuga) // Laravel singularizes tugas to tuga by default in route binding if not customized
    {
        $tugas = $tuga;
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'id_guru' => 'required|exists:guru,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_tugas' => 'required|in:individu,kelompok',
            'batas_waktu' => 'required|date',
            'nilai_maksimal' => 'required|numeric',
            'status' => 'required|in:draft,published,closed',
            'allow_late' => 'boolean',
            'file_url' => 'nullable|file|max:50000',
        ]);

        $validated['allow_late'] = $request->has('allow_late');

        if ($request->hasFile('file_url')) {
            if ($tugas->file_url) Storage::disk('public')->delete($tugas->file_url);
            $validated['file_url'] = $request->file('file_url')->store('tugas_files', 'public');
        }

        $tugas->update($validated);
        return back()->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tuga)
    {
        $tugas = $tuga;
        if ($tugas->file_url) Storage::disk('public')->delete($tugas->file_url);
        $tugas->delete();
        return back()->with('success', 'Tugas berhasil dihapus.');
    }
}
EOT,

    'ActivityLogController' => <<<'EOT'
<?php
namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(15);
        return view('activity_log.index', compact('logs'));
    }
}
EOT,
    
    'PengumpulanTugasController' => <<<'EOT'
<?php
namespace App\Http\Controllers;

use App\Models\PengumpulanTugas;

class PengumpulanTugasController extends Controller
{
    public function index()
    {
        $pengumpulans = PengumpulanTugas::with(['tugas', 'siswa'])->latest()->paginate(15);
        return view('pengumpulan_tugas.index', compact('pengumpulans'));
    }
}
EOT,

    'PenilaianController' => <<<'EOT'
<?php
namespace App\Http\Controllers;

use App\Models\Penilaian;

class PenilaianController extends Controller
{
    public function index()
    {
        $penilaians = Penilaian::with(['pengumpulanTugas.siswa', 'pengumpulanTugas.tugas', 'guru'])->latest()->paginate(15);
        return view('penilaian.index', compact('penilaians'));
    }
}
EOT,
];

foreach ($controllers as $name => $content) {
    file_put_contents("$dir/app/Http/Controllers/$name.php", $content);
}

// Layout for the new views
$views = [
    'materi/index.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Materi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>
                @endif

                <button onclick="document.getElementById('modal-create').classList.remove('hidden')" class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Materi</button>
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertemuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($materis as $m)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $m->judul }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Pertemuan {{ $m->pertemuan->nomor_pertemuan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap uppercase">{{ $m->tipe_materi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('materi.destroy', $m->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus materi ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $materis->links() }}</div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div id="modal-create" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modal-create').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Tambah Materi Baru</h3>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Pertemuan</label>
                            <select name="id_pertemuan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($pertemuans as $p)
                                    <option value="{{ $p->id }}">Pertemuan {{ $p->nomor_pertemuan }} (Jadwal: {{ $p->id_jadwal }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Judul Materi</label>
                            <input type="text" name="judul" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Tipe Materi</label>
                            <select name="tipe_materi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="dokumen">Dokumen (PDF)</option>
                                <option value="video">Video</option>
                                <option value="link">Link</option>
                                <option value="lainnya">Lainnya (Teks/Artikel)</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Deskripsi/Artikel</label>
                            <textarea name="deskripsi" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">File (Opsional jika tipe video/dokumen)</label>
                            <input type="file" name="file_url" class="mt-1 block w-full">
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
</x-app-layout>
EOT,

    'tugas/index.blade.php' => <<<'EOT'
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
                                <select name="id_pertemuan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach($pertemuans as $p)
                                        <option value="{{ $p->id }}">Pertemuan {{ $p->nomor_pertemuan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Guru</label>
                                <select name="id_guru" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->id }}">{{ $g->user->name ?? 'Guru '.$g->id }}</option>
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
                                <label class="block text-sm font-medium text-gray-700">Batas Waktu</label>
                                <input type="datetime-local" name="batas_waktu" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
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

                        <div class="mt-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="allow_late" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                                <span class="ml-2 text-sm text-gray-600">Izinkan Pengumpulan Terlambat?</span>
                            </label>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">File Lampiran Tugas</label>
                            <input type="file" name="file_url" class="mt-1 block w-full">
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
</x-app-layout>
EOT,

    'activity_log/index.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Activity Log</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($logs as $log)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $log->user->name ?? 'System' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $log->modul }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
EOT,

    'pengumpulan_tugas/index.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pengumpulan Tugas</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead><tr><th>Tugas</th><th>Siswa</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($pengumpulans as $p)
                        <tr>
                            <td>{{ $p->tugas->judul ?? '-' }}</td>
                            <td>{{ $p->siswa->user->name ?? '-' }}</td>
                            <td>{{ $p->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pengumpulans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
EOT,

    'penilaian/index.blade.php' => <<<'EOT'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Penilaian Siswa</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead><tr><th>Tugas</th><th>Siswa</th><th>Nilai</th></tr></thead>
                    <tbody>
                        @foreach($penilaians as $p)
                        <tr>
                            <td>{{ $p->pengumpulanTugas->tugas->judul ?? '-' }}</td>
                            <td>{{ $p->pengumpulanTugas->siswa->user->name ?? '-' }}</td>
                            <td>{{ $p->nilai }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $penilaians->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
EOT,
];

foreach ($views as $name => $content) {
    $dirPath = dirname("$dir/resources/views/$name");
    if (!is_dir($dirPath)) {
        mkdir($dirPath, 0777, true);
    }
    file_put_contents("$dir/resources/views/$name", $content);
}

echo "Controllers and Views generated successfully.\n";
