<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudySchedule;
use Illuminate\Support\Facades\Validator;

class StudyScheduleController extends Controller
{
    // Fetch all study schedules
    public function index()
    {
        return StudySchedule::all();  // Get all schedules, including their IDs
    }

    // Create a new study schedule
    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'title' => 'required|string',
            'scheduled_at' => 'required|date',
            'description' => 'nullable|string',
        ];

        // Validate request data
        $validator = Validator::make($request->all(), $rules);

        // Check validation
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create and return the new study schedule (including the ID)
        return StudySchedule::create($validator->validated());
    }

    // Fetch a single study schedule by ID
    public function show($id)
    {
        return StudySchedule::findOrFail($id);  // Returns the schedule by ID
    }

    // Update an existing study schedule
    public function update(Request $request, $id)
    {
        $schedule = StudySchedule::findOrFail($id);

        // Define validation rules
        $rules = [
            'title' => 'required|string',
            'scheduled_at' => 'required|date',
            'description' => 'nullable|string',
        ];

        // Validate request data
        $validator = Validator::make($request->all(), $rules);

        // Check validation
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update and return the updated schedule (including the ID)
        $schedule->update($validator->validated());

        return $schedule;
    }

    // Delete a study schedule
   public function destroy($id)
{
    $schedule = StudySchedule::find($id); // ✅ Use the correct model

    if (!$schedule) {
        return response()->json(['message' => 'Schedule not found'], 404);
    }

    $schedule->delete();

    return response()->json(['message' => 'Schedule deleted successfully']);
}


}
