@extends('layouts.app', ['title' => 'FitLife — Activity Calendar'])

@section('content')
    <div id="fitlife-container" class="particle-bg">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <header class="header fade-in">
            <h1 class="header__title fs-2xl fw-bold">Activity Calendar</h1>
            <span class="header__username fs-sm text-muted">Plan your workouts and track your progress</span>
        </header>

        <section aria-labelledby="calendar-heading" class="fade-in">

            <div class="calendar-controls p-3 bg-card br-12 shadow-md">
                <button class="calendar-nav-btn prev-month" aria-label="Previous month">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h4 class="calendar-month fs-lg fw-medium text-center"></h4>
                <button class="calendar-nav-btn next-month" aria-label="Next month">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <div class="calendar-grid role-grid p-3 bg-card br-12 shadow-md mt-3">
                <!-- Days will be added via JS -->
            </div>

            <div class="calendar-event-form bg-card p-4 mt-4 br-12 shadow-md">
                <h4 class="fs-md fw-medium mb-3">Add Event</h4>
                <form id="event-form" action="{{ route('calendar.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="event-date" class="fs-sm fw-medium">Date</label>
                        <div class="input-group">
                            <i class="fas fa-calendar-alt input-icon"></i>
                            <input type="date" id="event-date" name="date" class="fs-sm" required aria-describedby="event-date-error">
                        </div>
                        @error('date')
                            <div class="error-message" id="event-date-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="event-type" class="fs-sm fw-medium">Event Type</label>
                        <div class="input-group">
                            <i class="fas fa-dumbbell input-icon"></i>
                            <select id="event-type" name="type" class="fs-sm" required aria-describedby="event-type-error">
                                <option value="" disabled selected>Select an event type</option>
                                <option value="workout">Workout</option>
                                <option value="rest">Rest</option>
                                <option value="goal">Goal</option>
                                <option value="running">Running</option>
                                <option value="yoga">Yoga</option>
                                <option value="cycling">Cycling</option>
                                <option value="swimming">Swimming</option>
                                <option value="weightlifting">Weightlifting</option>
                                <option value="hiking">Hiking</option>
                                <option value="boxing">Boxing</option>
                                <option value="dance">Dance</option>
                                <option value="crossfit">CrossFit</option>
                                <option value="walking">Walking</option>
                                <option value="meditation">Meditation</option>
                            </select>
                        </div>
                        @error('type')
                            <div class="error-message" id="event-type-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="event-description" class="fs-sm fw-medium">Description</label>
                        <div class="input-group">
                            <i class="fas fa-comment input-icon"></i>
                            <input type="text" id="event-description" name="description" class="fs-sm" placeholder="E.g., Strength Training or Run 5km" aria-describedby="event-description-error">
                        </div>
                        @error('description')
                            <div class="error-message" id="event-description-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="save-btn fs-sm fw-medium">
                        <i class="fas fa-save"></i> Save Event
                    </button>
                </form>
                <div id="form-message" class="mt-3 fs-sm"></div>
            </div>

            <div class="calendar-events mt-4">
                <h4 class="fs-md fw-medium mb-3">Your Events</h4>
                <div class="event-filter">
                    <label for="event-filter" class="fs-sm fw-medium">Filter by Type:</label>
                    <select id="event-filter" class="fs-sm">
                        <option value="all">All Events</option>
                        <option value="workout">Workout</option>
                        <option value="rest">Rest</option>
                        <option value="goal">Goal</option>
                        <option value="running">Running</option>
                        <option value="yoga">Yoga</option>
                        <option value="cycling">Cycling</option>
                        <option value="swimming">Swimming</option>
                        <option value="weightlifting">Weightlifting</option>
                        <option value="hiking">Hiking</option>
                        <option value="boxing">Boxing</option>
                        <option value="dance">Dance</option>
                        <option value="crossfit">CrossFit</option>
                        <option value="walking">Walking</option>
                        <option value="meditation">Meditation</option>
                    </select>
                </div>
                <ul class="event-list"></ul>
            </div>
        </section>
    </div>

    <!-- SVG Icons -->
    <svg style="display: none;">
        <symbol id="chevron-left" viewBox="0 0 24 24">
            <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
        </symbol>
        <symbol id="chevron-right" viewBox="0 0 24 24">
            <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z"/>
        </symbol>
        <symbol id="save" viewBox="0 0 24 24">
            <path d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
        </symbol>
        <symbol id="check" viewBox="0 0 24 24">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </symbol>
        <symbol id="edit" viewBox="0 0 24 24">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
        </symbol>
        <symbol id="trash" viewBox="0 0 24 24">
            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
        </symbol>
    </svg>
@endsection

@section('styles')
    <link href="{{ asset('css/activity-calendar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection

@section('scripts')
    <script src="{{ asset('js/activity-calendar.js') }}"></script>
@endsection