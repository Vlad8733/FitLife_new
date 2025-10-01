@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/biography.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Biography Settings">
    <main>
        <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <header>
            <div class="header-left">
                <h1><span>FitLife</span> Biography</h1>
                <p class="muted">Update your personal information</p>
            </div>
        </header>

        <section aria-labelledby="biography-settings-heading">
            @if(session('success'))
                <div class="success-msg">{{ session('success') }}</div>
            @endif

            <div class="biography-card">
                <h3 id="biography-settings-heading">Update Biography</h3>
                @php $bio = Auth::user()->biography ?? new \App\Models\Biography(); @endphp
                <form action="{{ route('biography.update') }}" method="POST" class="biography-form">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name"
                            value="{{ old('full_name', $bio->full_name ?? Auth::user()->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" value="{{ old('age', $bio->age ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="height">Height (cm)</label>
                        <input type="number" step="0.01" id="height" name="height" value="{{ old('height', $bio->height ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="number" step="0.01" id="weight" name="weight" value="{{ old('weight', $bio->weight ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="" {{ old('gender', $bio->gender ?? '') == '' ? 'selected' : '' }}>Select Gender</option>
                            <option value="male" {{ old('gender', $bio->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $bio->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $bio->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <button type="submit" class="save-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                            <path d="M17 21v-8H7v8" />
                            <path d="M7 3v5h8" />
                        </svg>
                        Save Biography
                    </button>
                </form>
            </div>
        </section>
    </main>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/biography.js') }}"></script>
@endsection