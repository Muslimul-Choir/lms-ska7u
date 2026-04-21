<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Http\Requests\Kelas\StoreKelasRequest;
use App\Http\Requests\Kelas\UpdateKelasRequest;

class KelasController extends Controller
{
    public function index()
    {
        $kelass = Kelas::all();
        return response()->json($kelass);
    }

    public function store(StoreKelasRequest $request)
    {
        $validated = $request->validated();

        $kelas = Kelas::create($validated);
        return response()->json($kelas, 201);
    }

    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        return response()->json($kelas);
    }

    public function update(UpdateKelasRequest $request, $id)
    {
        $validated = $request->validated();

        $kelas = Kelas::findOrFail($id);
        $kelas->update($validated);
        return response()->json($kelas);
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return response()->json(null, 204);
    }
}
