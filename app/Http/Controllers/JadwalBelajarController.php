<?php

namespace App\Http\Controllers;

use App\Models\JadwalBelajar;
use Illuminate\Http\Request;
use App\Http\Requests\JadwalBelajar\StoreJadwalBelajarRequest;
use App\Http\Requests\JadwalBelajar\UpdateJadwalBelajarRequest;

class JadwalBelajarController extends Controller
{
    public function index()
    {
        $jadwalBelajars = JadwalBelajar::all();
        return response()->json($jadwalBelajars);
    }

    public function store(StoreJadwalBelajarRequest $request)
    {
        $validated = $request->validated();

        $jadwalBelajar = JadwalBelajar::create($validated);
        return response()->json($jadwalBelajar, 201);
    }

    public function show($id)
    {
        $jadwalBelajar = JadwalBelajar::findOrFail($id);
        return response()->json($jadwalBelajar);
    }

    public function update(UpdateJadwalBelajarRequest $request, $id)
    {
        $validated = $request->validated();

        $jadwalBelajar = JadwalBelajar::findOrFail($id);
        $jadwalBelajar->update($validated);
        return response()->json($jadwalBelajar);
    }

    public function destroy($id)
    {
        $jadwalBelajar = JadwalBelajar::findOrFail($id);
        $jadwalBelajar->delete();
        return response()->json(null, 204);
    }
}
