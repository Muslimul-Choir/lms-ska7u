<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use App\Http\Requests\Materi\StoreMateriRequest;
use App\Http\Requests\Materi\UpdateMateriRequest;

class MateriController extends Controller
{
    public function index()
    {
        $materis = Materi::all();
        return response()->json($materis);
    }

    public function store(StoreMateriRequest $request)
    {
        $validated = $request->validated();

        $materi = Materi::create($validated);
        return response()->json($materi, 201);
    }

    public function show($id)
    {
        $materi = Materi::findOrFail($id);
        return response()->json($materi);
    }

    public function update(UpdateMateriRequest $request, $id)
    {
        $validated = $request->validated();

        $materi = Materi::findOrFail($id);
        $materi->update($validated);
        return response()->json($materi);
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        $materi->delete();
        return response()->json(null, 204);
    }
}
