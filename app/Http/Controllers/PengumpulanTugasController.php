<?php

namespace App\Http\Controllers;

use App\Models\PengumpulanTugas;
use Illuminate\Http\Request;
use App\Http\Requests\PengumpulanTugas\StorePengumpulanTugasRequest;
use App\Http\Requests\PengumpulanTugas\UpdatePengumpulanTugasRequest;

class PengumpulanTugasController extends Controller
{
    public function index()
    {
        $pengumpulanTugass = PengumpulanTugas::all();
        return response()->json($pengumpulanTugass);
    }

    public function store(StorePengumpulanTugasRequest $request)
    {
        $validated = $request->validated();

        $pengumpulanTugas = PengumpulanTugas::create($validated);
        return response()->json($pengumpulanTugas, 201);
    }

    public function show($id)
    {
        $pengumpulanTugas = PengumpulanTugas::findOrFail($id);
        return response()->json($pengumpulanTugas);
    }

    public function update(UpdatePengumpulanTugasRequest $request, $id)
    {
        $validated = $request->validated();

        $pengumpulanTugas = PengumpulanTugas::findOrFail($id);
        $pengumpulanTugas->update($validated);
        return response()->json($pengumpulanTugas);
    }

    public function destroy($id)
    {
        $pengumpulanTugas = PengumpulanTugas::findOrFail($id);
        $pengumpulanTugas->delete();
        return response()->json(null, 204);
    }
}
