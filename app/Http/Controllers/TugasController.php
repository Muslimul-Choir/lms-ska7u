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
        $tugas = Tugas::with(['pertemuan', 'guru', 'Mapel', 'GuruMapel'])->latest()->paginate(10);
        $pertemuans = Pertemuan::with('JadwalBelajar.GuruMapel.Mapel')->get();
        $gurus = Guru::all();
        $mapels = \App\Models\Mapel::all();
        $guruMapels = \App\Models\GuruMapel::with(['Mapel', 'Guru'])->get();
        return view('tugas.index', compact('tugas', 'pertemuans', 'gurus', 'mapels', 'guruMapels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'id_guru' => 'required|exists:guru,id',
            'id_mapel' => 'nullable|exists:mapel,id',
            'id_guru_mapel' => 'nullable|exists:guru_mapel,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_tugas' => 'required|in:individu,kelompok',
            'tipe_file' => 'required|in:tanpa,dokumen,video,link',
            'file_url' => $request->input('tipe_file') === 'link' ? 'required|url' : ($request->input('tipe_file') === 'tanpa' ? 'nullable' : 'nullable|file|mimes:pdf,doc,docx,mp4|max:50000'),
            'batas_waktu' => 'required|date',
            'nilai_maksimal' => 'required|numeric',
            'status' => 'required|in:draft,published,closed',
            'allow_late' => 'boolean',
        ]);

        $validated['allow_late'] = $request->has('allow_late');

        if ($request->hasFile('file_url') && in_array($validated['tipe_file'], ['dokumen', 'video'])) {
            $validated['file_url'] = $request->file('file_url')->store('tugas_files', 'public');
        } elseif ($validated['tipe_file'] === 'link') {
            $validated['file_url'] = $request->input('file_url');
        } else {
            // For tanpa (no file) or if no file uploaded
            $validated['file_url'] = null;
        }

        // If mapel and guru_mapel are not manually selected, get from pertemuan's jadwal_belajar
        if (!$validated['id_guru_mapel'] || !$validated['id_mapel']) {
            $pertemuan = \App\Models\Pertemuan::with('JadwalBelajar.GuruMapel')->find($validated['id_pertemuan']);
            if ($pertemuan && $pertemuan->JadwalBelajar) {
                if (!$validated['id_guru_mapel']) {
                    $validated['id_guru_mapel'] = $pertemuan->JadwalBelajar->id_guru_mapel;
                }
                if (!$validated['id_mapel']) {
                    $validated['id_mapel'] = $pertemuan->JadwalBelajar->id_mapel;
                }
            }
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
            'id_mapel' => 'nullable|exists:mapel,id',
            'id_guru_mapel' => 'nullable|exists:guru_mapel,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_tugas' => 'required|in:individu,kelompok',
            'tipe_file' => 'required|in:tanpa,dokumen,video,link',
            'file_url' => $request->input('tipe_file') === 'link' ? 'required|url' : ($request->input('tipe_file') === 'tanpa' ? 'nullable' : 'nullable|file|mimes:pdf,doc,docx,mp4|max:50000'),
            'batas_waktu' => 'required|date',
            'nilai_maksimal' => 'required|numeric',
            'status' => 'required|in:draft,published,closed',
            'allow_late' => 'boolean',
        ]);

        $validated['allow_late'] = $request->has('allow_late');

        if ($request->hasFile('file_url') && in_array($validated['tipe_file'], ['dokumen', 'video'])) {
            if ($tugas->file_url && !str_starts_with($tugas->file_url, 'http')) {
                Storage::disk('public')->delete($tugas->file_url);
            }
            $validated['file_url'] = $request->file('file_url')->store('tugas_files', 'public');
        } elseif ($validated['tipe_file'] === 'link') {
            $validated['file_url'] = $request->input('file_url');
        } else {
            // For tanpa (no file) or if no new file uploaded
            if ($validated['tipe_file'] === 'tanpa') {
                // Delete old file if switching to tanpa
                if ($tugas->file_url && !str_starts_with($tugas->file_url, 'http')) {
                    Storage::disk('public')->delete($tugas->file_url);
                }
                $validated['file_url'] = null;
            }
            // If file type is dokumen/video but no new file uploaded, keep existing file
        }

        // If mapel and guru_mapel are not manually selected, get from pertemuan's jadwal_belajar
        if (!$validated['id_guru_mapel'] || !$validated['id_mapel']) {
            $pertemuan = \App\Models\Pertemuan::with('JadwalBelajar.GuruMapel')->find($validated['id_pertemuan']);
            if ($pertemuan && $pertemuan->JadwalBelajar) {
                if (!$validated['id_guru_mapel']) {
                    $validated['id_guru_mapel'] = $pertemuan->JadwalBelajar->id_guru_mapel;
                }
                if (!$validated['id_mapel']) {
                    $validated['id_mapel'] = $pertemuan->JadwalBelajar->id_mapel;
                }
            }
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