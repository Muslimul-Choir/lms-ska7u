<?php

namespace App\Http\Controllers;

use App\Models\JamBelajar;
use App\Http\Requests\JamBelajarRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JamBelajarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $jamBelajars = JamBelajar::when($search, function ($query, $search) {
                return $query->where('jam_mulai', 'like', '%' . $search . '%')
                             ->orWhere('jam_selesai', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'jamBelajars' => $jamBelajars->items(),
                'pagination' => [
                    'current_page' => $jamBelajars->currentPage(),
                    'last_page' => $jamBelajars->lastPage(),
                    'per_page' => $jamBelajars->perPage(),
                    'total' => $jamBelajars->total(),
                ]
            ]);
        }

        return view('jambelajar.index', compact('jamBelajars', 'search'));
    }

    public function create()
    {
        return view('jambelajar.create');
    }

    public function store(JamBelajarRequest $request)
    {
        JamBelajar::create($request->validated());

        return redirect()->route('jambelajar.index')
            ->with('success', 'Jam belajar berhasil ditambahkan');
    }

    public function edit(JamBelajar $jambelajar)
    {
        return view('jambelajar.edit', compact('jambelajar'));
    }

    public function update(JamBelajarRequest $request, JamBelajar $jambelajar)
    {
        $jambelajar->update($request->validated());

        return redirect()->route('jambelajar.index')
            ->with('success', 'Jam belajar berhasil diupdate');
    }

    public function destroy(JamBelajar $jambelajar)
    {
        $jambelajar->delete();

        return redirect()->route('jambelajar.index')
            ->with('success', 'Jam belajar berhasil dihapus');
    }

    public function trash(): View
    {
        $trash = JamBelajar::onlyTrashed()->get();

        return view('jambelajar.trash', compact('trash'));
    }

    public function restore(JamBelajar $jambelajar): RedirectResponse
    {
        $jambelajar->restore();

        return redirect()->route('jambelajar.trash')
            ->with('success', 'Data berhasil direstore');
    }

    public function forceDelete(JamBelajar $jambelajar): RedirectResponse
    {
        $jambelajar->forceDelete();

        return redirect()->route('jambelajar.trash')
            ->with('success', 'Data berhasil dihapus permanen');
    }
}