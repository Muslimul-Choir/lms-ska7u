<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Http\Requests\Tugas\StoreTugasRequest;
use App\Http\Requests\Tugas\UpdateTugasRequest;

class TugasController extends Controller
{
    public function index()
    {
        $tugass = Tugas::all();
        return response()->json($tugass);
    }

    public function store(StoreTugasRequest $request)
    {
        $validated = $request->validated();

        $tugas = Tugas::create($validated);
        return response()->json($tugas, 201);
    }

    public function show($id)
    {
        $tugas = Tugas::findOrFail($id);
        return response()->json($tugas);
    }

    public function update(UpdateTugasRequest $request, $id)
    {
        $validated = $request->validated();

        $tugas = Tugas::findOrFail($id);
        $tugas->update($validated);
        return response()->json($tugas);
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();
        return response()->json(null, 204);
    }
}
