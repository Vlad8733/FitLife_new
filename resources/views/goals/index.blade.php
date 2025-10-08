@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/goalsindex.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Goals">
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
        <h1><span>FitLife</span> Goals</h1>
        <p class="muted">Track your daily progress and stay motivated!</p>
      </div>
    </header>

    <!-- Create Goal Button -->
    <section aria-labelledby="create-goal-heading">
      <h3 id="create-goal-heading">Your Goals</h3>
      <a href="{{ route('goals.create') }}" class="create-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M12 5v14M5 12h14" />
        </svg>
        New Goal
      </a>
    </section>

    <!-- Goals List -->
    <section aria-labelledby="goals-heading">
      <div class="goals-grid">
        @forelse($goals as $goal)
        <div class="goal-card">
          <h4>{{ ucfirst($goal->type) }} Goal</h4>
          <p><strong>Target:</strong> {{ $goal->target_value }}</p>
          <p><strong>Current:</strong> {{ $goal->current_value }}</p>
          <p><strong>End Date:</strong> {{ $goal->end_date }}</p>
          @if($goal->description)
          <p><em>{{ $goal->description }}</em></p>
          @endif
          <div class="progress-bar">
            <div class="progress" style="width: {{ min($goal->current_value / $goal->target_value * 100, 100) }}%;"></div>
          </div>
          <a href="{{ route('goals.log', $goal) }}" class="log-btn">Log Progress</a>
        </div>
        @empty
        <p class="no-data">No goals set yet. Start creating your goals!</p>
        @endforelse
      </div>
    </section>
  </main>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/goalsindex.js') }}"></script>
@endsection