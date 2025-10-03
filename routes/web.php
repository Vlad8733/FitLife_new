<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\SleepController;
use App\Http\Controllers\ProgressPhotoController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WaterController;
use App\Http\Controllers\CalorieCalculatorController;
use App\Http\Controllers\BiographyController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    return view('welcome');
});

// Аутентификация
require __DIR__ . '/auth.php';

// Все маршруты, требующие авторизации
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // AJAX для пагинации
    Route::get('/meal-logs', [DashboardController::class, 'mealLogsAjax'])->name('meal.logs.ajax');
    Route::get('/sleep-logs', [DashboardController::class, 'sleepLogsAjax'])->name('sleep.logs.ajax');
    Route::get('/water-logs', [DashboardController::class, 'waterLogsAjax'])->name('water.logs.ajax');

    // Профиль
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/{user}', [ProfileController::class, 'show'])->name('profile.show');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    });

    // Друзья
    Route::prefix('friends')->group(function () {
        Route::post('/{user}', [FriendController::class, 'store'])->name('friends.store');
        Route::post('/{user}/accept', [FriendController::class, 'accept'])->name('friends.accept');
        Route::delete('/{user}', [FriendController::class, 'remove'])->name('friends.remove');
    });

    // Трекер еды
    Route::prefix('tracker/foods')->group(function () {
        Route::get('/', [FoodController::class, 'index'])->name('foods.index');
        Route::post('/calculate', [FoodController::class, 'calculate'])->name('foods.calculate');
        Route::get('/history', [FoodController::class, 'history'])->name('foods.history');
    });

    // Трекер сна
    Route::prefix('tracker/sleep')->group(function () {
        Route::get('/', [SleepController::class, 'index'])->name('sleep.index');
        Route::post('/', [SleepController::class, 'store'])->name('sleep.store');
    });

    // Трекер воды
    Route::prefix('tracker/water')->group(function () {
        Route::get('/', [WaterController::class, 'index'])->name('water.index');
        Route::post('/', [WaterController::class, 'store'])->name('water.store');
    });

    // Прогресс-фотки
    Route::prefix('progress-photos')->group(function () {
        Route::get('/', [ProgressPhotoController::class, 'index'])->name('progress.index');
        Route::post('/', [ProgressPhotoController::class, 'store'])->name('progress.store');
        Route::patch('/{progress}', [ProgressPhotoController::class, 'update'])->name('progress.update');
        Route::delete('/{progress}', [ProgressPhotoController::class, 'destroy'])->name('progress.destroy');
    });

    // Цели
    Route::prefix('goals')->group(function () {
        Route::get('/', [GoalController::class, 'index'])->name('goals.index');
        Route::get('/create', [GoalController::class, 'create'])->name('goals.create');
        Route::post('/', [GoalController::class, 'store'])->name('goals.store');
        Route::get('/{goal}/log', [GoalController::class, 'log'])->name('goals.log');
        Route::post('/{goal}/log', [GoalController::class, 'storeLog'])->name('goals.storeLog');
        Route::patch('/{goal}', [GoalController::class, 'update'])->name('goals.update');
        Route::delete('/{goal}', [GoalController::class, 'destroy'])->name('goals.destroy');
    });

    // Калькулятор калорий
    Route::prefix('calories')->group(function () {
        Route::get('/', [CalorieCalculatorController::class, 'index'])->name('calories.index');
        Route::post('/', [CalorieCalculatorController::class, 'calculate'])->name('calories.calculate');
    });

    // Биография
    Route::prefix('biography')->group(function () {
        Route::get('/', [BiographyController::class, 'edit'])->name('biography.edit');
        Route::patch('/', [BiographyController::class, 'update'])->name('biography.update');
    });

    // Посты
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/reaction', [PostController::class, 'toggleReaction'])->name('posts.toggleReaction');
    Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::post('/posts/{post}/views', [PostController::class, 'incrementView'])->name('posts.views');
    Route::get('/posts/{post}/views', [PostController::class, 'getViews'])->name('posts.getViews');

    // Комментарии
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::post('/comments/{comment}/toggle-reaction', [CommentController::class, 'toggleReaction'])->name('comments.toggle-reaction');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});