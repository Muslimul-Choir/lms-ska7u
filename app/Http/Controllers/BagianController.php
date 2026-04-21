<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use Illuminate\Http\Request;
use App\Http\Requests\Bagian\StoreBagianRequest;
use App\Http\Requests\Bagian\UpdateBagianRequest;

class BagianController extends Controller
{
    public function index()
    {
        $bagians = Bagian::all();
        return response()->json($bagians);
    }

    public function store(StoreBagianRequest $request)
    {
        $validated = $request->validated();

        $bagian = Bagian::create($validated);
        return response()->json($bagian, 201);
    }

    public function show($id)
    {
        $bagian = Bagian::findOrFail($id);
        return response()->json($bagian);
    }

    public function update(UpdateBagianRequest $request, $id)
    {
        $validated = $request->validated();

        $bagian = Bagian::findOrFail($id);
        $bagian->update($validated);
        return response()->json($bagian);
    }

    public function destroy($id)
    {
        $bagian = Bagian::findOrFail($id);
        $bagian->delete();
        return response()->json(null, 204);
    }
}
