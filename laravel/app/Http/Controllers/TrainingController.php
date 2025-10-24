<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
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
        
        return view('training.index', [
            'data' => $data,
        ]);
    }
}
