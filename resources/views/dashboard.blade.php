@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container">
    <main>
        <!-- Header -->
        <header>
            <h1>Hello, {{ Auth::user()->name }}!</h1>
        </header>

        <!-- User stats -->
        <section class="stats">
            <h3>Your Stats</h3>
            @php $bio = Auth::user()->biography; @endphp
            <div class="stats-grid">
                <div><span>Name</span>{{ $bio->full_name ?? Auth::user()->name }}</div>
                <div><span>Age</span>{{ $bio->age ?? 'Not set' }}</div>
                <div><span>Height</span>{{ $bio->height ?? 'Not set' }} cm</div>
                <div><span>Weight</span>{{ $bio->weight ?? 'Not set' }} kg</div>
                <div><span>Gender</span>{{ ucfirst($bio->gender ?? 'Not set') }}</div>
            </div>
        </section>

        <!-- Metrics -->
        <section class="metrics">
            <h3>Metrics</h3>
            <div class="metrics-grid">
                <div class="metric-card">
                    <h4>Calories</h4>
                    <span class="value" data-target="{{ $totalCalories ?? 0 }}">0</span>
                    <span>kcal</span>
                </div>
                <div class="metric-card">
                    <h4>Sleep</h4>
                    <span class="value" data-target="{{ round($totalSleep ?? 0, 1) }}">0</span>
                    <span>hours</span>
                </div>
                <div class="metric-card">
                    <h4>Water</h4>
                    <span class="value" data-target="{{ $totalWater ?? 0 }}">0</span>
                    <span>ml</span>
                </div>
            </div>
        </section>

        <!-- Progress photos -->
        <section class="gallery">
            <h3>Progress</h3>
            <div class="gallery-grid">
                @forelse($photos as $idx => $photo)
                    <div class="photo-item" role="button" tabindex="0" data-idx="{{ $idx }}"
                         data-img="{{ asset('storage/' . $photo->photo) }}"
                         data-desc="{{ $photo->description ?? '' }}"
                         data-date="{{ $photo->created_at->format('M d, Y') }}">
                        <img src="{{ asset('storage/' . $photo->photo) }}" alt="Progress photo" loading="lazy">
                    </div>
                @empty
                    <p>No photos yet. <a href="{{ route('progress.index') }}">Add one</a></p>
                @endforelse
            </div>
        </section>

        <!-- Goals -->
        <section class="goals">
            <h3>Goals</h3>
            @if($goals->isEmpty())
                <p>No goals set. <a href="{{ route('goals.index') }}">Set one</a></p>
            @else
                <div class="goals-grid">
                    @foreach($goals as $goal)
                        @php $percent = min(100, max(0, (int) $goal->progressPercent())); @endphp
                        <div class="goal-item">
                            <span>{{ $goal->type }}</span>
                            <div class="goal-progress">
                                <div class="progress-bar" data-progress="{{ $percent }}">
                                    <div class="progress-fill"></div>
                                </div>
                                <span>{{ round($goal->current_value, 1) }} / {{ $goal->target_value }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Lightbox -->
        <div id="lightbox" role="dialog" aria-hidden="true">
            <div class="lightbox-content">
                <button class="lightbox-close" aria-label="Close">×</button>
                <img id="lightbox-img" src="" alt="Lightbox image">
                <div class="lightbox-info">
                    <p id="lightbox-desc"></p>
                    <p id="lightbox-date"></p>
                </div>
                <button class="lightbox-nav prev" aria-label="Previous">←</button>
                <button class="lightbox-nav next" aria-label="Next">→</button>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection