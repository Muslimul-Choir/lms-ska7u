<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\Pertemuan;
use App\Models\Materi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaMateriController extends Controller
{
    /**
     * Display a listing of subjects for the student's class.
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get subjects taught in the student's class
        $mapels = Mapel::whereHas('GuruMapel', function ($query) use ($siswa) {
            $query->where('id_kelas', $siswa->id_kelas);
        })->get();

        return view('siswa.materi.index', compact('siswa', 'mapels'));
    }

    /**
     * Display meetings and content under a specific subject.
     */
    public function showMapel($id_mapel)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        $mapel = Mapel::findOrFail($id_mapel);

        // Fetch meetings for this subject in the student's class
        $pertemuans = Pertemuan::whereHas('JadwalBelajar', function ($query) use ($siswa, $id_mapel) {
            $query->where('id_kelas', $siswa->id_kelas)
                ->where(function ($sub) use ($id_mapel) {
                    $sub->where('id_mapel', $id_mapel)
                        ->orWhereHas('GuruMapel', function ($gm) use ($id_mapel) {
                            $gm->where('id_mapel', $id_mapel);
                        });
                });
        })
        ->with(['materis', 'tugas' => function ($q) {
            $q->where('status', 'published');
        }])
        ->orderBy('nomor_pertemuan')
        ->get();

        return view('siswa.materi.show_mapel', compact('siswa', 'mapel', 'pertemuans'));
    }

    /**
     * Show a specific material content.
     */
    public function showMateri($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        $materi = Materi::findOrFail($id);

        // Validate access
        if ($materi->guruMapel && $materi->guruMapel->id_kelas !== $siswa->id_kelas) {
            abort(403, 'Anda tidak memiliki akses ke materi ini.');
        }

        return view('siswa.materi.show', compact('siswa', 'materi'));
    }
}
