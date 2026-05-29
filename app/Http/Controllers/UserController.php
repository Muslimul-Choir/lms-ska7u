<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->whereIn('role', ['super_admin', 'admin']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(
                fn($q) =>
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
            );
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $trashCount = User::onlyTrashed()
            ->whereIn('role', ['super_admin', 'admin'])
            ->count();

        return view('users.index', compact('users', 'trashCount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $errors = [];

        // Check relasi dengan guru
        if ($user->guru()->exists()) {
            $errors[] = 'masih terdaftar sebagai guru';
        }

        // Check relasi dengan siswa
        if ($user->siswa()->exists()) {
            $errors[] = 'masih terdaftar sebagai siswa';
        }

        if (!empty($errors)) {
            return redirect()->route('users.index')
                ->with('error', 'User "' . $user->name . '" tidak dapat dihapus karena ' . implode(', ', $errors) . '.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function trash(Request $request)
    {
        $query = User::onlyTrashed()
            ->whereIn('role', ['super_admin', 'admin']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(
                fn($q) =>
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
            );
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest('deleted_at')->paginate(10)->withQueryString();

        return view('users.trash', compact('users'));
    }

    public function restore(string $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.trash')
            ->with('success', 'User berhasil direstore.');
    }

    public function restoreAll()
    {
        User::onlyTrashed()
            ->whereIn('role', ['super_admin', 'admin'])
            ->restore();

        return redirect()->route('users.trash')
            ->with('success', 'Semua user berhasil direstore.');
    }

    public function forceDelete(string $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $errors = [];

        // Check relasi dengan guru
        if ($user->guru()->exists()) {
            $errors[] = 'masih terdaftar sebagai guru';
        }

        // Check relasi dengan siswa
        if ($user->siswa()->exists()) {
            $errors[] = 'masih terdaftar sebagai siswa';
        }

        if (!empty($errors)) {
            return redirect()->route('users.trash')
                ->with('error', 'User "' . $user->name . '" tidak dapat dihapus permanen karena ' . implode(', ', $errors) . '.');
        }

        $user->forceDelete();

        return redirect()->route('users.trash')
            ->with('success', 'User berhasil dihapus permanen.');
    }

    public function forceDeleteAll()
    {
        $trashedUsers = User::onlyTrashed()
            ->whereIn('role', ['super_admin', 'admin'])
            ->get();

        $deletedCount = 0;
        $skippedCount = 0;
        $failedUsers = [];

        foreach ($trashedUsers as $user) {
            $errors = [];

            // Check relasi dengan guru
            if ($user->guru()->exists()) {
                $errors[] = 'guru';
            }

            // Check relasi dengan siswa
            if ($user->siswa()->exists()) {
                $errors[] = 'siswa';
            }

            if (empty($errors)) {
                $user->forceDelete();
                $deletedCount++;
            } else {
                $skippedCount++;
                $failedUsers[] = $user->name;
            }
        }

        $message = "Berhasil menghapus $deletedCount user";
        if ($skippedCount > 0) {
            $message .= " ($skippedCount user dilewati karena masih memiliki relasi: " . implode(', ', $failedUsers) . ")";
        }

        return redirect()->route('users.trash')
            ->with('success', $message . '.');
    }
}
