@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="admin-container">
    <header class="admin-header">
        <h1 class="admin-title">Statistics</h1>
        <a href="{{ route('admin.dashboard') }}" class="admin-back-btn">← Back to Dashboard</a>
    </header>

    <div class="admin-section">
        <h2 class="admin-section-title">User Registrations (by Month)</h2>
        <div class="admin-chart">
            <canvas id="userChart"></canvas>
        </div>
    </div>

    <div class="admin-section">
        <h2 class="admin-section-title">Post Creations (by Month)</h2>
        <div class="admin-chart">
            <canvas id="postChart"></canvas>
        </div>
    </div>
</div>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const userStats = @json($userStats);
        const postStats = @json($postStats);

        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        const userChart = new Chart(document.getElementById('userChart'), {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'New Users',
                    data: userStats.map(stat => stat.count),
                    backgroundColor: 'rgba(0, 255, 0, 0.5)',
                    borderColor: 'rgba(0, 255, 0, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        const postChart = new Chart(document.getElementById('postChart'), {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'New Posts',
                    data: postStats.map(stat => stat.count),
                    backgroundColor: 'rgba(0, 255, 0, 0.5)',
                    borderColor: 'rgba(0, 255, 0, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
@endsection