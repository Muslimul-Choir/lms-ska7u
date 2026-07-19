<?php

namespace App\Http\Controllers;

use App\Events\ContentUpdated;
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
        // Add comprehensive logging at the start
        \Log::info('[SOAL STORE START] Request received', [
            'method' => $request->method(),
            'url' => $request->url(),
            'all_data' => $request->all(),
            'kuis_id' => $kuis->id,
            'kuis_title' => $kuis->judul
        ]);
        
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            \Log::warning('[SOAL STORE] Authorization failed', [
                'user_id' => $user->id,
                'user_guru_id' => $user->Guru?->id,
                'kuis_guru_id' => $kuis->id_guru
            ]);
            abort(403, 'Anda tidak memiliki akses untuk menambah soal ke kuis ini.');
        }

        // Guard: Check if kuis has been taken (Req 7.9)
        if ($kuis->HasilKuis()->exists()) {
            \Log::warning('[SOAL STORE] Kuis already taken by students', ['kuis_id' => $kuis->id]);
            return back()->with('error', 'Soal tidak dapat diubah karena kuis sudah dikerjakan oleh siswa.');
        }

        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $validated['id_kuis'] = $kuis->id;

            // Log incoming data for debugging
            \Log::info('[SOAL CREATE] Creating soal with data', [
                'kuis_id' => $kuis->id,
                'user_id' => $user->id,
                'validated_data' => $validated
            ]);

            // Handle file upload for gambar_soal
            if ($request->hasFile('gambar_soal')) {
                $file = $request->file('gambar_soal');
                \Log::info('[SOAL CREATE] Processing file upload', [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType()
                ]);
                
                $path = $file->store('soal_kuis', 'public');
                $validated['gambar_soal'] = $path;
                \Log::info('[SOAL CREATE] Image uploaded', ['path' => $path]);
            }

            $soal = SoalKuis::create($validated);
            
            \Log::info('[SOAL CREATE] Soal created in database', [
                'soal_id' => $soal->id,
                'kuis_id' => $kuis->id,
                'nomor_soal' => $soal->nomor_soal,
                'created_at' => $soal->created_at
            ]);
            
            // Auto-publish kuis jika ini soal pertama dan waktu rilis sudah lewat
            $this->autoPublishKuisIfReady($kuis);
            
            DB::commit();
            
            \Log::info('[SOAL CREATE] Transaction committed successfully', [
                'soal_id' => $soal->id,
                'kuis_id' => $kuis->id
            ]);

            // Broadcast content update event for quiz
            $kelas_id = $kuis->Pertemuan?->JadwalBelajar?->id_kelas;
            if ($kelas_id) {
                event(new ContentUpdated('soal_kuis', 'created', $soal->id, [$kelas_id], [
                    'kuis_id' => $kuis->id,
                    'nomor_soal' => $soal->nomor_soal
                ]));
            }

            // Hitung total soal setelah penambahan
            $totalSoal = $kuis->SoalKuis()->count();
            
            // Redirect dengan konfirmasi dan opsi publish
            if ($kuis->status === 'draft') {
                return redirect()->route('soal_kuis.index', $kuis)
                    ->with('success', "Soal berhasil ditambahkan! Kuis sekarang memiliki {$totalSoal} soal.")
                    ->with('show_publish_confirmation', true)
                    ->with('total_soal', $totalSoal);
            }

            return redirect()->route('soal_kuis.index', $kuis)
                ->with('success', 'Soal berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('[SOAL CREATE] Exception occurred', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Terjadi kesalahan saat menambahkan soal: ' . $e->getMessage());
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

            // Broadcast content update event for quiz
            $kelas_id = $kuis->Pertemuan?->JadwalBelajar?->id_kelas;
            if ($kelas_id) {
                event(new ContentUpdated('soal_kuis', 'updated', $soal->id, [$kelas_id], [
                    'kuis_id' => $kuis->id,
                    'nomor_soal' => $soal->nomor_soal
                ]));
            }

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

            // Broadcast content update event for quiz
            $kelas_id = $kuis->Pertemuan?->JadwalBelajar?->id_kelas;
            if ($kelas_id) {
                event(new ContentUpdated('soal_kuis', 'deleted', $soal->id, [$kelas_id]));
            }

            return redirect()->route('soal_kuis.index', $kuis)
                ->with('success', 'Soal berhasil dihapus dan penomoran diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus soal.');
        }
    }
    
    /**
     * Auto-publish kuis if it has soal and release time has passed
     */
    private function autoPublishKuisIfReady(Kuis $kuis)
    {
        // TIDAK auto-publish - biarkan guru yang memutuskan
        // Hanya berikan informasi via session untuk konfirmasi
        
        $soalCount = $kuis->SoalKuis()->count();
        
        \Log::info('[SOAL CREATE] Soal added, kuis remains draft for manual publish', [
            'kuis_id' => $kuis->id,
            'soal_count' => $soalCount,
            'status' => $kuis->status
        ]);
    }
}
