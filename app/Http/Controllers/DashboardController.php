<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MealLog;
use App\Models\Sleep;
use App\Models\Progress;
use App\Models\Goal;
use App\Models\WaterLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Подгружаем биографию
        $biography = $user->biography;

        // Прогресс-фотки
        $photos = Progress::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        // История еды с пагинацией по 10
        $mealLogs = MealLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10, ['*'], 'meals');

        // История сна с пагинацией по 10
        $sleepLogs = Sleep::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10, ['*'], 'sleep');

        // История воды с пагинацией по 10
        $waterLogs = WaterLog::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10, ['*'], 'water');

        // Цели пользователя
        $goals = Goal::where('user_id', $user->id)->get();

        // KPI-блоки
        $totalCalories = MealLog::where('user_id', $user->id)->sum('calories');
        $totalSleep = Sleep::where('user_id', $user->id)->sum('duration');
        $totalWater = WaterLog::where('user_id', $user->id)->sum('amount');

        return view('dashboard', compact(
            'user',
            'biography',
            'photos',
            'mealLogs',
            'sleepLogs',
            'waterLogs',
            'goals',
            'totalCalories',
            'totalSleep',
            'totalWater'
        ));
    }


    // AJAX подгрузка Meal History
    public function mealLogsAjax(Request $request)
    {
        $userId = Auth::id();
        $mealLogs = MealLog::where('user_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10, ['*'], 'meals');

        if($request->ajax()) {
            return view('profile.partials.meal_table', compact('mealLogs'))->render();
        }

        return redirect()->route('dashboard');
    }

    // AJAX подгрузка Sleep History
    public function sleepLogsAjax(Request $request)
    {
        $userId = Auth::id();
        $sleepLogs = Sleep::where('user_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10, ['*'], 'sleep');

        if($request->ajax()) {
            return view('profile.partials.sleep_table', compact('sleepLogs'))->render();
        }

        return redirect()->route('dashboard');
    }

    // AJAX подгрузка Water History
    public function waterLogsAjax(Request $request)
    {
        $userId = Auth::id();
        $waterLogs = WaterLog::where('user_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10, ['*'], 'water');

        if($request->ajax()) {
            return view('profile.partials.water_table', compact('waterLogs'))->render();
        }

        return redirect()->route('dashboard');
    }
}
