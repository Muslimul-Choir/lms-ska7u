<?php

namespace App\Http\Controllers;

use App\Models\JadwalBelajar;
use App\Models\Pertemuan;
use App\Models\Materi;
use Illuminate\Http\Request;

class RuangBelajarController extends Controller
{
    public function show($jadwalbelajar_id, $materi_id = null)
    {
        $jadwalbelajar = JadwalBelajar::with(['pertemuan' => function($q) {
            $q->orderBy('nomor_pertemuan', 'asc');
        }, 'pertemuan.materi' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])->findOrFail($jadwalbelajar_id);

        $materi = null;
        if ($materi_id) {
            $materi = Materi::findOrFail($materi_id);
        } else {
            // Ambil materi pertama dari pertemuan pertama
            foreach ($jadwalbelajar->pertemuan as $pertemuan) {
                if ($pertemuan->materi->isNotEmpty()) {
                    $materi = $pertemuan->materi->first();
                    break;
                }
            }
        }

        if (!$materi) {
            return back()->with('error', 'Belum ada materi yang tersedia untuk kelas ini.');
        }

        // Navigasi Prev/Next
        $allMateri = $jadwalbelajar->pertemuan->flatMap->materi;
        $currentIndex = $allMateri->search(fn($item) => $item->id === $materi->id);

        $prevMateri = $currentIndex > 0 ? $allMateri[$currentIndex - 1] : null;
        $nextMateri = $currentIndex < $allMateri->count() - 1 ? $allMateri[$currentIndex + 1] : null;

        return view('ruang_belajar.show', compact('jadwalbelajar', 'materi', 'prevMateri', 'nextMateri', 'allMateri'));
    }

    public function markAsDone(Request $request, $materi_id)
    {
        // Di sini nantinya kita simpan progress belajar siswa ke database
        return redirect()->back()->with('success', 'Materi berhasil ditandai selesai!');
    }
}
