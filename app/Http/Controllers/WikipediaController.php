<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudyScheduleService;

class StudyScheduleController extends Controller
{
    protected $service;

    public function __construct(StudyScheduleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAll();
    }

    public function store(Request $request)
    {
        $result = $this->service->create($request->all());

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        return $result;
    }

    public function show($id)
    {
        return $this->service->getById($id);
    }

    public function update(Request $request, $id)
    {
        $result = $this->service->update($id, $request->all());

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        return $result;
    }

    public function destroy($id)
    {
        $result = $this->service->delete($id);

        if (!$result) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
