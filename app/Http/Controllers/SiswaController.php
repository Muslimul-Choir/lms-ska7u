<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Requests\Siswa\StoreSiswaRequest;
use App\Http\Requests\Siswa\UpdateSiswaRequest;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::all();
        return response()->json($siswas);
    }

    public function store(StoreSiswaRequest $request)
    {
        $validated = $request->validated();

        $siswa = Siswa::create($validated);
        return response()->json($siswa, 201);
    }

    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        return response()->json($siswa);
    }

    public function update(UpdateSiswaRequest $request, $id)
    {
        $validated = $request->validated();

        $siswa = Siswa::findOrFail($id);
        $siswa->update($validated);
        return response()->json($siswa);
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        return response()->json(null, 204);
    }
}
