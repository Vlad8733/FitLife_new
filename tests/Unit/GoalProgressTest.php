<?php

use App\Models\Goal;

it('calculates progress correctly', function () {
    $goal = new Goal([
        'target_value' => 100,
        'current_value' => 25,
    ]);

    expect((float) $goal->progressPercent())->toBe(25.0);

    $goal->current_value = 120;
    expect((float) $goal->progressPercent())->toBe(100.0);

    $goal->target_value = 0;
    expect((float) $goal->progressPercent())->toBe(0.0);
});
