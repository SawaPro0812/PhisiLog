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
        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'name' => $request->name,
            'category' => $request->category,
        ];

        $data = $this->service->createExercise($param);
        return response()->json([
            'status'   => 'success',
            'exercise' => $param,
        ]);
    }

    // 種目編集処理
    public function update(Request $request)
    {
        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'id' => $request->id,
            'name' => $request->name,
            'category' => $request->category,
        ];

        $data = $this->service->updateExercise($param);
        return response()->json([
            'status'   => 'success',
            'exercise' => $data,
            'param' => $param
        ]);
    }

    // 種目削除処理
    public function delete(Request $request)
    {
        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'id' => $request->id,
        ];
        $data = $this->service->deleteExercise($param);
        return response()->json([
            'status'   => 'success',
            'exercise' => $data,
        ]);
    }
}
