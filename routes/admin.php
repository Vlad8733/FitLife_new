<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminPanelController;

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminPanelController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminPanelController::class, 'users'])->name('admin.users');
    Route::get('/users/{user}', [AdminPanelController::class, 'usersShow'])->name('admin.users.show');
    Route::get('/users/{user}/edit', [AdminPanelController::class, 'usersEdit'])->name('admin.users.edit');
    Route::patch('/users/{user}', [AdminPanelController::class, 'usersUpdate'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminPanelController::class, 'usersDelete'])->name('admin.users.delete');
    Route::get('/posts', [AdminPanelController::class, 'posts'])->name('admin.posts');
    Route::delete('/posts/{post}', [AdminPanelController::class, 'postsDelete'])->name('admin.posts.delete');
    Route::get('/events', [AdminPanelController::class, 'events'])->name('admin.events');
    Route::delete('/events/{event}', [AdminPanelController::class, 'eventsDelete'])->name('admin.events.delete');
    Route::get('/statistics', [AdminPanelController::class, 'statistics'])->name('admin.statistics');
});