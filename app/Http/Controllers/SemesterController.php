<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Requests\Semester\StoreSemesterRequest;
use App\Http\Requests\Semester\UpdateSemesterRequest;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::all();
        return response()->json($semesters);
    }

    public function store(StoreSemesterRequest $request)
    {
        $validated = $request->validated();

        $semester = Semester::create($validated);
        return response()->json($semester, 201);
    }

    public function show($id)
    {
        $semester = Semester::findOrFail($id);
        return response()->json($semester);
    }

    public function update(UpdateSemesterRequest $request, $id)
    {
        $validated = $request->validated();

        $semester = Semester::findOrFail($id);
        $semester->update($validated);
        return response()->json($semester);
    }

    public function destroy($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();
        return response()->json(null, 204);
    }
}
