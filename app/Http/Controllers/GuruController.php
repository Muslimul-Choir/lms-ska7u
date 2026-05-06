<?php

// app/Http/Controllers/GuruController.php
namespace App\Http\Controllers;

use App\Exports\Guru\GuruExport;
use App\Http\Requests\Guru\StoreGuruRequest;
use App\Http\Requests\Guru\UpdateGuruRequest;
use App\Imports\Guru\GuruImport;
use App\Mail\Guru\KirimAkunGuru;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
    }

    // ── UPDATE ───────────────────────────────────────────────
    public function update(UpdateGuruRequest $request, Guru $guru)
    {
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
    }

    // ── DESTROY ──────────────────────────────────────────────
    public function destroy(Guru $guru)
    {
        DB::transaction(function () use ($guru) {
            $guru->user->delete();
            $guru->delete();
        });

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    // ── SEND EMAIL (satu guru) ────────────────────────────────
    public function sendEmail(Guru $guru)
    {
        $plainPassword = Str::random(6) . rand(100, 999);

        $guru->user->update([
            'password' => Hash::make($plainPassword)
        ]);

        Mail::to($guru->email)
            ->send(new KirimAkunGuru($guru, $plainPassword));

        return back()->with('success', "Email berhasil dikirim.");
    }

    // ── SEND EMAIL SEMUA ─────────────────────────────────────
    public function sendEmailAll()
    {
        $gurus = Guru::all();

        foreach ($gurus as $guru) {
            $plainPassword = Str::random(6) . rand(100, 999);
            $guru->user->update(['password' => Hash::make($plainPassword)]);
            Mail::to($guru->email)->send(new KirimAkunGuru($guru, $plainPassword));
        }

        return redirect()->route('guru.index')
            ->with('success', "Email akun berhasil dikirim ke seluruh guru (" . $gurus->count() . " guru).");
    }

    // ── EXPORT EXCEL ─────────────────────────────────────────
    public function export()
    {
        return Excel::download(new GuruExport, 'data-guru-' . now()->format('dmY') . '.xlsx');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:2048'],
        ]);

        try {
            $import = new GuruImport();
            Excel::import($import, $request->file('file'));

            $importedCount = count($import->imported);

            return redirect()->route('guru.index')
                ->with('success', "{$importedCount} data diimpor.");
        } catch (\Exception $e) {
            Log::error('Import Guru Error: ' . $e->getMessage());

            return redirect()->route('guru.index')
                ->with('error', 'Terjadi kesalahan saat mengimpor data guru. Silakan periksa file dan coba lagi.');
        }
    }

    // ── TRASH ────────────────────────────────────────────────
    public function trash()
    {
        $gurus = Guru::onlyTrashed()->latest('deleted_at')->paginate(15);
        return view('guru.trash', compact('gurus'));
    }

    // ── RESTORE satu ─────────────────────────────────────────
    public function restore(string $id)
    {
        $guru = Guru::onlyTrashed()->findOrFail($id);

        DB::transaction(function () use ($guru) {
            $guru->restore();
            $guru->user()->withTrashed()->restore();
        });

        return redirect()->route('guru.trash')
            ->with('success', "Data guru {$guru->nama_lengkap} berhasil dikembalikan.");
    }

    // ── RESTORE SEMUA ────────────────────────────────────────
    public function restoreAll()
    {
        DB::transaction(function () {
            $gurus = Guru::onlyTrashed()->get();
            foreach ($gurus as $guru) {
                $guru->restore();
                $guru->user()->withTrashed()->restore();
            }
        });

        return redirect()->route('guru.trash')
            ->with('success', 'Semua data guru berhasil dikembalikan.');
    }

    // ── FORCE DELETE satu ────────────────────────────────────
    public function forceDelete(string $id)
    {
        $guru = Guru::onlyTrashed()->findOrFail($id);

        DB::transaction(function () use ($guru) {
            $guru->user()->withTrashed()->forceDelete();
            $guru->forceDelete();
        });

        return redirect()->route('guru.trash')
            ->with('success', "Data guru {$guru->nama_lengkap} berhasil dihapus permanen.");
    }

    // ── FORCE DELETE SEMUA ───────────────────────────────────
    public function forceDeleteAll()
    {
        DB::transaction(function () {
            $gurus = Guru::onlyTrashed()->get();
            foreach ($gurus as $guru) {
                $guru->user()->withTrashed()->forceDelete();
                $guru->forceDelete();
            }
        });

        return redirect()->route('guru.trash')
            ->with('success', 'Semua data guru berhasil dihapus permanen.');
    }
}
