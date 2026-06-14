<?php

// app/Http/Controllers/GuruController.php
namespace App\Http\Controllers;

use App\Exports\Guru\GuruExport;
use App\Http\Requests\Guru\StoreGuruRequest;
use App\Http\Requests\Guru\UpdateGuruRequest;
use App\Imports\Guru\GuruImport;
use App\Mail\Guru\KirimAkunGuru;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class GuruController extends Controller
{
    // ── INDEX ────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Guru::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status_pengajar')) {
            $query->where('status_pengajar', $request->status_pengajar);
        }

        $gurus = $query->latest()->paginate(15)->withQueryString();
        $trashCount = Guru::onlyTrashed()->count();
        return view('guru.index', compact('gurus', 'trashCount'));
    }


    // ── STORE ────────────────────────────────────────────────
    public function store(StoreGuruRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $plainPassword = Str::random(6) . rand(100, 999);

                $user = User::create([
                    'name'     => $request->nama_lengkap,
                    'email'    => $request->email,
                    'password' => Hash::make($plainPassword),
                    'role'     => 'guru',
                ]);

                $guru = Guru::create([
                    'id_user'         => $user->id,
                    'nama_lengkap'    => $request->nama_lengkap,
                    'email'           => $request->email,
                    'status_pengajar' => $request->status_pengajar,
                ]);

                // Simpan plain password sementara di session untuk ditampilkan/dikirim
                session()->flash('plain_password', $plainPassword);
                session()->flash('guru_id', $guru->id);
            });

            return redirect()->route('guru.index')
                ->with('success', 'Data guru berhasil ditambahkan.');
        } catch (Throwable $e) {
            return redirect()->route('guru.index')
                ->with('error', 'Gagal menambahkan data guru. Silakan coba lagi.');
        }
    }

    // ── UPDATE ───────────────────────────────────────────────
    public function update(UpdateGuruRequest $request, Guru $guru)
    {
        $statusLama = $guru->status_pengajar;
        $statusBaru = $request->status_pengajar;

        if (in_array($statusLama, ['walikelas', 'keduanya']) && $statusBaru === 'pengajar') {
            $kelasDiampu = Kelas::where('id_wali_kelas', $guru->id)->first();

            if ($kelasDiampu) {
                return redirect()->route('guru.index')
                    ->with('error', 'Guru "' . $guru->nama_lengkap . '" masih menjadi wali kelas ' . $kelasDiampu->nama_kelas . '. Ganti wali kelas tersebut terlebih dahulu sebelum mengubah status menjadi Pengajar.');
            }
        }

        try {
            DB::transaction(function () use ($request, $guru) {

                $guru->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'email' => $request->email,
                    'status_pengajar' => $request->status_pengajar,
                ]);

                $guru->user->update([
                    'name' => $request->nama_lengkap,
                    'email' => $request->email,
                ]);
            });

            return redirect()->route('guru.index')
                ->with('success', 'Data guru berhasil diperbarui.');
        } catch (Throwable $e) {
            return redirect()->route('guru.index')
                ->with('error', 'Gagal memperbarui data guru. Silakan coba lagi.');
        }
    }


    public function destroy(Guru $guru)
    {
        $errors = [];

        // Cek apakah guru masih menjadi wali kelas
        if ($guru->kelas()->exists()) {
            $kelasCount = $guru->kelas()->count();
            $errors[] = "Guru ini masih menjadi wali kelas untuk {$kelasCount} kelas.";
        }

        // Cek apakah guru masih mengajar mapel
        if ($guru->guruMapel()->exists()) {
            $mapelCount = $guru->guruMapel()->count();
            $errors[] = "Guru ini masih mengajar {$mapelCount} mapel.";
        }

        if ($guru->Pertemuan()->exists()) {
            $pertemuanCount = $guru->Pertemuan()->count();
            $errors[] = "Guru ini masih mengajar {$pertemuanCount} pertemuan.";
        }

        if ($guru->Kuis()->exists()) {
            $kuisCount = $guru->Kuis()->count();
            $errors[] = "Guru ini masih memberikan {$kuisCount} kuis.";
        }

        if ($guru->Penilaian()->exists()) {
            $penilaianCount = $guru->Penilaian()->count();
            $errors[] = "Guru ini masih memberikan {$penilaianCount} penilaian.";
        }

        // Cek apakah guru masih memiliki tugas
        if ($guru->Tugas()->exists()) {
            $tugasCount = $guru->Tugas()->count();
            $errors[] = "Guru ini masih memiliki {$tugasCount} tugas.";
        }

        if (!empty($errors)) {
            return redirect()->route('guru.index')
                ->with('error', implode(' | ', $errors));
        }

        try {
            DB::transaction(function () use ($guru) {

                Kelas::where('id_wali_kelas', $guru->id)->update(['id_wali_kelas' => null]);


                if ($guru->user) {
                    $guru->user->delete();
                }

                $guru->delete();
            });

            return redirect()->route('guru.index')
                ->with('success', 'Data guru berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()->route('guru.index')
                ->with('error', 'Gagal menghapus data guru. Silakan coba lagi.');
        }
    }


    public function sendEmail(Guru $guru)
    {
        $plainPassword = Str::random(6) . rand(100, 999);

        $guru->user->update([
            'password' => Hash::make($plainPassword)
        ]);

        try {
            Mail::to($guru->email)
                ->send(new KirimAkunGuru($guru, $plainPassword));

            return back()->with('success', "Email akun berhasil dikirim ke {$guru->email} dengan password baru.");
        } catch (Throwable $e) {
            Log::error('Gagal kirim email guru: ' . $e->getMessage());
            return back()->with('error', "Gagal mengirim email ke {$guru->email}. Pesan error: " . $e->getMessage());
        }
    }

    // ── SEND EMAIL SEMUA ─────────────────────────────────────
    public function sendEmailAll()
    {
        $berhasil = 0;
        $gagal    = 0;

        Guru::chunk(100, function ($gurus) use (&$berhasil, &$gagal) {
            foreach ($gurus as $guru) {
                $plainPassword = Str::random(6) . rand(100, 999);
                $guru->user->update(['password' => Hash::make($plainPassword)]);
                try {
                    Mail::to($guru->email)->send(new KirimAkunGuru($guru, $plainPassword));
                    $berhasil++;
                } catch (Throwable $e) {
                    Log::error("Gagal kirim email guru {$guru->email}: " . $e->getMessage());
                    $gagal++;
                }
            }
        });

        $msg = "{$berhasil} email akun guru berhasil dikirim.";
        if ($gagal > 0) {
            $msg .= " {$gagal} email gagal dikirim.";
        }

        return redirect()->route('guru.index')->with('success', $msg);
    }

    // ── EXPORT EXCEL ─────────────────────────────────────────
    public function export()
    {
        try {
            return Excel::download(new GuruExport, 'data-guru-' . now()->format('dmY') . '.xlsx');
        } catch (Throwable $e) {
            return redirect()->route('guru.index')
                ->with('error', 'Gagal mengekspor data guru. Silakan coba lagi.');
        }
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ]);

        try {
            $import = new GuruImport();
            Excel::import($import, $request->file('file'));


            $validationFailures = collect($import->failures())
                ->map(fn(Failure $f) => [
                    'row'    => $f->row(),
                    'email'  => '-',
                    'reason' => implode(', ', $f->errors()),
                ])
                ->all();

            $summary = $import->getSummary();

            if (!empty($validationFailures)) {
                $summary['skipped_details'] = array_merge(
                    $validationFailures,
                    $summary['skipped_details']
                );
                $summary['skipped'] = count($summary['skipped_details']);
            }


            $messages = [];

            if ($summary['created'] > 0) {
                $messages[] = "{$summary['created']} guru baru berhasil ditambahkan.";
            }

            if ($summary['restored'] > 0) {
                $restoredEmails = array_column($import->restored, 'email');
                $emailPreview   = implode(', ', array_slice($restoredEmails, 0, 5));
                $suffix         = count($restoredEmails) > 5 ? ', dan lainnya' : '';
                $messages[]     = "{$summary['restored']} guru berhasil dipulihkan: {$emailPreview}{$suffix}.";
            }

            if ($summary['skipped'] > 0) {
                $messages[] = "beberapa baris dilewati (lihat detail di bawah).";
            }

            $mainMessage = !empty($messages)
                ? implode(' | ', $messages)
                : 'Tidak ada data baru yang diproses.';

            $status         = ($summary['created'] + $summary['restored']) > 0 ? 'success' : 'warning';
            $skippedDetails = array_slice($summary['skipped_details'], 0, 100);

            return redirect()
                ->route('guru.index')
                ->with($status, $mainMessage)
                ->with('skipped_details', $skippedDetails)
                ->with('skipped_truncated', $summary['skipped'] > 100);
        } catch (Throwable $e) {
            Log::error('Import Guru Error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('guru.index')
                ->with('error', 'Terjadi kesalahan saat mengimpor data. Silakan periksa file dan coba lagi.');
        }
    }

    // ── TRASH ────────────────────────────────────────────────
    public function trash(Request $request)
    {
        $query = Guru::onlyTrashed();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status_pengajar')) {
            $query->where('status_pengajar', $request->status_pengajar);
        }

        $gurus = $query->latest('deleted_at')->paginate(15)->withQueryString();
        return view('guru.trash', compact('gurus'));
    }

    // ── RESTORE satu ─────────────────────────────────────────
    public function restore(int $id)
    {
        try {
            $guru = Guru::onlyTrashed()->findOrFail($id);

            DB::transaction(function () use ($guru) {
                $guru->restore();
                $guru->user()->withTrashed()->restore();
            });

            return redirect()->route('guru.trash')
                ->with('success', "Data guru {$guru->nama_lengkap} berhasil dikembalikan.");
        } catch (Throwable $e) {
            return redirect()->route('guru.trash')
                ->with('error', 'Gagal mengembalikan data guru. Silakan coba lagi.');
        }
    }

    // ── RESTORE SEMUA ────────────────────────────────────────
    public function restoreAll()
    {
        try {
            DB::transaction(function () {
                $gurus = Guru::onlyTrashed()->with(['user' => function ($q) {
                    $q->withTrashed();
                }])->get();
                foreach ($gurus as $guru) {
                    $guru->restore();
                    $guru->user()->withTrashed()->restore();
                }
            });

            return redirect()->route('guru.trash')
                ->with('success', 'Semua data guru berhasil dikembalikan.');
        } catch (Throwable $e) {
            return redirect()->route('guru.trash')
                ->with('error', 'Gagal mengembalikan data guru. Silakan coba lagi.');
        }
    }

    // ── FORCE DELETE satu ────────────────────────────────────
    public function forceDelete(int $id)
    {
        try {
            $guru = Guru::onlyTrashed()->findOrFail($id);

            DB::transaction(function () use ($guru) {
                // Hapus referensi guru di kelas (wali_kelas)
                Kelas::where('id_wali_kelas', $guru->id)->update(['id_wali_kelas' => null]);

                $guru->user()->withTrashed()->forceDelete();
                $guru->forceDelete();
            });

            return redirect()->route('guru.trash')
                ->with('success', "Data guru {$guru->nama_lengkap} berhasil dihapus permanen.");
        } catch (Throwable $e) {
            return redirect()->route('guru.trash')
                ->with('error', 'Gagal menghapus data guru secara permanen. Silakan coba lagi.');
        }
    }

    // ── FORCE DELETE SEMUA ───────────────────────────────────
    public function forceDeleteAll()
    {
        try {
            DB::transaction(function () {
                $gurus = Guru::onlyTrashed()->with(['user' => function ($q) {
                    $q->withTrashed();
                }])->get();
                foreach ($gurus as $guru) {
                    // Hapus referensi guru di kelas (wali_kelas)
                    Kelas::where('id_wali_kelas', $guru->id)->update(['id_wali_kelas' => null]);

                    $guru->user()->withTrashed()->forceDelete();
                    $guru->forceDelete();
                }
            });

            return redirect()->route('guru.trash')
                ->with('success', 'Semua data guru berhasil dihapus permanen.');
        } catch (Throwable $e) {
            return redirect()->route('guru.trash')
                ->with('error', 'Gagal menghapus data guru secara permanen. Silakan coba lagi.');
        }
    }
}
