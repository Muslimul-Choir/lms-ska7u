<?php

namespace App\Http\Controllers;

use App\Exports\Siswa\SiswaExport;
use App\Http\Requests\Siswa\StoreSiswaRequest;
use App\Http\Requests\Siswa\UpdateSiswaRequest;
use App\Imports\Siswa\SiswaImport;
use App\Mail\Siswa\KirimAkunSiswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Traits\GeneratesPasswordFromBirthDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class SiswaController extends Controller
{
    use GeneratesPasswordFromBirthDate;

    private function getGuruWaliKelas(): ?Guru
    {
        $user = Auth::user();
        if ($user->role !== 'guru') return null;

        $guru = Guru::where('id_user', $user->id)->first();
        if (!$guru) return null;

        if (!in_array($guru->status_pengajar, ['walikelas', 'keduanya'])) return null;

        return $guru;
    }

    // ── INDEX ────────────────────────────────────────────────
    public function index(Request $request)
{
    $guruWali = $this->getGuruWaliKelas();
    // Cek apakah walikelas tapi belum ditugaskan ke kelas 
    $belumAdaKelas = $guruWali && !$guruWali->kelas;

    $query = Siswa::with(['Kelas.Tingkatan', 'Kelas.Jurusan', 'Kelas.Bagian']);

    // Jika walikelas: paksa filter ke kelasnya saja
    if ($guruWali) {
        $kelasWali = $guruWali->kelas; // hasOne
        $query->where('id_kelas', $kelasWali?->id ?? 0);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    if (!$guruWali && $request->filled('id_kelas')) {
        $query->where('id_kelas', $request->id_kelas);
    }

    if ($request->filled('agama')) {
        $query->where('agama', $request->agama);
    }

    $siswas     = $query->latest()->paginate(10)->withQueryString();
    $kelasList  = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])
        ->get()
        ->sortBy('nama_kelas')
        ->values();
    $trashCount = $guruWali
        ? Siswa::onlyTrashed()->where('id_kelas', $guruWali->kelas?->id ?? 0)->count()
        : Siswa::onlyTrashed()->count();

    return view('siswa.index', compact('siswas', 'kelasList', 'trashCount', 'guruWali','belumAdaKelas'));
}

    // ── STORE ────────────────────────────────────────────────
    public function store(StoreSiswaRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $plainPassword = $this->generatePasswordFromBirthDate($request->tanggal_lahir);

                $user = User::create([
                    'name'              => $request->nama_lengkap,
                    'email'             => $request->email,
                    'password'          => Hash::make($plainPassword),
                    'role'              => 'siswa',
                    'email_verified_at' => now(),
                ]);

                Siswa::create([
                    'id_user'       => $user->id,
                    'nama_lengkap'  => $request->nama_lengkap,
                    'email'         => $request->email,
                    'agama'         => $request->agama,
                    'id_kelas'      => $request->id_kelas,
                    'tanggal_lahir' => $request->tanggal_lahir,
                ]);
            });

            return redirect()->route('siswa.index')
                ->with('success', 'Data siswa berhasil ditambahkan.');
        } catch (Throwable $e) {
            return redirect()->route('siswa.index')
                ->with('error', 'Gagal menambahkan data siswa. Silakan coba lagi.');
        }
    }

    // ── UPDATE ───────────────────────────────────────────────
    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        try {
            DB::transaction(function () use ($request, $siswa) {
                $siswa->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'email'        => $request->email,
                    'agama'        => $request->agama,
                    'id_kelas'     => $request->id_kelas,
                    'tanggal_lahir' => $request->tanggal_lahir,
                ]);

                $siswa->User->update([
                    'name'  => $request->nama_lengkap,
                    'email' => $request->email,
                ]);
            });

            return redirect()->route('siswa.index')
                ->with('success', 'Data siswa berhasil diperbarui.');
        } catch (Throwable $e) {
            return redirect()->route('siswa.index')
                ->with('error', 'Gagal memperbarui data siswa. Silakan coba lagi.');
        }
    }

    // ── DESTROY ──────────────────────────────────────────────
    public function destroy(Siswa $siswa)
    {
        $errors = [];

        if ($siswa->Absensi()->exists()) {
            $absensiCount = $siswa->Absensi()->count();
            $errors[] = "Siswa ini masih memiliki {$absensiCount} absensi.";
        }

        if ($siswa->PengumpulanTugas()->exists()) {
            $pengumpulanTugasCount = $siswa->PengumpulanTugas()->count();
            $errors[] = "Siswa ini masih memiliki {$pengumpulanTugasCount} pengumpulan tugas.";
        }

        if ($siswa->HasilKuis()->exists()) {
            $hasilKuisCount = $siswa->HasilKuis()->count();
            $errors[] = "Siswa ini masih memiliki {$hasilKuisCount} hasil kuis.";
        }

        if (!empty($errors)) {
            return redirect()->route('siswa.index')
                ->with('error', implode(' | ', $errors));
        }

        try {
            DB::transaction(function () use ($siswa) {
                if ($siswa->user) {
                    $siswa->user->delete();
                }
                $siswa->delete();
            });

            return redirect()->route('siswa.index')
                ->with('success', 'Data siswa berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()->route('siswa.index')
                ->with('error', 'Gagal menghapus data siswa. Silakan coba lagi.');
        }
    }

    // ── SEND EMAIL satu siswa ─────────────────────────────────
    public function sendEmail(Siswa $siswa)
    {
        try {
            $plainPassword = $this->generatePasswordFromBirthDate($siswa->tanggal_lahir);
            $siswa->User->update(['password' => Hash::make($plainPassword)]);

            Log::info("Attempting to send email to: {$siswa->email}");
            Log::info("MAIL_MAILER: " . config('mail.default'));
            Log::info("MAIL_HOST: " . config('mail.mailers.smtp.host'));

            Mail::to($siswa->email)->send(new KirimAkunSiswa($siswa, $plainPassword));

            Log::info("Email successfully sent to: {$siswa->email}");

            return back()->with('success', "Email akun berhasil dikirim ke {$siswa->email}.");
        } catch (Throwable $e) {
            Log::error("Failed to send email to {$siswa->email}: " . $e->getMessage());
            Log::error("Error details: " . $e->getTraceAsString());

            return back()->with('error', "Gagal mengirim email ke {$siswa->email}. Error: " . substr($e->getMessage(), 0, 100));
        }
    }

    // ── SEND EMAIL SEMUA ─────────────────────────────────────
    public function sendEmailAll()
    {
        try {
            Siswa::chunk(100, function ($siswas) {
                foreach ($siswas as $siswa) {
                    $plainPassword = $this->generatePasswordFromBirthDate($siswa->tanggal_lahir);
                    $siswa->User->update(['password' => Hash::make($plainPassword)]);
                    // Gunakan send() langsung agar email terkirim segera (bukan queue)
                    Mail::to($siswa->email)->send(new KirimAkunSiswa($siswa, $plainPassword));
                }
            });

            return redirect()->route('siswa.index')
                ->with('success', "Email akun berhasil dikirim ke seluruh siswa.");
        } catch (Throwable $e) {
            Log::error('Error sending emails: ' . $e->getMessage());
            return redirect()->route('siswa.index')
                ->with('error', "Gagal mengirim email: " . $e->getMessage());
        }
    }

    // ── EXPORT ───────────────────────────────────────────────
    public function export()
    {
        try {
            return Excel::download(new SiswaExport, 'data-siswa-' . now()->format('dmY') . '.xlsx');
        } catch (Throwable $e) {
            Log::error('Error exporting siswa: ' . $e->getMessage());
            return redirect()->route('siswa.index')
                ->with('error', "Gagal mengekspor data siswa: " . $e->getMessage());
        }
    }

    // ── IMPORT ───────────────────────────────────────────────
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ]);

        try {
            $import = new SiswaImport();
            Excel::import($import, $request->file('file'));

            // ── Gabungkan validation failures dari rules() ke skipped_details ──
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

            // ── Buat pesan feedback ─────────────────────────────────────────────
            $messages = [];

            if ($summary['created'] > 0) {
                $messages[] = "{$summary['created']} siswa baru berhasil ditambahkan.";
            }

            if ($summary['restored'] > 0) {
                $restoredEmails = array_column($import->restored, 'email');
                $emailPreview   = implode(', ', array_slice($restoredEmails, 0, 5));
                $suffix         = count($restoredEmails) > 5 ? ', dan lainnya' : '';
                $messages[]     = "{$summary['restored']} siswa berhasil dipulihkan: {$emailPreview}{$suffix}.";
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
                ->route('siswa.index')
                ->with($status, $mainMessage)
                ->with('skipped_details', $skippedDetails)
                ->with('skipped_truncated', $summary['skipped'] > 100);
        } catch (Throwable $e) {
            Log::error('Import Siswa Error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('siswa.index')
                ->with('error', 'Terjadi kesalahan saat mengimpor data. Silakan periksa file dan coba lagi.');
        }
    }

    // ── TRASH ────────────────────────────────────────────────
    public function trash(Request $request)
{
    $guruWali = $this->getGuruWaliKelas();

    $query = Siswa::onlyTrashed()->with('Kelas');

    if ($guruWali) {
        $query->where('id_kelas', $guruWali->kelas?->id ?? 0);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    if (!$guruWali && $request->filled('id_kelas')) {
        $query->where('id_kelas', $request->id_kelas);
    }

    if ($request->filled('agama')) {
        $query->where('agama', $request->agama);
    }

    $siswas    = $query->latest('deleted_at')->paginate(15)->withQueryString();
    $kelasList = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])
        ->get()
        ->sortBy('nama_kelas')
        ->values();

    return view('siswa.trash', compact('siswas', 'kelasList', 'guruWali'));
}

    // ── RESTORE satu ─────────────────────────────────────────
    public function restore(int $id)
    {
        try {
            $siswa = Siswa::onlyTrashed()->findOrFail($id);

            DB::transaction(function () use ($siswa) {
                $siswa->restore();
                $siswa->User()->withTrashed()->restore();
            });

            return redirect()->route('siswa.trash')
                ->with('success', "Data siswa {$siswa->nama_lengkap} berhasil dikembalikan.");
        } catch (Throwable $e) {
            return redirect()->route('siswa.trash')
                ->with('error', "Gagal mengembalikan data siswa. Silakan coba lagi.");
        }
    }

    // ── RESTORE SEMUA ────────────────────────────────────────
    public function restoreAll()
    {
        try {
            DB::transaction(function () {
                $siswas = Siswa::onlyTrashed()->with(['User' => function ($q) {
                    $q->withTrashed();
                }])->get();

                foreach ($siswas as $siswa) {
                    $siswa->restore();
                    $siswa->User()->withTrashed()->restore();
                }
            });

            return redirect()->route('siswa.trash')
                ->with('success', 'Semua data siswa berhasil dikembalikan.');
        } catch (Throwable $e) {
            return redirect()->route('siswa.trash')
                ->with('error', "Gagal mengembalikan data semua siswa. Silakan coba lagi.");
        }
    }

    // ── FORCE DELETE satu ────────────────────────────────────
    public function forceDelete(int $id)
    {
        try {
            $siswa = Siswa::onlyTrashed()->findOrFail($id);

            DB::transaction(function () use ($siswa) {
                $siswa->User()->withTrashed()->forceDelete();
                $siswa->forceDelete();
            });

            return redirect()->route('siswa.trash')
                ->with('success', "Data siswa {$siswa->nama_lengkap} berhasil dihapus permanen.");
        } catch (Throwable $e) {
            return redirect()->route('siswa.trash')
                ->with('error', "Gagal menghapus data siswa. Silakan coba lagi.");
        }
    }

    // ── FORCE DELETE SEMUA ───────────────────────────────────
    public function forceDeleteAll()
    {
        try {
            DB::transaction(function () {
                $siswas = Siswa::onlyTrashed()->with(['User' => function ($q) {
                    $q->withTrashed();
                }])->get();
                foreach ($siswas as $siswa) {
                    $siswa->User()->withTrashed()->forceDelete();
                    $siswa->forceDelete();
                }
            });

            return redirect()->route('siswa.trash')
                ->with('success', 'Semua data siswa berhasil dihapus permanen.');
        } catch (Throwable $e) {
            return redirect()->route('siswa.trash')
                ->with('error', "Gagal menghapus semua data siswa. Silakan coba lagi.");
        }
    }
}
