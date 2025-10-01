@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Goals">  
    <!-- Main Content -->
    <main>
      <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

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
                <div class="progress" style="width: {{ min($goal->current_value / $goal->target_value * 100, 100) }}%;">
                </div>
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

    .create-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--accent);
      color: #fff;
      padding: 10px 16px;
      border-radius: var(--radius);
      text-decoration: none;
      font-size: 0.95rem;
      transition: var(--transition);
      margin-bottom: 16px;
    }

    .create-btn svg {
      width: 20px;
      height: 20px;
      stroke: #fff;
    }

    .create-btn:hover {
      background: #1d4ed8;
    }

    .goals-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 16px;
    }

    .goal-card {
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      transition: var(--transition);
    }

    .goal-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }

    .goal-card h4 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .goal-card p {
      font-size: 0.9rem;
      margin-bottom: 4px;
    }

    .goal-card p em {
      color: var(--muted);
    }

    .progress-bar {
      height: 8px;
      background: var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      margin: 12px 0;
    }

    .progress {
      height: 100%;
      background: var(--accent);
      transition: var(--transition);
    }

    .log-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--accent);
      color: #fff;
      padding: 10px 16px;
      border-radius: var(--radius);
      text-decoration: none;
      font-size: 0.95rem;
      transition: var(--transition);
    }

    .log-btn:hover {
      background: #1d4ed8;
    }

    .no-data {
      padding: 16px;
      text-align: center;
      color: var(--muted);
      font-size: 0.9rem;
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
      .goals-grid {
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