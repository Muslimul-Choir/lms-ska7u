<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Requests\Absensi\StoreAbsensiRequest;
use App\Http\Requests\Absensi\UpdateAbsensiRequest;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::all();
        return response()->json($absensis);
    }

    public function store(StoreAbsensiRequest $request)
    {
        $validated = $request->validated();

        $absensi = Absensi::create($validated);
        return response()->json($absensi, 201);
    }

    public function show($id)
    {
        $absensi = Absensi::findOrFail($id);
        return response()->json($absensi);
    }

    public function update(UpdateAbsensiRequest $request, $id)
    {
        $validated = $request->validated();

        $absensi = Absensi::findOrFail($id);
        $absensi->update($validated);
        return response()->json($absensi);
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();
        return response()->json(null, 204);
    }
}
