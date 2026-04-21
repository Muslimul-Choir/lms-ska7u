<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Requests\Jurusan\StoreJurusanRequest;
use App\Http\Requests\Jurusan\UpdateJurusanRequest;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::all();
        return response()->json($jurusans);
    }

    public function store(StoreJurusanRequest $request)
    {
        $validated = $request->validated();

        $jurusan = Jurusan::create($validated);
        return response()->json($jurusan, 201);
    }

    public function show($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return response()->json($jurusan);
    }

    public function update(UpdateJurusanRequest $request, $id)
    {
        $validated = $request->validated();

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update($validated);
        return response()->json($jurusan);
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();
        return response()->json(null, 204);
    }
}
