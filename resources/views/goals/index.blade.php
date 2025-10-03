@extends('layouts.app')

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Goals">  
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
            <div class="progress" style="width: {{ min($goal->current_value / $goal->target_value * 100, 100) }}%;"></div>
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

<!-- Styles Optimized -->
<style>
  :root {
    --bg: #f8f9fa; --text: #1a1a1a; --accent: #2563eb; --muted: #6b7280;
    --card-bg: #fff; --border: #e5e7eb; --radius: 8px; --shadow: 0 2px 10px rgba(0,0,0,0.05);
    --transition: 0.2s ease;
  }

  /* Reset */
  * { margin:0; padding:0; box-sizing:border-box; }
  body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); line-height:1.6; }

  /* Layout */
  #fitlife-container { display:flex; min-height:100vh; }
  #sidebar { width:240px; background:var(--card-bg); padding:24px; border-right:1px solid var(--border); position:fixed; height:100vh; overflow-y:auto; }
  main { margin-left:240px; padding:24px; flex:1; }

  /* Header */
  header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
  .header-left h1 { font-size:1.75rem; font-weight:600; }
  .header-left p.muted { font-size:0.9rem; color:var(--muted); }

  /* Create Goal Button */
  .create-btn { display:inline-flex; align-items:center; gap:8px; background:var(--accent); color:#fff; padding:10px 16px; border-radius:var(--radius); text-decoration:none; font-size:0.95rem; transition:var(--transition); margin-bottom:16px; }
  .create-btn svg { width:20px; height:20px; stroke:#fff; }
  .create-btn:hover { background:#1d4ed8; }

  /* Goals Grid & Card */
  .goals-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:16px; }
  .goal-card { background:var(--card-bg); padding:16px; border-radius:var(--radius); border:1px solid var(--border); transition:var(--transition); }
  .goal-card:hover { transform:translateY(-2px); box-shadow:var(--shadow); }
  .goal-card h4 { font-size:1.1rem; font-weight:600; margin-bottom:8px; }
  .goal-card p { font-size:0.9rem; margin-bottom:4px; }
  .goal-card p em { color:var(--muted); }

  /* Progress Bar */
  .progress-bar { height:8px; background:var(--border); border-radius:var(--radius); overflow:hidden; margin:12px 0; }
  .progress { height:100%; background:var(--accent); transition:var(--transition); }

  /* Log Button */
  .log-btn { display:inline-flex; align-items:center; gap:8px; background:var(--accent); color:#fff; padding:10px 16px; border-radius:var(--radius); text-decoration:none; font-size:0.95rem; transition:var(--transition); }
  .log-btn:hover { background:#1d4ed8; }

  /* No Data */
  .no-data { padding:16px; text-align:center; color:var(--muted); font-size:0.9rem; }

  /* Mobile Toggle */
  #mobile-toggle { display:none; position:fixed; top:16px; left:16px; background:var(--accent); color:#fff; border:none; padding:8px; border-radius:var(--radius); cursor:pointer; }
  #mobile-toggle svg { width:20px; height:20px; }

  /* Media Queries */
  @media(max-width:768px){ #sidebar{transform:translateX(-100%);transition:var(--transition);} #sidebar.active{transform:translateX(0);} main{margin-left:0;} #mobile-toggle{display:block;} header{flex-direction:column;align-items:flex-start;} }
  @media(max-width:480px){ .goals-grid{grid-template-columns:1fr;} }
</style>

<!-- JS Sidebar Toggle -->
<script>
  document.addEventListener("DOMContentLoaded", function(){
    const toggle=document.getElementById('mobile-toggle'), sidebar=document.getElementById('sidebar');

    // Toggle Sidebar
    toggle.addEventListener('click',()=>{ const open=sidebar.classList.toggle('active'); toggle.setAttribute('aria-expanded',open); });

    // Click outside closes sidebar
    document.addEventListener('click',e=>{ if(sidebar.classList.contains('active')&&!sidebar.contains(e.target)&&!toggle.contains(e.target)){ sidebar.classList.remove('active'); toggle.setAttribute('aria-expanded','false'); } });

    // Escape closes sidebar
    document.addEventListener('keydown',e=>{ if(e.key==='Escape'){ sidebar.classList.remove('active'); toggle.setAttribute('aria-expanded','false'); } });
  });
</script>
@endsection
