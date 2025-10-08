@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Create Goal">
  <!-- Main Content -->
  <main>
    <!-- Mobile Menu Toggle -->
    <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Page Header -->
    <header>
      <div class="header-left">
        <h1><span>FitLife</span> Create Goal</h1>
        <p class="muted">Set a new goal to stay motivated!</p>
      </div>
    </header>

    <!-- Goal Form Section -->
    <section aria-labelledby="goal-form-heading">
      <h3 id="goal-form-heading">Create New Goal</h3>
      <div class="goal-card">
        <form action="{{ route('goals.store') }}" method="POST" class="goal-form">
          @csrf
          <div class="form-group">
            <label for="type">Goal Type</label>
            <select id="type" name="type" required>
              <option value="">Select goal</option>
              <option value="steps">Steps</option>
              <option value="calories">Calories</option>
              <option value="sleep">Sleep (hours)</option>
              <option value="weight">Weight (kg)</option>
            </select>
          </div>

          <div class="form-group">
            <label for="target_value">Target Value</label>
            <input type="number" id="target_value" name="target_value" step="0.01" placeholder="Enter target value" required>
          </div>

          <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" required>
          </div>

          <div class="form-group">
            <label for="description">Description (optional)</label>
            <textarea id="description" name="description" rows="3" placeholder="Add a description">{{ old('description') }}</textarea>
          </div>

          <button type="submit" class="calculate-btn">Create Goal</button>
        </form>
      </div>
    </section>
  </main>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/create.js') }}"></script>
@endsection