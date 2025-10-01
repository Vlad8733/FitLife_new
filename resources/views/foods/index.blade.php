@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/foods.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Meal Tracker">
    <main>
        <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">Menu</button>
        <header>
            <div class="header-left">
                <h1>Meal Tracker</h1>
                <p class="muted">Log and analyze your daily nutrition</p>
            </div>
        </header>

        <div id="notification" class="notification" role="alert"></div>

        <section aria-labelledby="meal-form-heading">
            <h3 id="meal-form-heading">Log Your Meals</h3>
            <form action="{{ route('foods.calculate') }}" method="POST" class="meal-grid-form" id="meal-form">
                @csrf
                @php $meals = ['Breakfast', 'Lunch', 'Dinner', 'Snack']; @endphp
                <div class="meals-grid">
                    @foreach($meals as $meal)
                        <div class="meal-block">
                            <div class="meal-card" data-meal-block="{{ $meal }}">
                                <h4>{{ $meal }}</h4>
                                <div class="meal-items" data-meal="{{ $meal }}">
                                    <div class="meal-item">
                                        <select class="food-select" name="meals[{{ $meal }}][0][food]" aria-label="Select food for {{ $meal }}">
                                            <option value="">Select Food</option>
                                            @foreach($foods as $food => $cal)
                                                <option value="{{ $food }}" data-calories="{{ $cal }}">{{ $food }} ({{ $cal }} kcal)</option>
                                            @endforeach
                                        </select>
                                        <input type="number" class="quantity-input" name="meals[{{ $meal }}][0][quantity]" placeholder="g/ml" style="display:none;" min="0" step="1" aria-label="Quantity for {{ $meal }} food">
                                        <div class="calorie-preview" data-calories="0">0 kcal</div>
                                        <button type="button" class="remove-food-btn" style="display:none;" aria-label="Remove food item">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <path d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="add-food-btn" data-meal="{{ $meal }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                        <path d="M12 5v14M5 12h14"/>
                                    </svg>
                                    Add Item
                                </button>
                                <div class="total-calories" data-total-calories="0">Total: 0 kcal</div>
                                @error("meals.{$meal}.*")
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            @if($meal === 'Breakfast')
                                <div class="calculate-container">
                                    <button type="submit" class="calculate-btn" id="calculate-btn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                            <path d="M12 2v20M5 12h14"/>
                                        </svg>
                                        Calculate Calories
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </form>
        </section>

        <section id="history-section" aria-labelledby="history-heading">
            <h3 id="history-heading">Meal History</h3>
            @include('profile.partials.meal_table', ['mealLogs' => $logs])
        </section>

        @if(session('result'))
            <section aria-labelledby="result-heading">
                <h3 id="result-heading">Your Meal Summary</h3>
                <div class="result-card">
                    <div class="result-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M4 21c4-4 6-11 6-17"/>
                            <path d="M20 7a4 4 0 11-8 0"/>
                        </svg>
                    </div>
                    <div class="result-body">
                        <h4>Total Calories</h4>
                        <div class="value">{{ session('result')['calories'] }} kcal</div>
                        <div class="muted">{{ session('result')['comment'] }}</div>
                    </div>
                </div>
            </section>
        @endif
    </main>
</div>

<script>
    window.foodCalories = @json($foods);
    window.foodsIndexUrl = '{{ route('foods.index') }}';
    window.foodOptionsHTML = `<option value="">Select Food</option>
        @foreach($foods as $food => $cal)
            <option value="{{ $food }}" data-calories="{{ $cal }}">{{ $food }} ({{ $cal }} kcal)</option>
        @endforeach`;
</script>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/foods.js') }}"></script>
@endsection