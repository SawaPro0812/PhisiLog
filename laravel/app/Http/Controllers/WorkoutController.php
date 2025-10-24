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
        $data = [
            'exercise' => $this->service->getCreateData($request->exercise_id),
            'date' => $request->date
        ];

        return view('workouts.create', [
            'data' => $data
        ]);
    }

    // ワークアウト登録処理
    public function store(Request $request)
    {
        $userId = Auth::id();
        $data = [
            'userId' => $userId,
            'exerciseId' => $request->exercise_id,
            'sets' => $request->sets,
            'memo' => $request->memo,
            'date' => $request->date
        ];

        $data = $this->service->createWorkout($data);
        return redirect()->route('workouts.index', ['date' => $request->date]);
    }
}
