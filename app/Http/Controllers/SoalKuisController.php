<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoalKuis\StoreSoalKuisRequest;
use App\Http\Requests\SoalKuis\UpdateSoalKuisRequest;
use App\Models\Kuis;
use App\Models\SoalKuis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SoalKuisController extends Controller
{
    /**
     * Display a listing of soal for a specific kuis.
     */
    public function index(Kuis $kuis)
    {
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini.');
        }

        $soalList = $kuis->SoalKuis()->orderBy('nomor_soal')->get();

        // Check if kuis has been taken by students (Req 7.9)
        $sudahDikerjakan = $kuis->HasilKuis()->exists();

        return view('soal_kuis.index', compact('kuis', 'soalList', 'sudahDikerjakan'));
    }

    /**
     * Store a newly created soal in storage.
     */
    public function store(StoreSoalKuisRequest $request, Kuis $kuis)
    {
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk menambah soal ke kuis ini.');
        }

        // Guard: Check if kuis has been taken (Req 7.9)
        if ($kuis->HasilKuis()->exists()) {
            return back()->with('error', 'Soal tidak dapat diubah karena kuis sudah dikerjakan oleh siswa.');
        }

        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $validated['id_kuis'] = $kuis->id;

            // Handle file upload for gambar_soal
            if ($request->hasFile('gambar_soal')) {
                $file = $request->file('gambar_soal');
                $path = $file->store('soal_kuis', 'public');
                $validated['gambar_soal'] = $path;
            }

            SoalKuis::create($validated);

            DB::commit();

            return redirect()->route('soal_kuis.index', $kuis)
                ->with('success', 'Soal berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating soal kuis: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan soal.');
        }
    }

    /**
     * Show the form for editing the specified soal.
     */
    public function edit(Kuis $kuis, SoalKuis $soal)
    {
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit soal ini.');
        }

        // Guard: Check if kuis has been taken (Req 7.9)
        if ($kuis->HasilKuis()->exists()) {
            return back()->with('error', 'Soal tidak dapat diubah karena kuis sudah dikerjakan oleh siswa.');
        }

        return view('soal_kuis.edit', compact('kuis', 'soal'));
    }

    /**
     * Update the specified soal in storage.
     */
    public function update(UpdateSoalKuisRequest $request, Kuis $kuis, SoalKuis $soal)
    {
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit soal ini.');
        }

        // Guard: Check if kuis has been taken (Req 7.9)
        if ($kuis->HasilKuis()->exists()) {
            return back()->with('error', 'Soal tidak dapat diubah karena kuis sudah dikerjakan oleh siswa.');
        }

        try {
            DB::beginTransaction();

            $validated = $request->validated();

            // Handle file upload for gambar_soal
            if ($request->hasFile('gambar_soal')) {
                // Delete old image if exists
                if ($soal->gambar_soal && \Storage::disk('public')->exists($soal->gambar_soal)) {
                    \Storage::disk('public')->delete($soal->gambar_soal);
                }
                
                $file = $request->file('gambar_soal');
                $path = $file->store('soal_kuis', 'public');
                $validated['gambar_soal'] = $path;
            }

            $soal->update($validated);

            DB::commit();

            return redirect()->route('soal_kuis.index', $kuis)
                ->with('success', 'Soal berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating soal kuis: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui soal.');
        }
    }

    /**
     * Remove the specified soal from storage and renumber remaining soal.
     */
    public function destroy(Kuis $kuis, SoalKuis $soal)
    {
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus soal ini.');
        }

        // Guard: Check if kuis has been taken (Req 7.9)
        if ($kuis->HasilKuis()->exists()) {
            return back()->with('error', 'Soal tidak dapat diubah karena kuis sudah dikerjakan oleh siswa.');
        }

        try {
            DB::beginTransaction();

            $nomorDihapus = $soal->nomor_soal;
            $soal->delete();

            // Renumber remaining soal (Req 7.8)
            SoalKuis::where('id_kuis', $kuis->id)
                ->where('nomor_soal', '>', $nomorDihapus)
                ->decrement('nomor_soal');

            DB::commit();

            return redirect()->route('soal_kuis.index', $kuis)
                ->with('success', 'Soal berhasil dihapus dan penomoran diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus soal.');
        }
    }
}
