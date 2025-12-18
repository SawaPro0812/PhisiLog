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

    /**
     * トップメニュー表示
     */
    public function index(Request $request): View
    {
        $userId = Auth::id();
        $data = $this->service->getTopData($userId);
        
        return view('workouts.index', [
            'data' => $data,
        ]);
    }

    // ワークアウト登録画面表示
    public function create(Request $request): View
    {
        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'exerciseId' => $request->exercise_id,
        ];

        $data = [
            'exercise' => $this->service->getCreateData($param),
            'date' => $request->date,
            'memo' => null //ダミー
        ];

        return view('workouts.create', [
            'data' => $data
        ]);
    }

    // ワークアウト登録処理
    public function store(Request $request)
    {
        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'exerciseId' => $request->exercise_id,
            'sets' => $request->sets,
            'memo' => $request->memo,
            'date' => $request->date
        ];

        $data = $this->service->createWorkout($param);
        return redirect()->route('workouts.index', ['date' => $request->date]);
    }

    // ワークアウト履歴取得
    public function getByDate(Request $request)
    {
        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'date' => $request->date,
        ];
        
        $data = $this->service->getByDate($param);

        $workouts = [
            'test' => 'test'
        ];
        return response()->json($data);
    }

    // ワークアウト編集画面表示
    public function edit(Request $request): View
    {
        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'date' => $request->date,
            'exerciseId' => $request->exercise_id
        ];
        
        $workout = $this->service->getWorkoutData($param);
        $data = [
            'workout' => $workout,
            'exercise' => $this->service->getCreateData($param),
            'date' => $request->date,
            'memo' => $workout->first()->memo ?? null
        ];

        return view('workouts.edit', [
            'data' => $data,
        ]);
    }

    // ワークアウト更新処理
    public function update(Request $request)
    {
        $userId = Auth::id();
        $param = [
            'userId' => $userId,
            'exerciseId' => $request->exercise_id,
            'sets' => $request->sets,
            'memo' => $request->memo,
            'date' => $request->date
        ];

        $data = $this->service->updateWorkout($param);
        return redirect()->route('workouts.index', ['date' => $request->date]);
    }
}
