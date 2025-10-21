<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainingController extends Controller
{
    /**
     * トップメニュー表示
     */
    public function index(Request $request): View
    {
        $test = 'test';
        return view('training.index', [
            'user' => $test,
        ]);
    }
}
