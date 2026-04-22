<?php

namespace App\Http\Controllers;

use App\Models\JamBelajar;
use App\Http\Requests\JamBelajarRequest;
use Illuminate\View\View;

class JamBelajarController extends Controller
{
        public function index(): View
    {
        $jamBelajars = JamBelajar::latest()->get(); // atau paginate(5)

        return view('jambelajar.index', compact('jamBelajars'));
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

    public function restore($id)
    {
        JamBelajar::onlyTrashed()->where('id', $id)->restore();

        return redirect()->route('jambelajar.trash')
            ->with('success', 'Data berhasil direstore');
    }

    public function forceDelete($id)
    {
        JamBelajar::onlyTrashed()->where('id', $id)->forceDelete();

        return redirect()->route('jambelajar.trash')
            ->with('success', 'Data berhasil dihapus permanen');
    }
}