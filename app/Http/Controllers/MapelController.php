<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Http\Requests\Mapel\StoreMapelRequest;
use App\Http\Requests\Mapel\UpdateMapelRequest;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::all();
        return response()->json($mapels);
    }

    public function store(StoreMapelRequest $request)
    {
        $validated = $request->validated();

        $mapel = Mapel::create($validated);
        return response()->json($mapel, 201);
    }

    public function show($id)
    {
        $mapel = Mapel::findOrFail($id);
        return response()->json($mapel);
    }

    public function update(UpdateMapelRequest $request, $id)
    {
        $validated = $request->validated();

        $mapel = Mapel::findOrFail($id);
        $mapel->update($validated);
        return response()->json($mapel);
    }

    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();
        return response()->json(null, 204);
    }
}
