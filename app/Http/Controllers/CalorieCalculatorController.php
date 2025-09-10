<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MealLog;

class CalorieCalculatorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $todayCalories = MealLog::where('user_id', $user->id)
                            ->whereDate('created_at', now())
                            ->sum('calories');

        return view('calories.index', compact('user', 'todayCalories'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric|min:30|max:300',
            'height' => 'required|numeric|min:100|max:250',
            'age' => 'required|numeric|min:10|max:100',
            'activity_level' => 'required|in:sedentary,light,moderate,active',
            'goal_type' => 'required|in:lose_weight,maintain,gain_weight'
        ]);

        $weight = $request->weight;
        $height = $request->height;
        $age = $request->age;
        $activity = $request->activity_level;
        $goal = $request->goal_type;

        // BMR расчет по формуле Mifflin-St Jeor (мужчины)
        $bmr = 10*$weight + 6.25*$height - 5*$age + 5;

        // Activity factor
        $activityFactor = match($activity) {
            'sedentary' => 1.2,
            'light' => 1.375,
            'moderate' => 1.55,
            'active' => 1.725,
            default => 1.2
        };

        $tdee = $bmr * $activityFactor;

        // Коррекция на цель
        $calories = match($goal) {
            'lose_weight' => $tdee - 500,
            'gain_weight' => $tdee + 500,
            default => $tdee
        };

        // Макроэлементы (проценты)
        $protein = round($weight * 1.8); // граммы
        $fat = round(($calories * 0.25) / 9); // 25% калорий из жиров
        $carbs = round(($calories - ($protein*4 + $fat*9))/4);

        $user = Auth::user();
        $todayCalories = MealLog::where('user_id', $user->id)
                            ->whereDate('created_at', now())
                            ->sum('calories');

        return view('calories.index', compact('user', 'calories', 'protein', 'fat', 'carbs', 'todayCalories', 'goal'));
    }
}
