<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;
use App\Models\GoalLog;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    // Show all goals for the authenticated user
    public function index()
    {
        $goals = Goal::where('user_id', Auth::id())->get();
        return view('goals.index', compact('goals'));
    }

    // Show form to create a new goal
    public function create()
    {
        return view('goals.create');
    }

    // Store a new goal
    public function store(Request $request)
    {
        $request->validate([
            'type'         => 'required|string',
            'target_value' => 'required|numeric|min:0',
            'end_date'     => 'required|date|after:today',
            'description'  => 'nullable|string|max:255',
        ]);

        Goal::create([
            'user_id'       => Auth::id(),
            'type'          => $request->type,
            'target_value'  => $request->target_value,
            'description'   => $request->description ?? '',
            'end_date'      => $request->end_date,
            'current_value' => 0,
        ]);

        return redirect()->route('goals.index')->with('success', '');
    }

    // Show goal progress log
    public function log(Goal $goal)
    {
        return view('goals.log', compact('goal'));
    }

    // Store a progress log entry
    public function storeLog(Request $request, Goal $goal)
    {
        $request->validate([
            'value' => 'required|numeric|min:0',
        ]);

        // Save progress log
        GoalLog::create([
            'goal_id' => $goal->id,
            'value'   => $request->value,
            'date'    => now()->toDateString(),
        ]);

        // Update current goal value
        $goal->current_value += $request->value;
        $goal->save();

        // Trigger confetti if goal completed and not already shown
        $sessionKey = 'goal_'.$goal->id.'_completed';
        if ($goal->current_value >= $goal->target_value && !session()->has($sessionKey)) {
            session()->put($sessionKey, true);
            session()->flash('goal_completed', true);
        }

        return redirect()->route('goals.index')->with('success', '');
    }
}
