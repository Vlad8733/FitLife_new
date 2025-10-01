@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/sleep.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Sleep Tracker">
    <main>
        <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <header>
            <div class="header-left">
                <h1><span>FitLife</span> Sleep Tracker</h1>
                <p class="muted">Log and track your sleep patterns</p>
            </div>
        </header>

        @if(session('success'))
            <section aria-labelledby="success-heading">
                <h3 id="success-heading">Status</h3>
                <div class="result-card">
                    <div class="result-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                        </svg>
                    </div>
                    <div class="result-body">
                        <h4>Success</h4>
                        <div class="value">{{ session('success') }}</div>
                    </div>
                </div>
            </section>
        @endif

        <section aria-labelledby="sleep-form-heading">
            <h3 id="sleep-form-heading">Log Your Sleep</h3>
            <div class="sleep-card">
                <h4>Add Sleep Record</h4>
                <form action="{{ route('sleep.store') }}" method="POST" class="sleep-form">
                    @csrf
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input type="time" id="start_time" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input type="time" id="end_time" name="end_time" required>
                    </div>
                    <button type="submit" class="calculate-btn">Add Sleep Record</button>
                </form>
            </div>
        </section>

        <section id="history-section" aria-labelledby="history-heading">
            <h3 id="history-heading">Sleep History</h3>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Duration (hrs)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sleeps as $sleep)
                        <tr>
                            <td>{{ $sleep->date }}</td>
                            <td>{{ $sleep->start_time }}</td>
                            <td>{{ $sleep->end_time }}</td>
                            <td>{{ round($sleep->duration, 1) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="no-data">No sleep records yet. Start logging your sleep!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        @if($average)
            <section aria-labelledby="average-heading">
                <h3 id="average-heading">Sleep Summary</h3>
                <div class="result-card">
                    <div class="result-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                        </svg>
                    </div>
                    <div class="result-body">
                        <h4>Average Sleep</h4>
                        <div class="value count-up" data-target="{{ round($average, 1) }}">0</div>
                        <div class="muted">hours per night</div>
                    </div>
                </div>
            </section>
        @endif
    </main>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/sleep.js') }}"></script>
@endsection