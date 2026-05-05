<?php
namespace App\Http\Controllers;

use App\Models\PengumpulanTugas;

class PengumpulanTugasController extends Controller
{
    public function index()
    {
        $pengumpulanTugas = PengumpulanTugas::with(['tugas', 'siswa'])->latest()->paginate(15);
        return view('pengumpulan_tugas.index', compact('pengumpulanTugas'));
    }
}