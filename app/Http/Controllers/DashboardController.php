<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{MealLog, Sleep, Progress, Goal, WaterLog, Calendar};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Show the main dashboard with user stats and logs
    public function index()
    {
        $user = Auth::user();

        $today = Carbon::today();
        $weekLater = $today->copy()->addDays(7);

        $upcomingEvents = Calendar::where('user_id', $user->id)
            ->whereBetween('date', [$today, $weekLater])
            ->orderBy('date')
            ->take(3)
            ->get();

        return view('dashboard', [
            'user'          => $user,
            'biography'     => $user->biography,
            'photos'        => Progress::where('user_id', $user->id)->latest()->get(),
            'mealLogs'      => $this->getPaginatedLogs(MealLog::class, $user->id, 'meals'),
            'sleepLogs'     => $this->getPaginatedLogs(Sleep::class, $user->id, 'sleep'),
            'waterLogs'     => $this->getPaginatedLogs(WaterLog::class, $user->id, 'water'),
            'goals'         => Goal::where('user_id', $user->id)->get(),
            'totalCalories' => MealLog::where('user_id', $user->id)->sum('calories'),
            'totalSleep'    => Sleep::where('user_id', $user->id)->sum('duration'),
            'totalWater'    => WaterLog::where('user_id', $user->id)->sum('amount'),
            'upcomingEvents' => $upcomingEvents,
        ]);
    }

    // AJAX: Load paginated meal logs
    public function mealLogsAjax(Request $request)
    {
        return $this->ajaxLogResponse($request, MealLog::class, 'profile.partials.meal_table', 'meals');
    }

    // AJAX: Load paginated sleep logs
    public function sleepLogsAjax(Request $request)
    {
        return $this->ajaxLogResponse($request, Sleep::class, 'profile.partials.sleep_table', 'sleep');
    }

    // AJAX: Load paginated water logs
    public function waterLogsAjax(Request $request)
    {
        return $this->ajaxLogResponse($request, WaterLog::class, 'profile.partials.water_table', 'water');
    }

    // Generic method for AJAX log rendering
    private function ajaxLogResponse(Request $request, string $model, string $view, string $pageName)
    {
        $logs = $this->getPaginatedLogs($model, Auth::id(), $pageName);

        if ($request->ajax()) {
            return view($view, [$pageName . 'Logs' => $logs])->render();
        }

        return redirect()->route('dashboard');
    }

    // Get paginated logs for a specific model
    private function getPaginatedLogs(string $model, int $userId, string $pageName)
    {
        return $model::where('user_id', $userId)
            ->latest()
            ->paginate(10, ['*'], $pageName);
    }
}