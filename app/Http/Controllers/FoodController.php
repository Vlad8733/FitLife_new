<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MealLog;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    private $foods = [
        'Rice' => 130,
        'Chicken breast' => 165,
        'Beef' => 250,
        'Pork' => 242,
        'Salmon' => 208,
        'Tuna' => 132,
        'Egg' => 155,
        'Milk (whole)' => 61,
        'Cheese' => 402,
        'Yogurt' => 59,
        'Butter' => 717,
        'Bread' => 265,
        'Oatmeal' => 68,
        'Banana' => 89,
        'Apple' => 52,
        'Orange' => 47,
        'Tomato' => 18,
        'Cucumber' => 16,
        'Carrot' => 41,
        'Potato' => 77,
        'Broccoli' => 34,
        'Spinach' => 23,
        'Lettuce' => 15,
        'Avocado' => 160,
        'Peanut Butter' => 588,
        'Almonds' => 579,
        'Walnuts' => 654,
        'Chocolate (dark)' => 546,
        'Ice Cream' => 207,
        'Pasta' => 131,
        'Pizza' => 266,
        'Burger' => 295,
        'Fries' => 312,
        'Soda' => 40,
        'Coffee' => 1,
        'Tea' => 1,
    ];

    public function index(Request $request)
    {
        $foods = $this->foods;

        $query = MealLog::where('user_id', Auth::id());

        if ($request->filled('meal_type')) {
            $query->where('meal', $request->meal_type);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            $partialHtml = view('profile.partials.meal_table', ['mealLogs' => $logs])->render();
            $inner = '<h3 id="history-heading">Meal History</h3>' . $partialHtml;
            return response('<section id="history-section" aria-labelledby="history-heading">' . $inner . '</section>');
        }

        return view('foods.index', compact('foods', 'logs'));
    }

    public function calculate(Request $request)
    {
        // Исправленная валидация
        $request->validate([
            'meals' => 'required|array',
            'meals.*' => 'array',
            'meals.*.*.food' => 'nullable|string',
            'meals.*.*.quantity' => 'nullable|numeric|min:0',
        ]);

        $totalCalories = 0;
        $logs = [];

        foreach ($request->meals as $meal => $items) {
            foreach ($items as $item) {
                $food = $item['food'] ?? null;
                $quantity = isset($item['quantity']) ? (float)$item['quantity'] : 0;

                if ($food && isset($this->foods[$food]) && $quantity > 0) {
                    $calories = round($this->foods[$food] * ($quantity / 100));
                    $totalCalories += $calories;

                    $log = MealLog::create([
                        'user_id' => Auth::id(),
                        'meal' => $meal,
                        'food' => $food,
                        'quantity' => $quantity,
                        'calories' => $calories,
                    ]);
                    $logs[] = $log;
                }
            }
        }

        if (empty($logs)) {
            return response()->json([
                'success' => false,
                'message' => 'No valid meals provided',
            ], 422);
        }

        $comment = $totalCalories < 1500
            ? "Try to eat a bit more calories for energy!"
            : ($totalCalories < 2500
                ? "Great! Keep it up!"
                : "You consumed a lot of calories, don't forget to move!");

        $logs = MealLog::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        $partialHtml = view('profile.partials.meal_table', ['mealLogs' => $logs])->render();
        $historyHtml = '<h3 id="history-heading">Meal History</h3>' . $partialHtml;

        return response()->json([
            'success' => true,
            'calories' => round($totalCalories),
            'comment' => $comment,
            'historyHtml' => $historyHtml,
        ]);
    }

    public function history()
    {
        $logs = MealLog::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('foods.history', compact('logs'));
    }
}
