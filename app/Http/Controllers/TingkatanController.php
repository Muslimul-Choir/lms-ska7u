<?php

namespace App\Http\Controllers;

use App\Models\Tingkatan;
use Illuminate\Http\Request;
use App\Http\Requests\Tingkatan\StoreTingkatanRequest;
use App\Http\Requests\Tingkatan\UpdateTingkatanRequest;

class TingkatanController extends Controller
{
    public function index()
    {
        $tingkatans = Tingkatan::all();
        return response()->json($tingkatans);
    }

    public function store(StoreTingkatanRequest $request)
    {
        $validated = $request->validated();

        $tingkatan = Tingkatan::create($validated);
        return response()->json($tingkatan, 201);
    }

    public function show($id)
    {
        $tingkatan = Tingkatan::findOrFail($id);
        return response()->json($tingkatan);
    }

    public function update(UpdateTingkatanRequest $request, $id)
    {
        $validated = $request->validated();

        $tingkatan = Tingkatan::findOrFail($id);
        $tingkatan->update($validated);
        return response()->json($tingkatan);
    }

    public function destroy($id)
    {
        $tingkatan = Tingkatan::findOrFail($id);
        $tingkatan->delete();
        return response()->json(null, 204);
    }
}
