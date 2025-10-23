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
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Admin\AdminPanelController;
use Illuminate\Support\Facades\Route;

// Main page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Privacy Policy
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

// Terms of Service
Route::get('/terms-of-service', function () {
    return view('terms-of-service');
})->name('terms-of-service');

// Authentication routes
require __DIR__ . '/auth.php';

// Admin routes
require __DIR__ . '/admin.php';

// All routes requiring authentication and email verification
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // AJAX for pagination
    Route::get('/meal-logs', [DashboardController::class, 'mealLogsAjax'])->name('meal.logs.ajax');
    Route::get('/sleep-logs', [DashboardController::class, 'sleepLogsAjax'])->name('sleep.logs.ajax');
    Route::get('/water-logs', [DashboardController::class, 'waterLogsAjax'])->name('water.logs.ajax');

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/{user}', [ProfileController::class, 'show'])->name('profile.show');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    });

    // Friends routes
    Route::prefix('friends')->group(function () {
        Route::post('/{user}', [FriendController::class, 'store'])->name('friends.store');
        Route::post('/{user}/accept', [FriendController::class, 'accept'])->name('friends.accept');
        Route::delete('/{user}', [FriendController::class, 'remove'])->name('friends.remove');
    });

    // Food tracker routes
    Route::prefix('tracker/foods')->group(function () {
        Route::get('/', [FoodController::class, 'index'])->name('foods.index');
        Route::post('/calculate', [FoodController::class, 'calculate'])->name('foods.calculate');
        Route::get('/history', [FoodController::class, 'history'])->name('foods.history');
    });

    // Sleep tracker routes
    Route::prefix('tracker/sleep')->group(function () {
        Route::get('/', [SleepController::class, 'index'])->name('sleep.index');
        Route::post('/', [SleepController::class, 'store'])->name('sleep.store');
    });

    // Water tracker routes
    Route::prefix('tracker/water')->group(function () {
        Route::get('/', [WaterController::class, 'index'])->name('water.index');
        Route::post('/', [WaterController::class, 'store'])->name('water.store');
    });

    // Progress photos routes
    Route::prefix('progress-photos')->group(function () {
        Route::get('/', [ProgressPhotoController::class, 'index'])->name('progress.index');
        Route::post('/', [ProgressPhotoController::class, 'store'])->name('progress.store');
        Route::patch('/{progress}', [ProgressPhotoController::class, 'update'])->name('progress.update');
        Route::delete('/{progress}', [ProgressPhotoController::class, 'destroy'])->name('progress.destroy');
    });

    // Goals routes
    Route::prefix('goals')->group(function () {
        Route::get('/', [GoalController::class, 'index'])->name('goals.index');
        Route::get('/create', [GoalController::class, 'create'])->name('goals.create');
        Route::post('/', [GoalController::class, 'store'])->name('goals.store');
        Route::get('/{goal}/log', [GoalController::class, 'log'])->name('goals.log');
        Route::post('/{goal}/log', [GoalController::class, 'storeLog'])->name('goals.storeLog');
        Route::patch('/{goal}', [GoalController::class, 'update'])->name('goals.update');
        Route::delete('/{goal}', [GoalController::class, 'destroy'])->name('goals.destroy');
    });

    // Calorie calculator routes
    Route::prefix('calories')->group(function () {
        Route::get('/', [CalorieCalculatorController::class, 'index'])->name('calories.index');
        Route::post('/', [CalorieCalculatorController::class, 'calculate'])->name('calories.calculate');
    });

    // Biography routes
    Route::prefix('biography')->group(function () {
        Route::get('/', [BiographyController::class, 'edit'])->name('biography.edit');
        Route::patch('/', [BiographyController::class, 'update'])->name('biography.update');
    });

    // Posts routes
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/reaction', [PostController::class, 'toggleReaction'])->name('posts.toggleReaction');
    Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::post('/posts/{post}/views', [PostController::class, 'incrementViews'])->name('posts.views');

    // Comments routes
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::post('/comments/{comment}/toggle-reaction', [CommentController::class, 'toggleReaction'])->name('comments.toggle-reaction');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Activity Calendar routes
    Route::prefix('calendar')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('activity-calendar');
        Route::post('/', [CalendarController::class, 'store'])->name('calendar.store');
        Route::patch('/{calendar}', [CalendarController::class, 'update'])->name('calendar.update');
        Route::get('/events', [CalendarController::class, 'getEvents'])->name('calendar.events');
    });
});