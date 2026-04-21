<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Http\Requests\Penilaian\StorePenilaianRequest;
use App\Http\Requests\Penilaian\UpdatePenilaianRequest;

class PenilaianController extends Controller
{
    public function index()
    {
        $penilaians = Penilaian::all();
        return response()->json($penilaians);
    }

    public function store(StorePenilaianRequest $request)
    {
        $validated = $request->validated();

        $penilaian = Penilaian::create($validated);
        return response()->json($penilaian, 201);
    }

    public function show($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        return response()->json($penilaian);
    }

    public function update(UpdatePenilaianRequest $request, $id)
    {
        $validated = $request->validated();

        $penilaian = Penilaian::findOrFail($id);
        $penilaian->update($validated);
        return response()->json($penilaian);
    }

    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->delete();
        return response()->json(null, 204);
    }
}
