<?php

namespace App\Http\Controllers;

use App\Models\JamBelajar;
use Illuminate\Http\Request;
use App\Http\Requests\JamBelajar\StoreJamBelajarRequest;
use App\Http\Requests\JamBelajar\UpdateJamBelajarRequest;

class JamBelajarController extends Controller
{
    public function index()
    {
        $jamBelajars = JamBelajar::all();
        return response()->json($jamBelajars);
    }

    public function store(StoreJamBelajarRequest $request)
    {
        $validated = $request->validated();

        $jamBelajar = JamBelajar::create($validated);
        return response()->json($jamBelajar, 201);
    }

    public function show($id)
    {
        $jamBelajar = JamBelajar::findOrFail($id);
        return response()->json($jamBelajar);
    }

    public function update(UpdateJamBelajarRequest $request, $id)
    {
        $validated = $request->validated();

        $jamBelajar = JamBelajar::findOrFail($id);
        $jamBelajar->update($validated);
        return response()->json($jamBelajar);
    }

    public function destroy($id)
    {
        $jamBelajar = JamBelajar::findOrFail($id);
        $jamBelajar->delete();
        return response()->json(null, 204);
    }
}
