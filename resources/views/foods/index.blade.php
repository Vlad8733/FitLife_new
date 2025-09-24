@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Meal Tracker">
    <aside id="sidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <h2>FitLife</h2>
        <p>Power Your Performance</p>
      </div>
      <nav class="nav-menu" aria-label="Main menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M3 13h8V3H3zM13 21h8V11h-8zM13 3v8" />
          </svg>
          <span>Home</span>
        </a>
        <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'active' : '' }}" {{ request()->routeIs('posts.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path
              d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2M17 8l4 4-4 4" />
          </svg>
          <span>Community Posts</span>
        </a>
        <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'active' : '' }}" {{ request()->routeIs('foods.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M4 21c4-4 6-11 6-17M20 7a4 4 0 11-8 0" />
          </svg>
          <span>Meal Tracker</span>
        </a>
        <a href="{{ route('sleep.index') }}" class="{{ request()->routeIs('sleep.*') ? 'active' : '' }}" {{ request()->routeIs('sleep.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
          </svg>
          <span>Sleep Tracker</span>
        </a>
        <a href="{{ route('water.index') }}" class="{{ request()->routeIs('water.*') ? 'active' : '' }}" {{ request()->routeIs('water.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z" />
          </svg>
          <span>Water Tracker</span>
        </a>
        <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'active' : '' }}" {{ request()->routeIs('progress.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M21 3v18H3V3h18zM7 14l3-3 2 2 5-5" />
          </svg>
          <span>Progress Photos</span>
        </a>
        <a href="{{ route('goals.index') }}" class="{{ request()->routeIs('goals.*') ? 'active' : '' }}" {{ request()->routeIs('goals.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4l3 3" />
          </svg>
          <span>Goals</span>
        </a>
        <a href="{{ route('calories.index') }}" class="{{ request()->routeIs('calories.*') ? 'active' : '' }}" {{ request()->routeIs('calories.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 2v20M5 12h14" />
          </svg>
          <span>Calorie Calculator</span>
        </a>
        <a href="{{ route('biography.edit') }}" class="{{ request()->routeIs('biography.*') ? 'active' : '' }}" {{ request()->routeIs('biography.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="8" r="4" />
            <path d="M6 20v-1a6 6 0 0112 0v1" />
          </svg>
          <span>Biography</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}" {{ request()->routeIs('profile.edit') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
          </svg>
          <span>Profile</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
          @csrf
          <button type="submit" aria-label="Logout">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" />
            </svg>
            <span>Logout</span>
          </button>
        </form>
      </nav>
    </aside>

    <main>
      <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">Menu</button>
      <header>
        <div class="header-left">
          <h1>Meal Tracker</h1>
          <p class="muted">Log and analyze your daily nutrition</p>
        </div>
      </header>

      <!-- Notification -->
      <div id="notification" class="notification" role="alert"></div>

      <!-- Meal Form -->
      <section aria-labelledby="meal-form-heading">
        <h3 id="meal-form-heading">Log Your Meals</h3>
        <form action="{{ route('foods.calculate') }}" method="POST" class="meal-grid-form" id="meal-form">
          @csrf
          @php $meals = ['Breakfast', 'Lunch', 'Dinner', 'Snack']; @endphp
          <div class="meals-grid">
            @foreach($meals as $meal)
              <div class="meal-block">
                <div class="meal-card" data-meal-block="{{ $meal }}">
                  <h4>{{ $meal }}</h4>
                  <div class="meal-items" data-meal="{{ $meal }}">
                    <div class="meal-item">
                      <select class="food-select" name="meals[{{ $meal }}][0][food]"
                        aria-label="Select food for {{ $meal }}">
                        <option value="">Select Food</option>
                        @foreach($foods as $food => $cal)
                          <option value="{{ $food }}" data-calories="{{ $cal }}">{{ $food }} ({{ $cal }} kcal)</option>
                        @endforeach
                      </select>
                      <input type="number" class="quantity-input" name="meals[{{ $meal }}][0][quantity]" placeholder="g/ml"
                        style="display:none;" min="0" step="1" aria-label="Quantity for {{ $meal }} food">
                      <div class="calorie-preview" data-calories="0">0 kcal</div>
                      <button type="button" class="remove-food-btn" style="display:none;" aria-label="Remove food item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                          <path d="M6 18L18 6M6 6l12 12" />
                        </svg>
                      </button>
                    </div>
                  </div>
                  <button type="button" class="add-food-btn" data-meal="{{ $meal }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                      <path d="M12 5v14M5 12h14" />
                    </svg>
                    Add Item
                  </button>
                  <div class="total-calories" data-total-calories="0">Total: 0 kcal</div>
                  @error("meals.{$meal}.*")
                    <div class="error-message">{{ $message }}</div>
                  @enderror
                </div>
                @if($meal === 'Breakfast')
                  <div class="calculate-container">
                    <button type="submit" class="calculate-btn" id="calculate-btn">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M12 2v20M5 12h14" />
                      </svg>
                      Calculate Calories
                    </button>
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        </form>
      </section>

      <!-- Meal History -->
      <section id="history-section" aria-labelledby="history-heading">
        <h3 id="history-heading">Meal History</h3>
        @include('profile.partials.meal_table', ['mealLogs' => $logs])
      </section>

      <!-- Result Widget -->
      @if(session('result'))
        <section aria-labelledby="result-heading">
          <h3 id="result-heading">Your Meal Summary</h3>
          <div class="result-card">
            <div class="result-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M4 21c4-4 6-11 6-17" />
                <path d="M20 7a4 4 0 11-8 0" />
              </svg>
            </div>
            <div class="result-body">
              <h4>Total Calories</h4>
              <div class="value">{{ session('result')['calories'] }} kcal</div>
              <div class="muted">{{ session('result')['comment'] }}</div>
            </div>
          </div>
        </section>
      @endif
    </main>
  </div>

  <style>
    :root {
      --bg: #f8f9fa;
      --text: #1a1a1a;
      --accent: #2563eb;
      --muted: #6b7280;
      --card-bg: #fff;
      --border: #e5e7eb;
      --radius: 8px;
      --shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      --transition: 0.2s ease;
      --sidebar-width: 240px;
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
      width: 100%;
    }

    #sidebar {
      width: var(--sidebar-width);
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
      color: var(--muted);
      font-size: 0.9rem;
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
      margin-left: var(--sidebar-width);
      padding: 24px;
      flex: 1;
      width: calc(100% - var(--sidebar-width));
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
      width: 24px;
      height: 24px;
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

    .header-left .muted {
      color: var(--muted);
      font-size: 0.9rem;
    }

    .header-info {
      text-align: right;
      color: var(--muted);
      font-size: 0.9rem;
    }

    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 12px 24px;
      border-radius: var(--radius);
      background: var(--card-bg);
      color: var(--text);
      box-shadow: var(--shadow);
      opacity: 0;
      transition: opacity 0.3s ease, transform 0.3s ease;
      transform: translateY(-20px);
      z-index: 1000;
    }

    .notification.show {
      opacity: 1;
      transform: translateY(0);
    }

    .notification.success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .notification.error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    section {
      margin-bottom: 32px;
    }

    h3 {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 16px;
    }

    .meal-grid-form {
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
    }

    .meals-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 16px;
    }

    .meal-block {
      display: flex;
      flex-direction: column;
    }

    .meal-card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 12px;
      box-shadow: var(--shadow);
    }

    .meal-card h4 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .meal-items {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .meal-item {
      display: grid;
      grid-template-columns: 1fr auto auto;
      gap: 8px;
      align-items: center;
    }

    .food-select,
    .quantity-input {
      padding: 8px;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      font-size: 0.95rem;
    }

    .quantity-input {
      width: 80px;
    }

    .calorie-preview {
      font-size: 0.9rem;
      color: var(--muted);
    }

    .remove-food-btn {
      background: none;
      border: none;
      cursor: pointer;
      padding: 4px;
    }

    .remove-food-btn svg {
      width: 20px;
      height: 20px;
      stroke: var(--muted);
    }

    .add-food-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      background: none;
      border: none;
      color: var(--accent);
      font-size: 0.95rem;
      cursor: pointer;
      margin: 8px 0;
    }

    .add-food-btn svg {
      width: 20px;
      height: 20px;
      stroke: var(--accent);
    }

    .total-calories {
      font-weight: 600;
      margin-top: 8px;
    }

    .error-message {
      color: #dc3545;
      font-size: 0.85rem;
      margin-top: 4px;
    }

    .calculate-container {
      text-align: center;
      margin-top: 16px;
    }

    .calculate-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--accent);
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: var(--radius);
      cursor: pointer;
      font-size: 0.95rem;
    }

    .calculate-btn:disabled {
      background: #6c757d;
      cursor: not-allowed;
    }

    .calculate-btn svg {
      width: 20px;
      height: 20px;
    }

    .history-table {
      width: 100%;
      border-collapse: collapse;
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
    }

    .history-table th,
    .history-table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid var(--border);
    }

    .history-table th {
      background: var(--bg);
      font-weight: 600;
    }

    .history-table .no-data {
      text-align: center;
      color: var(--muted);
      padding: 24px;
    }

    .pagination {
      display: flex;
      gap: 8px;
      justify-content: center;
      margin-top: 16px;
    }

    .pagination a {
      padding: 8px 12px;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      text-decoration: none;
      color: var(--text);
      font-size: 0.9rem;
    }

    .pagination a.current {
      background: var(--accent);
      color: #fff;
      border-color: var(--accent);
    }

    .pagination a.disabled {
      color: var(--muted);
      cursor: not-allowed;
    }

    .result-card {
      display: flex;
      align-items: center;
      gap: 16px;
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
    }

    .result-icon svg {
      width: 40px;
      height: 40px;
      stroke: var(--accent);
    }

    .result-body h4 {
      font-size: 1.1rem;
      font-weight: 600;
    }

    .result-body .value {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--accent);
    }

    .result-body .muted {
      color: var(--muted);
      font-size: 0.9rem;
    }

    @media (max-width: 768px) {
      #sidebar {
        position: fixed;
        transform: translateX(-100%);
        transition: var(--transition);
        width: var(--sidebar-width);
      }

      #sidebar.active {
        transform: translateX(0);
      }

      main {
        margin-left: 0;
        width: 100%;
      }

      #mobile-toggle {
        display: block;
      }

      .meals-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Mobile sidebar toggle
      const mobileToggle = document.getElementById('mobile-toggle'),
        body = document.body,
        sidebar = document.getElementById('sidebar');
      mobileToggle.addEventListener('click', () => {
        const opened = sidebar.classList.toggle('active');
        mobileToggle.setAttribute('aria-expanded', opened ? 'true' : 'false');
      });
      document.addEventListener('click', e => {
        if (!sidebar.classList.contains('active') || sidebar.contains(e.target) || mobileToggle.contains(e.target)) return;
        sidebar.classList.remove('active');
        mobileToggle.setAttribute('aria-expanded', 'false');
      });
      document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && sidebar.classList.contains('active')) {
          sidebar.classList.remove('active');
          mobileToggle.setAttribute('aria-expanded', 'false');
        }
      });

      /* ===== Food Selection and Calorie Preview ===== */
      const foodCalories = @json($foods);
      function updateCaloriePreview(item) {
        const select = item.querySelector('.food-select');
        const quantityInput = item.querySelector('.quantity-input');
        const preview = item.querySelector('.calorie-preview');
        const food = select.value;
        const quantity = parseFloat(quantityInput.value) || 0;
        const calories = food ? Math.round((foodCalories[food] || 0) * quantity / 100) : 0;
        preview.textContent = `${calories} kcal`;
        preview.dataset.calories = calories;

        const mealCard = item.closest('.meal-card');
        const totalPreview = mealCard.querySelector('.total-calories');
        const items = mealCard.querySelectorAll('.meal-item');
        let totalCalories = 0;
        items.forEach(i => {
          totalCalories += parseInt(i.querySelector('.calorie-preview').dataset.calories || 0);
        });
        totalPreview.textContent = `Total: ${totalCalories} kcal`;
        totalPreview.dataset.totalCalories = totalCalories;
      }

      document.querySelectorAll('.food-select').forEach(select => {
        select.addEventListener('change', e => {
          const item = e.target.closest('.meal-item');
          const input = item.querySelector('.quantity-input');
          input.style.display = e.target.value ? 'block' : 'none';
          item.querySelector('.remove-food-btn').style.display = item.parentElement.children.length > 1 ? 'block' : 'none';
          updateCaloriePreview(item);
        });
      });

      document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', e => {
          updateCaloriePreview(e.target.closest('.meal-item'));
        });
      });

      /* ===== Add Food Item ===== */
      document.querySelectorAll('.add-food-btn').forEach(btn => {
        btn.addEventListener('click', function () {
          const meal = this.dataset.meal;
          const container = this.previousElementSibling;
          const count = container.querySelectorAll('.meal-item').length;
          const div = document.createElement('div');
          div.classList.add('meal-item');
          let selectHTML = `<select class="food-select" name="meals[${meal}][${count}][food]" aria-label="Select food for ${meal}">
              <option value="">Select Food</option>`;
          @foreach($foods as $food => $cal)
            selectHTML += `<option value="{{ $food }}" data-calories="{{ $cal }}">{{ $food }} ({{ $cal }} kcal)</option>`;
          @endforeach
          selectHTML += `</select>`;
          div.innerHTML = selectHTML + `
              <input type="number" class="quantity-input" name="meals[${meal}][${count}][quantity]" placeholder="g/ml" style="display:none;" min="0" step="1" aria-label="Quantity for ${meal} food">
              <div class="calorie-preview" data-calories="0">0 kcal</div>
              <button type="button" class="remove-food-btn" aria-label="Remove food item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                  <path d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>`;
          container.appendChild(div);
          div.querySelector('.food-select').addEventListener('change', e => {
            const item = e.target.closest('.meal-item');
            const input = item.querySelector('.quantity-input');
            input.style.display = e.target.value ? 'block' : 'none';
            item.querySelector('.remove-food-btn').style.display = 'block';
            updateCaloriePreview(item);
          });
          div.querySelector('.quantity-input').addEventListener('input', e => {
            updateCaloriePreview(e.target.closest('.meal-item'));
          });
          div.querySelector('.remove-food-btn').addEventListener('click', () => {
            div.remove();
            updateCaloriePreview(container.querySelector('.meal-item'));
          });
        });
      });

      /* ===== Remove Food Item ===== */
      document.querySelectorAll('.remove-food-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const item = btn.closest('.meal-item');
          const container = item.parentElement;
          item.remove();
          updateCaloriePreview(container.querySelector('.meal-item'));
        });
      });

      /* ===== Form Submission with Validation and Optimistic UI Update ===== */
      const mealForm = document.getElementById('meal-form');
      const calculateBtn = document.getElementById('calculate-btn');
      mealForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        let valid = true;
        document.querySelectorAll('.error-message').forEach(e => e.remove());
        const formData = new FormData(mealForm);
        const mealsData = {};
        formData.forEach((value, key) => {
          const matches = key.match(/meals\[(\w+)\]\[(\d+)\]\[(\w+)\]/);
          if (matches) {
            const [_, meal, index, field] = matches;
            if (!mealsData[meal]) mealsData[meal] = [];
            if (!mealsData[meal][index]) mealsData[meal][index] = {};
            mealsData[meal][index][field] = value;
          }
        });

        // Validate inputs
        Object.keys(mealsData).forEach(meal => {
          mealsData[meal].forEach((item, index) => {
            if (item.food && (!item.quantity || parseFloat(item.quantity) <= 0)) {
              valid = false;
              const mealCard = document.querySelector(`.meal-card[data-meal-block="${meal}"]`);
              const mealItem = mealCard.querySelectorAll('.meal-item')[index];
              const error = document.createElement('div');
              error.className = 'error-message';
              error.textContent = 'Quantity must be a positive number';
              mealItem.appendChild(error);
            }
          });
        });

        if (!valid) {
          showNotification('Please correct the errors in the form', 'error');
          return;
        }

        // Optimistic UI update: Add meals to history table
        const historyTbody = document.querySelector('.history-table tbody');
        const noDataRow = historyTbody.querySelector('.no-data');
        if (noDataRow) noDataRow.remove();
        Object.keys(mealsData).forEach(meal => {
          mealsData[meal].forEach(item => {
            if (item.food && item.quantity) {
              const calories = Math.round((foodCalories[item.food] || 0) * parseFloat(item.quantity) / 100);
              const row = document.createElement('tr');
              row.innerHTML = `
                  <td>${new Date().toLocaleString('en-US', { month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</td>
                  <td>${meal}</td>
                  <td>${item.food}</td>
                  <td>${item.quantity} g/ml</td>
                  <td>${calories} kcal</td>
                `;
              row.classList.add('optimistic');
              historyTbody.insertBefore(row, historyTbody.firstChild);
            }
          });
        });

        calculateBtn.disabled = true;
        calculateBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2v20M5 12h14" /></svg> Calculating...';

        try {
          const response = await axios.post(mealForm.action, formData, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
          });
          if (response.data.success) {
            showNotification('Meals logged successfully!', 'success');
            const historySection = document.getElementById('history-section');
            historySection.innerHTML = response.data.historyHtml;
            mealForm.reset();
            document.querySelectorAll('.quantity-input').forEach(input => input.style.display = 'none');
            document.querySelectorAll('.remove-food-btn').forEach(btn => btn.style.display = 'none');
            document.querySelectorAll('.calorie-preview').forEach(preview => {
              preview.textContent = '0 kcal';
              preview.dataset.calories = '0';
            });
            document.querySelectorAll('.total-calories').forEach(total => {
              total.textContent = 'Total: 0 kcal';
              total.dataset.totalCalories = '0';
            });
            attachPaginationListeners();
          } else {
            showNotification(response.data.message || 'Error logging meals', 'error');
            document.querySelectorAll('.optimistic').forEach(row => row.remove());
          }
        } catch (error) {
          showNotification(error.response?.data?.message || 'Network error, please try again', 'error');
          document.querySelectorAll('.optimistic').forEach(row => row.remove());
        } finally {
          calculateBtn.disabled = false;
          calculateBtn.innerHTML = `
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M12 2v20M5 12h14" />
              </svg>
              Calculate Calories`;
        }
      });

      /* ===== Filter Form (if exists) ===== */
      const filterForm = document.getElementById('filter-form');
      if (filterForm) {
        filterForm.addEventListener('submit', async (e) => {
          e.preventDefault();
          const formData = new FormData(filterForm);
          const url = new URL('{{ route('foods.index') }}');
          formData.forEach((value, key) => {
            if (value) url.searchParams.append(key, value);
          });

          try {
            const response = await axios.get(url, {
              headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const parser = new DOMParser();
            const doc = parser.parseFromString(response.data, 'text/html');
            const newHistorySection = doc.getElementById('history-section');
            if (newHistorySection) {
              document.getElementById('history-section').innerHTML = newHistorySection.innerHTML;
              attachPaginationListeners();
            }
          } catch (error) {
            showNotification('Error filtering meals', 'error');
          }
        });
      }

      /* ===== Notification Function ===== */
      function showNotification(message, type) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = `notification ${type} show`;
        setTimeout(() => {
          notification.className = 'notification';
        }, 3000);
      }

      /* ===== AJAX Pagination ===== */
      function attachPaginationListeners() {
        document.querySelectorAll('.pagination a').forEach(link => {
          link.addEventListener('click', async function (e) {
            e.preventDefault();
            if (this.classList.contains('disabled')) return;

            const url = this.getAttribute('href');
            const historySection = document.getElementById('history-section');
            const scrollPosition = window.scrollY;

            try {
              const response = await axios.get(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
              });
              const parser = new DOMParser();
              const doc = parser.parseFromString(response.data, 'text/html');
              const newHistorySection = doc.getElementById('history-section');
              if (newHistorySection) {
                historySection.innerHTML = newHistorySection.innerHTML;
                window.scrollTo(0, scrollPosition);
                attachPaginationListeners();
              }
            } catch (error) {
              showNotification('Error loading page', 'error');
            }
          });
        });
      }

      attachPaginationListeners();
    });
  </script>
@endsection