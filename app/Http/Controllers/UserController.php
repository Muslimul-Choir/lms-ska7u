<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

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

        $users      = $query->latest()->paginate(10)->withQueryString();
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
        try {
            $validated             = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            User::create($validated);

            return redirect()->route('users.index')
                ->with('success', 'Akun berhasil ditambahkan.');
        } catch (Throwable $e) {
            return redirect()->route('users.index')
                ->with('error', 'Gagal menambahkan akun. Silakan coba lagi.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $validated = $request->validated();

            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return redirect()->route('users.index')
                ->with('success', 'Akun berhasil diperbarui.');
        } catch (Throwable $e) {
            return redirect()->route('users.index')
                ->with('error', 'Gagal memperbarui akun. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        try {
            $user->delete();

            return redirect()->route('users.index')
                ->with('success', 'Akun berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()->route('users.index')
                ->with('error', 'Gagal menghapus akun. Silakan coba lagi.');
        }
    }

    /**
     * Display trashed users.
     */
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

    /**
     * Restore a single trashed user.
     */
    public function restore(int $id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->restore();

            return redirect()->route('users.trash')
                ->with('success', 'Akun berhasil dipulihkan.');
        } catch (Throwable $e) {
            return redirect()->route('users.trash')
                ->with('error', 'Gagal memulihkan akun. Silakan coba lagi.');
        }
    }

    /**
     * Restore all trashed users.
     */
    public function restoreAll()
    {
        try {
            User::onlyTrashed()
                ->whereIn('role', ['super_admin', 'admin'])
                ->restore();

            return redirect()->route('users.trash')
                ->with('success', 'Semua akun berhasil dipulihkan.');
        } catch (Throwable $e) {
            return redirect()->route('users.trash')
                ->with('error', 'Gagal memulihkan semua akun. Silakan coba lagi.');
        }
    }

    /**
     * Permanently delete a single trashed user.
     */
    public function forceDelete(int $id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->forceDelete();

            return redirect()->route('users.trash')
                ->with('success', 'Akun berhasil dihapus permanen.');
        } catch (Throwable $e) {
            return redirect()->route('users.trash')
                ->with('error', 'Gagal menghapus akun secara permanen. Silakan coba lagi.');
        }
    }

    /**
     * Permanently delete all trashed users.
     */
    public function forceDeleteAll()
    {
        try {
            User::onlyTrashed()
                ->whereIn('role', ['super_admin', 'admin'])
                ->forceDelete();

            return redirect()->route('users.trash')
                ->with('success', 'Semua akun berhasil dihapus permanen.');
        } catch (Throwable $e) {
            return redirect()->route('users.trash')
                ->with('error', 'Gagal menghapus semua akun secara permanen. Silakan coba lagi.');
        }
    }
}