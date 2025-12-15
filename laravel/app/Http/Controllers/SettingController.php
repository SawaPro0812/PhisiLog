<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    protected $service;

    public function __construct(CommonService $service)
    {
        $this->service = $service;
    }

    /**
     * 設定画面表示 PEND
     */
    public function index(Request $request): View
    {
        //$userId = Auth::id();
        //$data = $this->service->getTopData($userId);
        
        return view('settings.index');
    }

}
