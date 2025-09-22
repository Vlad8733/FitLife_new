@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Meal Tracker">
    <aside id="sidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <h2>FitLife</h2>
        <p>Power Your Performance</p>
      </div>
      <nav class="nav-menu" aria-label="Main menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }} style="--i: 1;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 13h8V3H3z" />
            <path d="M13 21h8V11h-8z" />
            <path d="M13 3v8" />
          </svg>
          <span>Home</span>
        </a>
        <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'active' : '' }}" {{ request()->routeIs('posts.*') ? 'aria-current=page' : '' }} style="--i: 2;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
            <path d="M17 8l4 4-4 4" />
          </svg>
          <span>Community Posts</span>
        </a>
        <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'active' : '' }}" {{ request()->routeIs('foods.*') ? 'aria-current=page' : '' }} style="--i: 3;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M4 21c4-4 6-11 6-17" />
            <path d="M20 7a4 4 0 11-8 0" />
          </svg>
          <span>Meal Tracker</span>
        </a>
        <a href="{{ route('sleep.index') }}" class="{{ request()->routeIs('sleep.*') ? 'active' : '' }}" {{ request()->routeIs('sleep.*') ? 'aria-current=page' : '' }} style="--i: 4;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
          </svg>
          <span>Sleep Tracker</span>
        </a>
        <a href="{{ route('water.index') }}" class="{{ request()->routeIs('water.*') ? 'active' : '' }}" {{ request()->routeIs('water.*') ? 'aria-current=page' : '' }} style="--i: 5;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z" />
          </svg>
          <span>Water Tracker</span>
        </a>
        <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'active' : '' }}" {{ request()->routeIs('progress.*') ? 'aria-current=page' : '' }} style="--i: 6;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M21 3v18H3V3h18z" />
            <path d="M7 14l3-3 2 2 5-5" />
          </svg>
          <span>Progress Photos</span>
        </a>
        <a href="{{ route('goals.index') }}" class="{{ request()->routeIs('goals.*') ? 'active' : '' }}" {{ request()->routeIs('goals.*') ? 'aria-current=page' : '' }} style="--i: 7;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4l3 3" />
          </svg>
          <span>Goals</span>
        </a>
        <a href="{{ route('calories.index') }}" class="{{ request()->routeIs('calories.*') ? 'active' : '' }}" {{ request()->routeIs('calories.*') ? 'aria-current=page' : '' }} style="--i: 8;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M12 2v20" />
            <path d="M5 12h14" />
          </svg>
          <span>Calorie Calculator</span>
        </a>
        <a href="{{ route('biography.edit') }}" class="{{ request()->routeIs('biography.*') ? 'active' : '' }}" {{ request()->routeIs('biography.*') ? 'aria-current=page' : '' }} style="--i: 9;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <circle cx="12" cy="8" r="4" />
            <path d="M6 20v-1a6 6 0 0112 0v1" />
          </svg>
          <span>Biography</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}" {{ request()->routeIs('profile.edit') ? 'aria-current=page' : '' }} style="--i: 10;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
          </svg>
          <span>Profile</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
          @csrf
          <button type="submit" aria-label="Logout">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
              <path d="M16 17l5-5-5-5" />
              <path d="M21 12H9" />
            </svg>
            Logout
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
        <div class="header-info">
          <div>{{ now()->format('l, F d, Y') }}</div>
          <div>{{ now()->format('H:i') }}</div>
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
                      <select class="food-select" name="meals[{{ $meal }}][0][food]" aria-label="Select food for {{ $meal }}">
                        <option value="">Select Food</option>
                        @foreach($foods as $food => $cal)
                          <option value="{{ $food }}" data-calories="{{ $cal }}">{{ $food }} ({{ $cal }} kcal)</option>
                        @endforeach
                      </select>
                      <input type="number" class="quantity-input" name="meals[{{ $meal }}][0][quantity]" placeholder="g/ml" style="display:none;" min="0" step="1" aria-label="Quantity for {{ $meal }} food">
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

      <!-- Filter Form -->
      <section aria-labelledby="filter-heading">
        <h3 id="filter-heading">Filter Meal History</h3>
        <form class="filter-form" id="filter-form">
          <select name="meal_type" aria-label="Filter by meal type">
            <option value="">All Meals</option>
            @foreach($meals as $meal)
              <option value="{{ $meal }}">{{ $meal }}</option>
            @endforeach
          </select>
          <input type="date" name="date" aria-label="Filter by date">
          <button type="submit" class="calculate-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Filter
          </button>
        </form>
      </section>

      <!-- Meal History -->
      <section id="history-section" aria-labelledby="history-heading">
        <h3 id="history-heading">Meal History</h3>
        <table class="history-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Meal</th>
              <th>Food</th>
              <th>Quantity</th>
              <th>Calories</th>
            </tr>
          </thead>
          <tbody>
            @if($logs->isEmpty())
              <tr>
                <td colspan="5" class="no-data">No meal history yet. Start logging your meals!</td>
              </tr>
            @else
              @foreach($logs as $log)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y H:i') }}</td>
                  <td>{{ $log->meal }}</td>
                  <td>{{ $log->food }}</td>
                  <td>{{ $log->quantity }} g/ml</td>
                  <td>{{ $log->calories }} kcal</td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        @if(!$logs->isEmpty())
          <div class="pagination" data-current-page="{{ $logs->currentPage() }}" data-last-page="{{ $logs->lastPage() }}">
            <a href="{{ route('foods.index', ['page' => max(1, $logs->currentPage() - 1)]) }}" class="{{ $logs->onFirstPage() ? 'disabled' : '' }}">Previous</a>
            @for($i = 1; $i <= $logs->lastPage(); $i++)
              <a href="{{ route('foods.index', ['page' => $i]) }}" class="{{ $logs->currentPage() == $i ? 'current' : '' }}">{{ $i }}</a>
            @endfor
            <a href="{{ route('foods.index', ['page' => min($logs->lastPage(), $logs->currentPage() + 1)]) }}" class="{{ $logs->onLastPage() ? 'disabled' : '' }}">Next</a>
          </div>
        @endif
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

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Mobile sidebar toggle
      const mobileToggle = document.getElementById('mobile-toggle'),
            body = document.body,
            sidebar = document.getElementById('sidebar');
      mobileToggle.addEventListener('click', () => {
        const opened = body.classList.toggle('sidebar-open');
        mobileToggle.setAttribute('aria-expanded', opened ? 'true' : 'false');
      });
      document.addEventListener('click', e => {
        if (!body.classList.contains('sidebar-open') || sidebar.contains(e.target) || mobileToggle.contains(e.target)) return;
        body.classList.remove('sidebar-open');
        mobileToggle.setAttribute('aria-expanded', 'false');
      });
      document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && body.classList.contains('sidebar-open')) {
          body.classList.remove('sidebar-open');
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
          const item = e.target.closest('.meal-item');
          updateCaloriePreview(item);
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

      /* ===== Form Submission with Validation ===== */
      const mealForm = document.getElementById('meal-form');
      const calculateBtn = document.getElementById('calculate-btn');
      mealForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        let valid = true;
        document.querySelectorAll('.error-message').forEach(e => e.remove());
        document.querySelectorAll('.quantity-input').forEach(input => {
          if (input.style.display !== 'none' && (!input.value || parseFloat(input.value) <= 0)) {
            valid = false;
            const error = document.createElement('div');
            error.className = 'error-message';
            error.textContent = 'Quantity must be a positive number';
            input.parentElement.appendChild(error);
          }
        });

        if (!valid) {
          showNotification('Please correct the errors in the form', 'error');
          return;
        }

        calculateBtn.disabled = true;
        calculateBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2v20M5 12h14" /></svg> Calculating...';

        try {
          const response = await fetch(mealForm.action, {
            method: 'POST',
            body: new FormData(mealForm),
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          });
          const data = await response.json();
          if (response.ok) {
            showNotification('Meals logged successfully!', 'success');
            const historySection = document.getElementById('history-section');
            historySection.innerHTML = data.historyHtml;
            // Re-attach pagination event listeners
            attachPaginationListeners();
          } else {
            showNotification(data.message || 'Error logging meals', 'error');
          }
        } catch (error) {
          showNotification('Network error, please try again', 'error');
        } finally {
          calculateBtn.disabled = false;
          calculateBtn.innerHTML = `
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path d="M12 2v20M5 12h14" />
            </svg>
            Calculate Calories`;
        }
      });

      /* ===== Filter Form ===== */
      const filterForm = document.getElementById('filter-form');
      filterForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(filterForm);
        const url = new URL('{{ route('foods.index') }}');
        formData.forEach((value, key) => {
          if (value) url.searchParams.append(key, value);
        });

        try {
          const response = await fetch(url, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          });
          const html = await response.text();
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const newHistorySection = doc.getElementById('history-section');
          if (newHistorySection) {
            document.getElementById('history-section').innerHTML = newHistorySection.innerHTML;
            attachPaginationListeners();
          }
        } catch (error) {
          showNotification('Error filtering meals', 'error');
        }
      });

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
              const response = await fetch(url, {
                headers: {
                  'X-Requested-With': 'XMLHttpRequest'
                }
              });
              const html = await response.text();
              const parser = new DOMParser();
              const doc = parser.parseFromString(html, 'text/html');
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