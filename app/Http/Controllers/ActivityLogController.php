<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Requests\ActivityLog\StoreActivityLogRequest;
use App\Http\Requests\ActivityLog\UpdateActivityLogRequest;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activityLogs = ActivityLog::all();
        return response()->json($activityLogs);
    }

    public function store(StoreActivityLogRequest $request)
    {
        $validated = $request->validated();

        $activityLog = ActivityLog::create($validated);
        return response()->json($activityLog, 201);
    }

    public function show($id)
    {
        $activityLog = ActivityLog::findOrFail($id);
        return response()->json($activityLog);
    }

    public function update(UpdateActivityLogRequest $request, $id)
    {
        $validated = $request->validated();

        $activityLog = ActivityLog::findOrFail($id);
        $activityLog->update($validated);
        return response()->json($activityLog);
    }

    public function destroy($id)
    {
        $activityLog = ActivityLog::findOrFail($id);
        $activityLog->delete();
        return response()->json(null, 204);
    }
}
