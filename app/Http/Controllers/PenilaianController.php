<?php
namespace App\Http\Controllers;

use App\Models\Penilaian;

class PenilaianController extends Controller
{
    public function index()
    {
        $penilaian = Penilaian::with(['pengumpulanTugas.siswa', 'pengumpulanTugas.tugas', 'guru'])->latest()->paginate(15);
        return view('penilaian.index', compact('penilaian'));
    }
}