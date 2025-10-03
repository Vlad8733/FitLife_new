@extends('layouts.app')

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Log Progress">
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
        <h1><span>FitLife</span> Log Progress</h1>
        <p class="muted">Update your progress for {{ ucfirst($goal->type) }} goal</p>
      </div>
    </header>

    <!-- Log Form -->
    <section aria-labelledby="log-form-heading">
      <h3 id="log-form-heading">Log Progress for {{ ucfirst($goal->type) }}</h3>
      <div class="log-card">
        <form action="{{ route('goals.storeLog', $goal) }}" method="POST" class="log-form">
          @csrf
          <div class="form-group">
            <label for="value">Today's Value</label>
            <input type="number" id="value" name="value" step="0.01" placeholder="Enter today's value" required>
          </div>
          <button type="submit" class="calculate-btn">Submit</button>
        </form>
      </div>
    </section>
  </main>
</div>

<!-- Styles Optimized -->
<style>
  :root {
    --bg:#f8f9fa; --text:#1a1a1a; --accent:#2563eb; --muted:#6b7280;
    --card-bg:#fff; --border:#e5e7eb; --radius:8px; --shadow:0 2px 10px rgba(0,0,0,0.05);
    --transition:0.2s ease;
  }

  /* Reset */
  *{margin:0;padding:0;box-sizing:border-box;}
  body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);line-height:1.6;}

  /* Layout */
  #fitlife-container{display:flex;min-height:100vh;}
  #sidebar{width:240px;background:var(--card-bg);padding:24px;border-right:1px solid var(--border);position:fixed;height:100vh;overflow-y:auto;}
  main{margin-left:240px;padding:24px;flex:1;}

  /* Header */
  header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;}
  .header-left h1{font-size:1.75rem;font-weight:600;}
  .header-left p.muted{font-size:0.9rem;color:var(--muted);}

  /* Log Form */
  .log-card{background:var(--card-bg);padding:16px;border-radius:var(--radius);border:1px solid var(--border);margin-bottom:16px;}
  .log-form{display:flex;flex-wrap:wrap;gap:16px;align-items:flex-end;}
  .form-group{flex:1;min-width:200px;}
  .form-group label{display:block;font-size:0.9rem;margin-bottom:4px;color:var(--muted);}
  .form-group input{width:100%;padding:8px;border:1px solid var(--border);border-radius:var(--radius);font-size:0.95rem;transition:var(--transition);}
  .form-group input:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 2px rgba(37,99,235,0.2);}
  .calculate-btn{background:var(--accent);color:#fff;border:none;padding:10px 16px;border-radius:var(--radius);font-size:0.95rem;cursor:pointer;transition:var(--transition);}
  .calculate-btn:hover{background:#1d4ed8;}

  /* Mobile Toggle */
  #mobile-toggle{display:none;position:fixed;top:16px;left:16px;background:var(--accent);color:#fff;border:none;padding:8px;border-radius:var(--radius);cursor:pointer;}
  #mobile-toggle svg{width:20px;height:20px;}

  /* Media Queries */
  @media(max-width:768px){#sidebar{transform:translateX(-100%);transition:var(--transition);}#sidebar.active{transform:translateX(0);}main{margin-left:0;}#mobile-toggle{display:block;}header{flex-direction:column;align-items:flex-start;}}
  @media(max-width:480px){.log-form{flex-direction:column;align-items:stretch;}.form-group{min-width:100%;}}
</style>

<!-- JS Sidebar Toggle -->
<script>
document.addEventListener("DOMContentLoaded",function(){
  const toggle=document.getElementById('mobile-toggle'), sidebar=document.getElementById('sidebar');

  // Toggle Sidebar
  toggle.addEventListener('click',()=>{const open=sidebar.classList.toggle('active'); toggle.setAttribute('aria-expanded',open);});

  // Click outside closes sidebar
  document.addEventListener('click',e=>{if(sidebar.classList.contains('active')&&!sidebar.contains(e.target)&&!toggle.contains(e.target)){sidebar.classList.remove('active');toggle.setAttribute('aria-expanded','false');}});

  // Escape closes sidebar
  document.addEventListener('keydown',e=>{if(e.key==='Escape'){sidebar.classList.remove('active');toggle.setAttribute('aria-expanded','false');}});
});
</script>
@endsection
