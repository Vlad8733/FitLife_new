@extends('layouts.app')

@section('content')
    <header class="header">
        <h1 class="header__title fs-2xl fw-bold">Activity Calendar</h1>
        <span class="header__username fs-sm text-muted">Plan workouts and track progress</span>
    </header>

    <section aria-labelledby="calendar-heading">
        <h3 id="calendar-heading" class="fs-xl fw-bold m-3">Your Calendar</h3>

        <div class="calendar-controls p-3 bg-card br-12 shadow-md">
            <button class="calendar-nav-btn prev-month" aria-label="Previous month">
                <svg><use xlink:href="#chevron-left"></use></svg>
            </button>
            <h4 class="calendar-month fs-lg fw-medium text-center"></h4>
            <button class="calendar-nav-btn next-month" aria-label="Next month">
                <svg><use xlink:href="#chevron-right"></use></svg>
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
                    <input type="date" id="event-date" name="date" class="fs-sm" required>
                </div>
                <div class="form-group">
                    <label for="event-type" class="fs-sm fw-medium">Event Type</label>
                    <select id="event-type" name="type" class="fs-sm" required>
                        <option value="" disabled selected>Select an event type</option>
                        <option value="workout">Workout</option>
                        <option value="rest">Rest</option>
                        <option value="goal">Goal</option>
                        <option value="running">Running</option>
                        <option value="gym">Gym</option>
                        <option value="yoga">Yoga</option>
                        <option value="cardio">Cardio</option>
                        <option value="stretching">Stretching</option>
                        <option value="cycling">Cycling</option>
                        <option value="swimming">Swimming</option>
                        <option value="weightlifting">Weightlifting</option>
                        <option value="pilates">Pilates</option>
                        <option value="hiking">Hiking</option>
                        <option value="boxing">Boxing</option>
                        <option value="dance">Dance</option>
                        <option value="crossfit">CrossFit</option>
                        <option value="walking">Walking</option>
                        <option value="meditation">Meditation</option>
                        <option value="tennis">Tennis</option>
                        <option value="basketball">Basketball</option>
                        <option value="soccer">Soccer</option>
                        <option value="climbing">Climbing</option>
                        <option value="rowing">Rowing</option>
                        <option value="martial_arts">Martial Arts</option>
                        <option value="recovery">Recovery</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="event-description" class="fs-sm fw-medium">Description</label>
                    <input type="text" id="event-description" name="description" class="fs-sm" placeholder="E.g., Strength Training or Run 5km">
                </div>
                <button type="submit" class="save-btn fs-sm fw-medium">
                    <svg><use xlink:href="#save"></use></svg>
                    Save Event
                </button>
            </form>
            <div id="form-message" class="mt-3 fs-sm"></div>
        </div>

        <div class="calendar-events mt-4">
            <h4 class="fs-md fw-medium mb-3">Your Events</h4>
            <ul class="event-list"></ul>
        </div>
    </section>
@endsection

@section('styles')
    <link href="{{ asset('css/activity-calendar.css') }}" rel="stylesheet">
    <style>
        #form-message.success { color: var(--success); }
        #form-message.error { color: var(--error); }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/activity-calendar.js') }}"></script>
@endsection