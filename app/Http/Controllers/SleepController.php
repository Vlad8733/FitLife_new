<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sleep;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SleepController extends Controller
{
    // Show sleep tracker page
    public function index()
    {
        $sleeps = Sleep::where('user_id', Auth::id())
                        ->orderBy('date', 'desc')
                        ->orderBy('start_time', 'desc')
                        ->get();

        $average = $sleeps->avg('duration');

        return view('sleep.index', compact('sleeps', 'average'));
    }

    // Store new sleep record
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $start = Carbon::parse("{$request->date} {$request->start_time}");
        $end = Carbon::parse("{$request->date} {$request->end_time}");

        // Adjust for overnight sleep
        if ($end->lt($start)) {
            $end->addDay();
        }

        $duration = $start->diffInMinutes($end) / 60; // in hours

        Sleep::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $duration,
        ]);

        return redirect()->back()->with('success', ' ');
    }
}
