@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/calories.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Calorie Calculator">
    <main>
        <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <header>
            <div class="header-left">
                <h1><span>FitLife</span> Calorie & Macro Calculator</h1>
                <p class="muted">Calculate your daily calorie and macro needs!</p>
            </div>
        </header>

        <section aria-labelledby="calculator-heading">
            <div class="biography-card">
                <h3 id="calculator-heading">Calorie Calculator</h3>
                <form action="{{ route('calories.calculate') }}" method="POST" class="form-logging">
                    @csrf
                    <div class="form-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="number" id="weight" name="weight" placeholder="Weight (kg)"
                            value="{{ old('weight', $user->weight) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="height">Height (cm)</label>
                        <input type="number" id="height" name="height" placeholder="Height (cm)"
                            value="{{ old('height', $user->height) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" placeholder="Age" value="{{ old('age', $user->age) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="activity_level">Activity Level</label>
                        <select id="activity_level" name="activity_level" required>
                            <option value="">Select Activity Level</option>
                            <option value="sedentary" {{ old('activity_level', $user->activity_level) == 'sedentary' ? 'selected' : '' }}>Sedentary</option>
                            <option value="light" {{ old('activity_level', $user->activity_level) == 'light' ? 'selected' : '' }}>Light
                            </option>
                            <option value="moderate" {{ old('activity_level', $user->activity_level) == 'moderate' ? 'selected' : '' }}>
                                Moderate</option>
                            <option value="active" {{ old('activity_level', $user->activity_level) == 'active' ? 'selected' : '' }}>
                                Active</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="goal_type">Goal</label>
                        <select id="goal_type" name="goal_type" required>
                            <option value="">Select Goal</option>
                            <option value="lose_weight" {{ old('goal_type', $user->goal_type) == 'lose_weight' ? 'selected' : '' }}>Lose
                                Weight</option>
                            <option value="maintain" {{ old('goal_type', $user->goal_type) == 'maintain' ? 'selected' : '' }}>Maintain
                            </option>
                            <option value="gain_weight" {{ old('goal_type', $user->goal_type) == 'gain_weight' ? 'selected' : '' }}>Gain
                                Weight</option>
                        </select>
                    </div>
                    <button type="submit" class="calculate-btn">
<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffffff"><path d="M320-240h60v-80h80v-60h-80v-80h-60v80h-80v60h80v80Zm200-30h200v-60H520v60Zm0-100h200v-60H520v60Zm44-152 56-56 56 56 42-42-56-58 56-56-42-42-56 56-56-56-42 42 56 56-56 58 42 42Zm-314-70h200v-60H250v60Zm-50 472q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
                        Calculate
                    </button>
                </form>
            </div>
        </section>

        @isset($calories)
            <section aria-labelledby="results-heading">
                <h3 id="results-heading">Your Results</h3>
                <div class="kpi-container">
                    <div class="kpi-card">
                        <h4>Recommended Daily Calories</h4>
                        <p>{{ round($calories) }} kcal</p>
                    </div>
                    <div class="kpi-card">
                        <h4>Protein</h4>
                        <p>{{ $protein }}g</p>
                    </div>
                    <div class="kpi-card">
                        <h4>Fats</h4>
                        <p>{{ $fat }}g</p>
                    </div>
                    <div class="kpi-card">
                        <h4>Carbs</h4>
                        <p>{{ $carbs }}g</p>
                    </div>
                    <div class="kpi-card">
                        <h4>Calories Consumed Today</h4>
                        <p>{{ $todayCalories }} kcal</p>
                    </div>
                    <div class="kpi-card">
                        <h4>Status</h4>
                        <p class="status-text">
                            @if($todayCalories < $calories)
                                You can still eat ~{{ round($calories - $todayCalories) }} kcal today.
                            @elseif($todayCalories > $calories)
                                You have exceeded your recommended calories by ~{{ round($todayCalories - $calories) }} kcal.
                            @else
                                Perfect! You met your target today.
                            @endif
                        </p>
                    </div>
                </div>
            </section>
        @endisset
    </main>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/calories.js') }}"></script>
@endsection