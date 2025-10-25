<?php

use App\Models\Goal;
use App\Models\GoalLog;
use Tests\TestCase;

uses(TestCase::class);

it('goal has many logs', function () {
    // Создаём цель с обязательным полем type
    $goal = Goal::factory()->create([
        'type' => 'weight', // обязательное поле
        'title' => 'Test Goal',
        'description' => 'Testing relation between goal and logs',
        'target_value' => 50,
        'current_value' => 10,
    ]);

    // Создаём 3 записи логов, связанных с этой целью
    $logs = GoalLog::factory()->count(3)->create([
        'goal_id' => $goal->id,
    ]);

    // Проверяем, что у цели действительно 3 лога
    expect($goal->logs)->toHaveCount(3);
    expect($goal->logs->pluck('id'))->toEqual($logs->pluck('id'));
});
