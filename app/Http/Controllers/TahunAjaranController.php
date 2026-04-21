<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Requests\TahunAjaran\StoreTahunAjaranRequest;
use App\Http\Requests\TahunAjaran\UpdateTahunAjaranRequest;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::all();
        return response()->json($tahunAjarans);
    }

    public function store(StoreTahunAjaranRequest $request)
    {
        $validated = $request->validated();

        $tahunAjaran = TahunAjaran::create($validated);
        return response()->json($tahunAjaran, 201);
    }

    public function show($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return response()->json($tahunAjaran);
    }

    public function update(UpdateTahunAjaranRequest $request, $id)
    {
        $validated = $request->validated();

        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->update($validated);
        return response()->json($tahunAjaran);
    }

    public function destroy($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->delete();
        return response()->json(null, 204);
    }
}
