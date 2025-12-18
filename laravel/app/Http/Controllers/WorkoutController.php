<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    protected $service;

    public function __construct(CommonService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $userId = Auth::id();
        $data = $this->service->getTopData($userId);

        return view('workouts.index', [
            'data' => $data,
        ]);
    }

    public function create(Request $request): View
    {
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y/m/d'],
            'exercise_id' => ['required', 'integer'],
        ]);

        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'exerciseId' => $validated['exercise_id'],
        ];

        $exercise = $this->service->getCreateData($param);
        if (!$exercise) {
            abort(404);
        }

        $data = [
            'exercise' => $exercise,
            'date' => $validated['date'],
            'memo' => null
        ];

        return view('workouts.create', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y/m/d'],
            'exercise_id' => ['required', 'integer'],
            'sets' => ['required', 'array', 'min:1', 'max:50'],
            'sets.*.weight' => ['required', 'numeric', 'min:0', 'max:1000'],
            'sets.*.reps' => ['required', 'integer', 'min:0', 'max:1000'],
            'memo' => ['nullable', 'string', 'max:1000'],
        ]);

        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'exerciseId' => $validated['exercise_id'],
            'sets' => $validated['sets'],
            'memo' => $validated['memo'] ?? null,
            'date' => $validated['date'],
        ];

        $this->service->createWorkout($param);

        return redirect()->route('workouts.index', ['date' => $validated['date']]);
    }

    public function getByDate(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y/m/d'],
        ]);

        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'date' => $validated['date'],
        ];

        $data = $this->service->getByDate($param);
        return response()->json($data);
    }

    public function edit(Request $request): View
    {
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y/m/d'],
            'exercise_id' => ['required', 'integer'],
        ]);

        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'date' => $validated['date'],
            'exerciseId' => $validated['exercise_id'],
        ];

        $workout = $this->service->getWorkoutData($param);

        $exercise = $this->service->getCreateData($param);
        if (!$exercise) {
            abort(404);
        }

        $data = [
            'workout' => $workout,
            'exercise' => $exercise,
            'date' => $validated['date'],
            'memo' => $workout->first()->memo ?? null
        ];

        return view('workouts.edit', [
            'data' => $data,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y/m/d'],
            'exercise_id' => ['required', 'integer'],
            'sets' => ['required', 'array', 'min:1', 'max:50'],
            'sets.*.weight' => ['required', 'numeric', 'min:0', 'max:1000'],
            'sets.*.reps' => ['required', 'integer', 'min:0', 'max:1000'],
            'memo' => ['nullable', 'string', 'max:1000'],
        ]);

        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'exerciseId' => $validated['exercise_id'],
            'sets' => $validated['sets'],
            'memo' => $validated['memo'] ?? null,
            'date' => $validated['date']
        ];

        $this->service->updateWorkout($param);

        return redirect()->route('workouts.index', ['date' => $validated['date']]);
    }
}
