<?php

namespace App\Services;

use App\Models\StudySchedule;
use Illuminate\Support\Facades\Validator;

class StudyScheduleService
{
    public function getAll()
    {
        return StudySchedule::all();
    }

    public function create(array $data)
    {
        $rules = [
            'title' => 'required|string',
            'scheduled_at' => 'required|date',
            'description' => 'nullable|string',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        return StudySchedule::create($validator->validated());
    }

    public function getById($id)
    {
        return StudySchedule::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $schedule = StudySchedule::findOrFail($id);

        $rules = [
            'title' => 'required|string',
            'scheduled_at' => 'required|date',
            'description' => 'nullable|string',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        $schedule->update($validator->validated());
        return $schedule;
    }

    public function delete($id)
    {
        $schedule = StudySchedule::find($id);

        if (!$schedule) {
            return null;
        }

        $schedule->delete();
        return true;
    }
}
