<?php

namespace App\Http\Controllers;

use App\Exports\Siswa\SiswaExport;
use App\Http\Requests\Siswa\StoreSiswaRequest;
use App\Http\Requests\Siswa\UpdateSiswaRequest;
use App\Imports\Siswa\SiswaImport;
use App\Mail\Siswa\KirimAkunSiswa;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Traits\GeneratesPasswordFromBirthDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\Failure;

class SiswaController extends Controller
{
    use GeneratesPasswordFromBirthDate;

    // ── INDEX ────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Siswa::with(['Kelas.Tingkatan', 'Kelas.Jurusan', 'Kelas.Bagian']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('id_kelas')) {
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
        $trashCount = Siswa::onlyTrashed()->count();

        return view('siswa.index', compact('siswas', 'kelasList', 'trashCount'));
    }

    // ── STORE ────────────────────────────────────────────────
    public function store(StoreSiswaRequest $request)
    {
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
    }

    // ── UPDATE ───────────────────────────────────────────────
    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
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
    }

    // ── DESTROY ──────────────────────────────────────────────
    public function destroy(Siswa $siswa)
    {
        DB::transaction(function () use ($siswa) {
            $siswa->User->delete();
            $siswa->delete();
        });

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    // ── SEND EMAIL satu siswa ─────────────────────────────────
    public function sendEmail(Siswa $siswa)
    {
        $plainPassword = $this->generatePasswordFromBirthDate($siswa->tanggal_lahir);
        $siswa->User->update(['password' => Hash::make($plainPassword)]);
        Mail::to($siswa->email)->send(new KirimAkunSiswa($siswa, $plainPassword));

        return back()->with('success', "Email akun berhasil dikirim ke {$siswa->email}.");
    }

    // ── SEND EMAIL SEMUA ─────────────────────────────────────
    public function sendEmailAll()
    {
        Siswa::chunk(100, function ($siswas) {
            foreach ($siswas as $siswa) {
                $plainPassword = $this->generatePasswordFromBirthDate($siswa->tanggal_lahir);
                $siswa->User->update(['password' => Hash::make($plainPassword)]);
                Mail::to($siswa->email)->queue(new KirimAkunSiswa($siswa, $plainPassword));
            }
        });

        return redirect()->route('siswa.index')
            ->with('success', "Email akun berhasil dikirim ke seluruh siswa.");
    }

    // ── EXPORT ───────────────────────────────────────────────
    public function export()
    {
        return Excel::download(new SiswaExport, 'data-siswa-' . now()->format('dmY') . '.xlsx');
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
                $messages[] = "{$summary['skipped']} baris dilewati (lihat detail di bawah).";
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
        } catch (\Throwable $e) {
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
    public function trash()
    {
        $siswas = Siswa::onlyTrashed()->with('Kelas')->latest('deleted_at')->paginate(15);
        return view('siswa.trash', compact('siswas'));
    }

    // ── RESTORE satu ─────────────────────────────────────────
    public function restore(string $id)
    {
        $siswa = Siswa::onlyTrashed()->findOrFail($id);

        DB::transaction(function () use ($siswa) {
            $siswa->restore();
            $siswa->User()->withTrashed()->restore();
        });

        return redirect()->route('siswa.trash')
            ->with('success', "Data siswa {$siswa->nama_lengkap} berhasil dikembalikan.");
    }

    // ── RESTORE SEMUA ────────────────────────────────────────
    public function restoreAll()
    {
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
    }

    // ── FORCE DELETE satu ────────────────────────────────────
    public function forceDelete(string $id)
    {
        $siswa = Siswa::onlyTrashed()->findOrFail($id);

        DB::transaction(function () use ($siswa) {
            $siswa->User()->withTrashed()->forceDelete();
            $siswa->forceDelete();
        });

        return redirect()->route('siswa.trash')
            ->with('success', "Data siswa {$siswa->nama_lengkap} berhasil dihapus permanen.");
    }

    // ── FORCE DELETE SEMUA ───────────────────────────────────
    public function forceDeleteAll()
    {
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
    }
}
