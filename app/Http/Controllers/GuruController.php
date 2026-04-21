<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use App\Http\Requests\Guru\StoreGuruRequest;
use App\Http\Requests\Guru\UpdateGuruRequest;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        return response()->json($gurus);
    }

    public function store(StoreGuruRequest $request)
    {
        $validated = $request->validated();

        $guru = Guru::create($validated);
        return response()->json($guru, 201);
    }

    public function show($id)
    {
        $guru = Guru::findOrFail($id);
        return response()->json($guru);
    }

    public function update(UpdateGuruRequest $request, $id)
    {
        $validated = $request->validated();

        $guru = Guru::findOrFail($id);
        $guru->update($validated);
        return response()->json($guru);
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();
        return response()->json(null, 204);
    }
}
