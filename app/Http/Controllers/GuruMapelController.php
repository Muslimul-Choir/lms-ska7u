<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use Illuminate\Http\Request;
use App\Http\Requests\GuruMapel\StoreGuruMapelRequest;
use App\Http\Requests\GuruMapel\UpdateGuruMapelRequest;

class GuruMapelController extends Controller
{
    public function index()
    {
        $guruMapels = GuruMapel::all();
        return response()->json($guruMapels);
    }

    public function store(StoreGuruMapelRequest $request)
    {
        $validated = $request->validated();

        $guruMapel = GuruMapel::create($validated);
        return response()->json($guruMapel, 201);
    }

    public function show($id)
    {
        $guruMapel = GuruMapel::findOrFail($id);
        return response()->json($guruMapel);
    }

    public function update(UpdateGuruMapelRequest $request, $id)
    {
        $validated = $request->validated();

        $guruMapel = GuruMapel::findOrFail($id);
        $guruMapel->update($validated);
        return response()->json($guruMapel);
    }

    public function destroy($id)
    {
        $guruMapel = GuruMapel::findOrFail($id);
        $guruMapel->delete();
        return response()->json(null, 204);
    }
}
