<?php

namespace App\Http\Controllers;

use App\Models\Pertemuan;
use Illuminate\Http\Request;
use App\Http\Requests\Pertemuan\StorePertemuanRequest;
use App\Http\Requests\Pertemuan\UpdatePertemuanRequest;

class PertemuanController extends Controller
{
    public function index()
    {
        $pertemuans = Pertemuan::all();
        return response()->json($pertemuans);
    }

    public function store(StorePertemuanRequest $request)
    {
        $validated = $request->validated();

        $pertemuan = Pertemuan::create($validated);
        return response()->json($pertemuan, 201);
    }

    public function show($id)
    {
        $pertemuan = Pertemuan::findOrFail($id);
        return response()->json($pertemuan);
    }

    public function update(UpdatePertemuanRequest $request, $id)
    {
        $validated = $request->validated();

        $pertemuan = Pertemuan::findOrFail($id);
        $pertemuan->update($validated);
        return response()->json($pertemuan);
    }

    public function destroy($id)
    {
        $pertemuan = Pertemuan::findOrFail($id);
        $pertemuan->delete();
        return response()->json(null, 204);
    }
}
