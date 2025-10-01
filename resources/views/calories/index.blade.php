@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Calorie Calculator">
    <!-- Main Content -->
    <main>
      <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <header>
        <div class="header-left">
          <h1><span>FitLife</span> Calorie & Macro Calculator</h1>
          <p class="muted">Calculate your daily calorie and macro needs!</p>
        </div>
      </header>

      <!-- Calculator Form -->
      <section aria-labelledby="calculator-heading">
        <div class="biography-card">
          <h3 id="calculator-heading">Calorie Calculator</h3>
          <form action="{{ route('calories.calculate') }}" method="POST" class="form-logging">
            @csrf
            <div class="form-group">
              <label for="weight">Weight (kg)</label>
              <input type="number" id="weight" name="weight" placeholder="Weight (kg)"
                value="{{ old('weight', $user->weight) }}" required>
            </div>
            <div class="form-group">
              <label for="height">Height (cm)</label>
              <input type="number" id="height" name="height" placeholder="Height (cm)"
                value="{{ old('height', $user->height) }}" required>
            </div>
            <div class="form-group">
              <label for="age">Age</label>
              <input type="number" id="age" name="age" placeholder="Age" value="{{ old('age', $user->age) }}" required>
            </div>
            <div class="form-group">
              <label for="activity_level">Activity Level</label>
              <select id="activity_level" name="activity_level" required>
                <option value="">Select Activity Level</option>
                <option value="sedentary" {{ old('activity_level', $user->activity_level) == 'sedentary' ? 'selected' : '' }}>Sedentary</option>
                <option value="light" {{ old('activity_level', $user->activity_level) == 'light' ? 'selected' : '' }}>Light
                </option>
                <option value="moderate" {{ old('activity_level', $user->activity_level) == 'moderate' ? 'selected' : '' }}>
                  Moderate</option>
                <option value="active" {{ old('activity_level', $user->activity_level) == 'active' ? 'selected' : '' }}>
                  Active</option>
              </select>
            </div>
            <div class="form-group">
              <label for="goal_type">Goal</label>
              <select id="goal_type" name="goal_type" required>
                <option value="">Select Goal</option>
                <option value="lose_weight" {{ old('goal_type', $user->goal_type) == 'lose_weight' ? 'selected' : '' }}>Lose
                  Weight</option>
                <option value="maintain" {{ old('goal_type', $user->goal_type) == 'maintain' ? 'selected' : '' }}>Maintain
                </option>
                <option value="gain_weight" {{ old('goal_type', $user->goal_type) == 'gain_weight' ? 'selected' : '' }}>Gain
                  Weight</option>
              </select>
            </div>
            <button type="submit" class="calculate-btn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 2h16a2 2 0 012 2v16a2 2 0 01-2 2H4a2 2 0 01-2-2V4a2 2 0 012-2z" />
                <path d="M8 6h8" />
                <path d="M6 8v8" />
                <path d="M8 16h8" />
                <path d="M16 8v8" />
              </svg>
              Calculate
            </button>
          </form>
        </div>
      </section>

      <!-- Results -->
      @isset($calories)
        <section aria-labelledby="results-heading">
          <h3 id="results-heading">Your Results</h3>
          <div class="kpi-container">
            <div class="kpi-card">
              <h4>Recommended Daily Calories</h4>
              <p>{{ round($calories) }} kcal</p>
            </div>
            <div class="kpi-card">
              <h4>Protein</h4>
              <p>{{ $protein }}g</p>
            </div>
            <div class="kpi-card">
              <h4>Fats</h4>
              <p>{{ $fat }}g</p>
            </div>
            <div class="kpi-card">
              <h4>Carbs</h4>
              <p>{{ $carbs }}g</p>
            </div>
            <div class="kpi-card">
              <h4>Calories Consumed Today</h4>
              <p>{{ $todayCalories }} kcal</p>
            </div>
            <div class="kpi-card">
              <h4>Status</h4>
              <p class="status-text">
                @if($todayCalories < $calories)
                  You can still eat ~{{ round($calories - $todayCalories) }} kcal today.
                @elseif($todayCalories > $calories)
                  You have exceeded your recommended calories by ~{{ round($todayCalories - $calories) }} kcal.
                @else
                  Perfect! You met your target today.
                @endif
              </p>
            </div>
          </div>
        </section>
      @endisset
    </main>
  </div>

  <style>
    :root {
      --bg: #f8f9fa;
      --text: #1a1a1a;
      --accent: #2563eb;
      --muted: #6b7280;
      --card-bg: #ffffff;
      --border: #e5e7eb;
      --radius: 8px;
      --shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      --transition: 0.2s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--text);
      line-height: 1.6;
    }

    #fitlife-container {
      display: flex;
      min-height: 100vh;
    }

    #sidebar {
      width: 240px;
      background: var(--card-bg);
      padding: 24px;
      border-right: 1px solid var(--border);
      position: fixed;
      height: 100vh;
      overflow-y: auto;
    }

    .sidebar-header {
      margin-bottom: 24px;
    }

    .sidebar-header h2 {
      font-size: 1.5rem;
      font-weight: 600;
    }

    .sidebar-header p {
      font-size: 0.9rem;
      color: var(--muted);
    }

    .nav-menu a,
    .nav-menu button {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 12px;
      color: var(--text);
      text-decoration: none;
      font-size: 0.95rem;
      border-radius: var(--radius);
      transition: var(--transition);
    }

    .nav-menu a svg,
    .nav-menu button svg {
      width: 20px;
      height: 20px;
      stroke: var(--muted);
    }

    .nav-menu a:hover,
    .nav-menu button:hover {
      background: var(--bg);
      color: var(--accent);
    }

    .nav-menu a:hover svg,
    .nav-menu button:hover svg {
      stroke: var(--accent);
    }

    .nav-menu a.active {
      background: var(--accent);
      color: #fff;
    }

    .nav-menu a.active svg {
      stroke: #fff;
    }

    .nav-menu button {
      background: none;
      border: none;
      cursor: pointer;
      width: 100%;
      text-align: left;
    }

    main {
      margin-left: 240px;
      padding: 24px;
      flex: 1;
    }

    #mobile-toggle {
      display: none;
      position: fixed;
      top: 16px;
      left: 16px;
      background: var(--accent);
      color: #fff;
      border: none;
      padding: 8px;
      border-radius: var(--radius);
      cursor: pointer;
    }

    #mobile-toggle svg {
      width: 20px;
      height: 20px;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }

    .header-left h1 {
      font-size: 1.75rem;
      font-weight: 600;
    }

    .header-left p.muted {
      font-size: 0.9rem;
      color: var(--muted);
    }

    .header-info {
      text-align: right;
      font-size: 0.9rem;
      color: var(--muted);
    }

    h3 {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 16px;
    }

    h4 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .biography-card {
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      margin-bottom: 16px;
    }

    .form-logging {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      align-items: flex-end;
    }

    .form-group {
      flex: 1;
      min-width: 200px;
    }

    .form-group label {
      display: block;
      font-size: 0.9rem;
      margin-bottom: 4px;
      color: var(--muted);
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 8px;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      font-size: 0.95rem;
      transition: var(--transition);
    }

    .form-group input:focus,
    .form-group select:focus {
      outline: none;
      border-color: var(--accent);
      box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
    }

    .calculate-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--accent);
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: var(--radius);
      font-size: 0.95rem;
      cursor: pointer;
      transition: var(--transition);
    }

    .calculate-btn svg {
      width: 20px;
      height: 20px;
      stroke: #fff;
    }

    .calculate-btn:hover {
      background: #1d4ed8;
    }

    .kpi-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 16px;
    }

    .kpi-card {
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      text-align: center;
      transition: var(--transition);
    }

    .kpi-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }

    .kpi-card p {
      font-size: 1.25rem;
      font-weight: 500;
      margin-top: 8px;
    }

    .status-text {
      font-size: 0.9rem;
      color: var(--muted);
    }

    @media (max-width: 768px) {
      #sidebar {
        position: fixed;
        transform: translateX(-100%);
        transition: var(--transition);
      }

      #sidebar.active {
        transform: translateX(0);
      }

      main {
        margin-left: 0;
      }

      #mobile-toggle {
        display: block;
      }

      header {
        flex-direction: column;
        align-items: flex-start;
      }

      .header-info {
        text-align: left;
        margin-top: 12px;
      }
    }

    @media (max-width: 480px) {
      .form-logging {
        flex-direction: column;
        align-items: stretch;
      }

      .form-group {
        min-width: 100%;
      }

      .kpi-container {
        grid-template-columns: 1fr;
      }
    }
  </style>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const mobileToggle = document.getElementById('mobile-toggle');
      const sidebar = document.getElementById('sidebar');

      mobileToggle.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('active');
        mobileToggle.setAttribute('aria-expanded', isOpen);
      });

      document.addEventListener('click', e => {
        if (sidebar.classList.contains('active') && !sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
          sidebar.classList.remove('active');
          mobileToggle.setAttribute('aria-expanded', 'false');
        }
      });

      document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
          sidebar.classList.remove('active');
          mobileToggle.setAttribute('aria-expanded', 'false');
        }
      });
    });
  </script>
@endsection