<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaterLog;
use Illuminate\Support\Facades\Auth;

class WaterController extends Controller
{
    public function index()
    {
        $logs = WaterLog::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('water.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        WaterLog::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Water intake logged!');
    }
}
