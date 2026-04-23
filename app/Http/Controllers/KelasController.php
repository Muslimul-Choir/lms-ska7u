<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kelas\StoreKelasRequest;
use App\Http\Requests\Kelas\UpdateKelasRequest;
use App\Models\Bagian;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Tingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Tampilkan daftar kelas (aktif).
     */
    public function index(Request $request)
    {
        $query = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian', 'TahunAjaran', 'WaliKelas'])
            ->withCount('Siswa'); 

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('Tingkatan', fn($q) => $q->where('nama_tingkatan', 'like', "%{$search}%"))
                ->orWhereHas('Jurusan', fn($q) => $q->where('nama_jurusan', 'like', "%{$search}%"))
                ->orWhereHas('Bagian', fn($q) => $q->where('nama_bagian', 'like', "%{$search}%"));
        }

        // Filter tahun ajaran
        if ($request->filled('id_tahun_ajaran')) {
            $query->where('id_tahun_ajaran', $request->id_tahun_ajaran);
        }

        // Filter tingkatan
        if ($request->filled('id_tingkatan')) {
            $query->where('id_tingkatan', $request->id_tingkatan);
        }

        // Filter jurusan
        if ($request->filled('id_jurusan')) {
            $query->where('id_jurusan', $request->id_jurusan);
        }

        $kelasList = $query->latest()->paginate(10)->withQueryString();

        // Data untuk dropdown form
        $tingkatanList  = Tingkatan::orderBy('nama_tingkatan')->get();
        $jurusanList    = Jurusan::orderBy('nama_jurusan')->get();
        $bagianList     = Bagian::orderBy('nama_bagian')->get();
        $tahunAjaranList = TahunAjaran::orderBy('nama_tahun', 'desc')->get();
        $guruList       = Guru::whereIn('status_pengajar', ['walikelas', 'keduanya'])
            ->orderBy('nama_lengkap')
            ->get();

        return view('kelas.index', compact(
            'kelasList',
            'tingkatanList',
            'jurusanList',
            'bagianList',
            'tahunAjaranList',
            'guruList'
        ));
    }

    /**
     * Simpan kelas baru.
     */
    public function store(StoreKelasRequest $request)
    {
        DB::beginTransaction();
        try {
            Kelas::create($request->validated());
            DB::commit();
            return redirect()->route('kelas.index')
                ->with('success', 'Kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('kelas.index')
                ->with('error', 'Gagal menambahkan kelas. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan form edit (digunakan oleh modal).
     */
    public function edit(Kelas $kelas)
    {
        $kelas->load(['Tingkatan', 'Jurusan', 'Bagian', 'TahunAjaran', 'WaliKelas']);
        return response()->json($kelas);
    }

    /**
     * Update kelas.
     */
    public function update(UpdateKelasRequest $request, Kelas $kelas)
    {
        DB::beginTransaction();
        try {
            $kelas->update($request->validated());
            DB::commit();
            return redirect()->route('kelas.index')
                ->with('success', 'Kelas berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('kelas.index')
                ->with('error', 'Gagal memperbarui kelas. Silakan coba lagi.');
        }
    }

    /**
     * Soft delete kelas.
     */
    public function destroy(Kelas $kelas)
    {
        // Pastikan tidak ada relasi aktif sebelum hapus
        if ($kelas->siswa()->exists()) {
            return redirect()->route('kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa terdaftar.');
        }

        $kelas->delete();
        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil dipindahkan ke tempat sampah.');
    }

    /**
     * Tampilkan data yang sudah dihapus (trash).
     */
    public function trash(Request $request)
    {
        $query = Kelas::onlyTrashed()
            ->with(['Tingkatan', 'Jurusan', 'Bagian', 'TahunAjaran', 'WaliKelas']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('Tingkatan', fn($q) => $q->where('nama_tingkatan', 'like', "%{$search}%"))
                ->orWhereHas('Jurusan', fn($q) => $q->where('nama_jurusan', 'like', "%{$search}%"));
        }

        $kelasTrashed = $query->latest('deleted_at')->paginate(10)->withQueryString();

        return view('kelas.trash', compact('kelasTrashed'));
    }

    /**
     * Restore kelas dari trash.
     */
    public function restore(int $id)
    {
        $kelas = Kelas::onlyTrashed()->findOrFail($id);
        $kelas->restore();
        return redirect()->route('kelas.trash')
            ->with('success', 'Kelas berhasil dipulihkan.');
    }

    /**
     * Hapus permanen.
     */
    public function forceDelete(int $id)
    {
        $kelas = Kelas::onlyTrashed()->findOrFail($id);
        $kelas->forceDelete();
        return redirect()->route('kelas.trash')
            ->with('success', 'Kelas berhasil dihapus secara permanen.');
    }
}
