<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudySchedule;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class StudyScheduleController extends Controller
{
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $user->schedules;  // Only this user's schedules
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'scheduled_at' => 'required|date',
            'description' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $data = $validator->validated();
        $data['user_id'] = $user->id;

        return StudySchedule::create($data);
    }

    public function show($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $schedule = StudySchedule::where('id', $id)->where('user_id', $user->id)->first();

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        return $schedule;
    }

    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $schedule = StudySchedule::where('id', $id)->where('user_id', $user->id)->first();

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        $rules = [
            'title' => 'required|string',
            'scheduled_at' => 'required|date',
            'description' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $schedule->update($validator->validated());
        return $schedule;
    }

    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $schedule = StudySchedule::where('id', $id)->where('user_id', $user->id)->first();

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
