@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/log.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Log Progress">
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
        <h1><span>FitLife</span> Log Progress</h1>
        <p class="muted">Update your progress for {{ ucfirst($goal->type) }} goal</p>
      </div>
    </header>

    <!-- Log Form -->
    <section aria-labelledby="log-form-heading">
      <h3 id="log-form-heading">Log Progress for {{ ucfirst($goal->type) }}</h3>
      <div class="log-card">
        <form action="{{ route('goals.storeLog', $goal) }}" method="POST" class="log-form">
          @csrf
          <div class="form-group">
            <label for="value">Today's Value</label>
            <input type="number" id="value" name="value" step="0.01" placeholder="Enter today's value" required>
          </div>
          <button type="submit" class="calculate-btn">Submit</button>
        </form>
      </div>
    </section>
  </main>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/log.js') }}"></script>
@endsection