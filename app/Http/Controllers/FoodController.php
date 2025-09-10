<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MealLog;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    // Список еды с калориями на 100г/мл
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

    // Страница выбора еды
    public function index()
    {
        $foods = $this->foods;
        return view('foods.index', compact('foods'));
    }

    // Расчёт калорий и сохранение истории
    public function calculate(Request $request)
    {
        $request->validate([
            'meals' => 'required|array',
        ]);

        $totalCalories = 0;

        foreach ($request->meals as $meal => $items) {
            foreach ($items as $item) {
                $food = $item['food'] ?? null;
                $quantity = $item['quantity'] ?? 0;

                if ($food && isset($this->foods[$food])) {
                    $calories = $this->foods[$food] * ($quantity / 100);
                    $totalCalories += $calories;

                    // Сохраняем в историю
                    if ($quantity > 0) {
                        MealLog::create([
                            'user_id' => Auth::id(),
                            'meal' => $meal,
                            'food' => $food,
                            'quantity' => $quantity,
                            'calories' => round($calories),
                        ]);
                    }
                }
            }
        }

        // Motivational message
        if ($totalCalories < 1500) {
            $comment = "Try to eat a bit more calories for energy!";
        } elseif ($totalCalories < 2500) {
            $comment = "Great! Keep it up!";
        } else {
            $comment = "You consumed a lot of calories, don't forget to move!";
        }

        return back()->with('result', [
            'calories' => round($totalCalories),
            'comment' => $comment
        ]);
    }

    // История еды
    public function history()
    {
        $logs = MealLog::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('foods.history', compact('logs'));
    }
}
