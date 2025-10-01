@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/water.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Water Tracker">
    <main>
        <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <header>
            <div class="header-left">
                <h1><span>FitLife</span> Water Tracker</h1>
                <p class="muted">Log and track your daily hydration</p>
            </div>
        </header>

        <section aria-labelledby="kpi-heading">
            <h3 id="kpi-heading">Today's Hydration</h3>
            <div class="result-card">
                <div class="result-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#0000FF">
                        <path d="M491-200q12-1 20.5-9.5T520-230q0-14-9-22.5t-23-7.5q-41 3-87-22.5T343-375q-2-11-10.5-18t-19.5-7q-14 0-23 10.5t-6 24.5q17 91 80 130t127 35ZM480-80q-137 0-228.5-94T160-408q0-100 79.5-217.5T480-880q161 137 240.5 254.5T800-408q0 140-91.5 234T480-80Zm0-80q104 0 172-70.5T720-408q0-73-60.5-165T480-774Q361-665 300.5-573T240-408q0 107 68 177.5T480-160Zm0-320Z" />
                    </svg>
                </div>
                <div class="result-body">
                    <h4>Total Water Today</h4>
                    <div class="value count-up" data-target="{{ $logs->sum('amount') ?? 0 }}">0</div>
                    <div class="muted">ml</div>
                </div>
            </div>
        </section>

        <section aria-labelledby="water-form-heading">
            <h3 id="water-form-heading">Log Your Hydration</h3>
            <div class="water-card">
                <h4>Add Water Intake</h4>
                <form action="{{ route('water.store') }}" method="POST" class="water-form">
                    @csrf
                    <div class="form-group">
                        <label for="amount">Amount (ml)</label>
                        <input type="number" id="amount" name="amount" placeholder="Enter amount in ml" required>
                    </div>
                    <button type="submit" class="calculate-btn">Log Water</button>
                </form>
            </div>
        </section>

        <section id="history-section" aria-labelledby="history-heading">
            <h3 id="history-heading">Hydration History</h3>
            @if($logs->isEmpty())
                <div class="history-table">
                    <div class="no-data">No water logs yet. Start logging your hydration!</div>
                </div>
            @else
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Amount (ml)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                                <td>{{ $log->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </section>
    </main>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/water.js') }}"></script>
@endsection