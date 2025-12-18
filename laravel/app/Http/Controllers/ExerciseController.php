<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    protected $service;

    public function __construct(CommonService $service)
    {
        $this->service = $service;
    }

    // 種目登録画面表示
    public function create(Request $request): View
    {
        $userId = Auth::id();
        $data = [
            'exercises' => $this->service->getExerciseByUser($userId),
        ];
        return view('exercises.create', [
            'data' => $data
        ]);
    }

    // 種目登録処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'category' => ['required', 'string', 'max:20'],
        ]);

        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'name' => $validated['name'],
            'category' => $validated['category'],
        ];

        $data = $this->service->createExercise($param);

        return response()->json([
            'status'   => 'success',
            'exercise' => $data,
        ]);
    }

    // 種目編集処理
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:50'],
            'category' => ['required', 'string', 'max:20'],
        ]);

        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'id' => $validated['id'],
            'name' => $validated['name'],
            'category' => $validated['category'],
        ];

        $data = $this->service->updateExercise($param);

        if (!$data) {
            return response()->json(['status' => 'error', 'message' => 'not found'], 404);
        }

        return response()->json([
            'status'   => 'success',
            'exercise' => $data,
        ]);
    }

    // 種目削除処理
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer'],
        ]);

        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'id' => $validated['id'],
        ];

        $data = $this->service->deleteExercise($param);

        if (!$data) {
            return response()->json(['status' => 'error', 'message' => 'not found'], 404);
        }

        return response()->json([
            'status' => 'success',
            'deleted_id' => $data,
        ]);
    }
}