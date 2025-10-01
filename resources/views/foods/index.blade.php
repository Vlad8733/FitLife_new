@extends('layouts.app')

@section('content')
<!-- Main Application Container -->
<div id="fitlife-container" role="application" aria-label="FitLife Meal Tracker">
    <!-- Main Content Area -->
    <main>
        <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">Menu</button>
        <header>
            <div class="header-left">
                <h1>Meal Tracker</h1>
                <p class="muted">Log and analyze your daily nutrition</p>
            </div>
        </header>

        <!-- Notification Area -->
        <div id="notification" class="notification" role="alert"></div>

        <!-- Meal Logging Form -->
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
                                                <path d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="add-food-btn" data-meal="{{ $meal }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                        <path d="M12 5v14M5 12h14"/>
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
                                            <path d="M12 2v20M5 12h14"/>
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

        <!-- Meal History Section -->
        <section id="history-section" aria-labelledby="history-heading">
            <h3 id="history-heading">Meal History</h3>
            @include('profile.partials.meal_table', ['mealLogs' => $logs])
        </section>

        <!-- Meal Summary Result -->
        @if(session('result'))
            <section aria-labelledby="result-heading">
                <h3 id="result-heading">Your Meal Summary</h3>
                <div class="result-card">
                    <div class="result-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M4 21c4-4 6-11 6-17"/>
                            <path d="M20 7a4 4 0 11-8 0"/>
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

<!-- Styles -->
<style>
    :root {
        --bg: #f9fafb;
        --text: #111827;
        --accent: #3b82f6;
        --muted: #6b7280;
        --card-bg: #ffffff;
        --border: #e5e7eb;
        --radius: 12px;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
        --sidebar-width: 260px;
        --primary: #3b82f6;
        --success: #10b981;
        --error: #ef4444;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', system-ui, sans-serif;
        background: var(--bg);
        color: var(--text);
        line-height: 1.6;
        font-size: 16px;
    }

    #fitlife-container {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar Styles */
    #sidebar {
        width: var(--sidebar-width);
        background: var(--card-bg);
        padding: 24px;
        border-right: 1px solid var(--border);
        position: fixed;
        height: 100vh;
        overflow-y: auto;
        transition: var(--transition);
    }

    .sidebar-header {
        margin-bottom: 32px;
        text-align: center;
    }

    .sidebar-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--accent);
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
        padding: 12px 16px;
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
        transition: var(--transition);
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
        color: #ffffff;
    }

    .nav-menu a.active svg {
        stroke: #ffffff;
    }

    .nav-menu button {
        background: none;
        border: none;
        cursor: pointer;
        width: 100%;
        text-align: left;
    }

    /* Main Content Styles */
    main {
        margin-left: var(--sidebar-width);
        padding: 32px;
        flex: 1;
    }

    #mobile-toggle {
        display: none;
        position: fixed;
        top: 16px;
        left: 16px;
        background: var(--accent);
        color: #ffffff;
        border: none;
        padding: 10px;
        border-radius: var(--radius);
        cursor: pointer;
        z-index: 1000;
    }

    header {
        margin-bottom: 32px;
    }

    .header-left h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text);
    }

    .header-left .muted {
        color: var(--muted);
        font-size: 1rem;
    }

    /* Notification Styles */
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
        transform: translateY(-20px);
        transition: var(--transition);
        z-index: 1000;
    }

    .notification.show {
        opacity: 1;
        transform: translateY(0);
    }

    .notification.success {
        background: var(--success);
        color: #ffffff;
        border: none;
    }

    .notification.error {
        background: var(--error);
        color: #ffffff;
        border: none;
    }

    /* Meal Form Styles */
    .meal-grid-form {
        background: var(--card-bg);
        padding: 24px;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
    }

    .meals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .meal-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .meal-card:hover {
        transform: translateY(-4px);
    }

    .meal-card h4 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 12px;
        color: var(--text);
    }

    .meal-items {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .meal-item {
        display: grid;
        grid-template-columns: 1fr 100px auto;
        gap: 12px;
        align-items: center;
    }

    .food-select,
    .quantity-input {
        padding: 10px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .food-select:focus,
    .quantity-input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .quantity-input {
        width: 100px;
    }

    .calorie-preview {
        font-size: 0.9rem;
        color: var(--muted);
        font-weight: 500;
    }

    .remove-food-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 6px;
        transition: var(--transition);
    }

    .remove-food-btn:hover svg {
        stroke: var(--error);
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
        border: 1px solid var(--accent);
        color: var(--accent);
        font-size: 0.95rem;
        padding: 8px 12px;
        border-radius: var(--radius);
        cursor: pointer;
        margin: 12px 0;
        transition: var(--transition);
    }

    .add-food-btn:hover {
        background: var(--accent);
        color: #ffffff;
    }

    .add-food-btn svg {
        width: 20px;
        height: 20px;
        stroke: var(--accent);
    }

    .add-food-btn:hover svg {
        stroke: #ffffff;
    }

    .total-calories {
        font-weight: 600;
        margin-top: 12px;
        color: var(--accent);
    }

    .error-message {
        color: var(--error);
        font-size: 0.85rem;
        margin-top: 6px;
    }

    .calculate-container {
        text-align: center;
        margin-top: 20px;
    }

    .calculate-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--accent);
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: var(--radius);
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .calculate-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    .calculate-btn:disabled {
        background: var(--muted);
        cursor: not-allowed;
        transform: none;
    }

    .calculate-btn svg {
        width: 20px;
        height: 20px;
        stroke: #ffffff;
    }

    /* History Table Styles */
    .history-table {
        width: 100%;
        border-collapse: collapse;
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .history-table th,
    .history-table td {
        padding: 14px;
        text-align: left;
        border-bottom: 1px solid var(--border);
    }

    .history-table th {
        background: var(--bg);
        font-weight: 600;
        color: var(--text);
    }

    .history-table .no-data {
        text-align: center;
        color: var(--muted);
        padding: 32px;
    }

    .pagination {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a {
        padding: 10px 16px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        text-decoration: none;
        color: var(--text);
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .pagination a:hover {
        background: var(--accent);
        color: #ffffff;
        border-color: var(--accent);
    }

    .pagination a.current {
        background: var(--accent);
        color: #ffffff;
        border-color: var(--accent);
    }

    .pagination a.disabled {
        color: var(--muted);
        cursor: not-allowed;
        border-color: var(--border);
    }

    /* Result Card Styles */
    .result-card {
        display: flex;
        align-items: center;
        gap: 16px;
        background: var(--card-bg);
        padding: 20px;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .result-card:hover {
        transform: translateY(-4px);
    }

    .result-icon svg {
        width: 48px;
        height: 48px;
        stroke: var(--accent);
    }

    .result-body h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text);
    }

    .result-body .value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--accent);
    }

    .result-body .muted {
        color: var(--muted);
        font-size: 0.9rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        #sidebar {
            transform: translateX(-100%);
            width: var(--sidebar-width);
        }

        #sidebar.active {
            transform: translateX(0);
        }

        main {
            margin-left: 0;
            padding: 16px;
        }

        #mobile-toggle {
            display: block;
        }

        .meals-grid {
            grid-template-columns: 1fr;
        }

        .header-left h1 {
            font-size: 1.5rem;
        }

        .meal-card {
            padding: 12px;
        }
    }
</style>

<!-- JavaScript Logic -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Sidebar Toggle for Mobile
        const mobileToggle = document.getElementById('mobile-toggle');
        const sidebar = document.getElementById('sidebar');
        mobileToggle.addEventListener('click', () => {
            const isOpen = sidebar.classList.toggle('active');
            mobileToggle.setAttribute('aria-expanded', isOpen);
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

        // Food Selection and Calorie Calculation
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
            const totalCalories = Array.from(items).reduce((sum, i) => sum + parseInt(i.querySelector('.calorie-preview').dataset.calories || 0), 0);
            totalPreview.textContent = `Total: ${totalCalories} kcal`;
            totalPreview.dataset.totalCalories = totalCalories;
        }

        function attachMealItemListeners(item) {
            const select = item.querySelector('.food-select');
            const input = item.querySelector('.quantity-input');
            const removeBtn = item.querySelector('.remove-food-btn');

            select.addEventListener('change', () => {
                input.style.display = select.value ? 'block' : 'none';
                removeBtn.style.display = item.parentElement.children.length > 1 ? 'block' : 'none';
                updateCaloriePreview(item);
            });

            input.addEventListener('input', () => updateCaloriePreview(item));

            if (removeBtn) {
                removeBtn.addEventListener('click', () => {
                    const container = item.parentElement;
                    item.remove();
                    if (container.querySelector('.meal-item')) updateCaloriePreview(container.querySelector('.meal-item'));
                });
            }
        }

        document.querySelectorAll('.meal-item').forEach(attachMealItemListeners);

        // Add Food Item
        document.querySelectorAll('.add-food-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const meal = btn.dataset.meal;
                const container = btn.previousElementSibling;
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
                    <button type="button" class="remove-food-btn" style="display:block;" aria-label="Remove food item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>`;
                container.appendChild(div);
                attachMealItemListeners(div);
            });
        });

        // Form Submission and Validation
        const mealForm = document.getElementById('meal-form');
        const calculateBtn = document.getElementById('calculate-btn');
        mealForm.addEventListener('submit', async e => {
            e.preventDefault();
            document.querySelectorAll('.error-message').forEach(e => e.remove());
            const formData = new FormData(mealForm);
            const mealsData = {};
            let valid = true;

            formData.forEach((value, key) => {
                const matches = key.match(/meals\[(\w+)\]\[(\d+)\]\[(\w+)\]/);
                if (matches) {
                    const [_, meal, index, field] = matches;
                    if (!mealsData[meal]) mealsData[meal] = [];
                    if (!mealsData[meal][index]) mealsData[meal][index] = {};
                    mealsData[meal][index][field] = value;
                }
            });

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

            // Optimistic UI Update
            const historyTbody = document.querySelector('.history-table tbody');
            const noDataRow = historyTbody.querySelector('.no-data');
            if (noDataRow) noDataRow.remove();

            Object.keys(mealsData).forEach(meal => {
                mealsData[meal].forEach(item => {
                    if (item.food && item.quantity) {
                        const calories = Math.round((foodCalories[item.food] || 0) * parseFloat(item.quantity) / 100);
                        const row = document.createElement('tr');
                        row.classList.add('optimistic');
                        row.innerHTML = `
                            <td>${new Date().toLocaleString('en-US', { month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</td>
                            <td>${meal}</td>
                            <td>${item.food}</td>
                            <td>${item.quantity} g/ml</td>
                            <td>${calories} kcal</td>
                        `;
                        historyTbody.insertBefore(row, historyTbody.firstChild);
                    }
                });
            });

            calculateBtn.disabled = true;
            calculateBtn.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M12 2v20M5 12h14"/>
                </svg>
                Calculating...`;

            try {
                const response = await axios.post(mealForm.action, formData, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (response.data.success) {
                    showNotification('Meals logged successfully!', 'success');
                    document.getElementById('history-section').innerHTML = response.data.historyHtml;
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
                        <path d="M12 2v20M5 12h14"/>
                    </svg>
                    Calculate Calories`;
            }
        });

        // Filter Form Handling
        const filterForm = document.getElementById('filter-form');
        if (filterForm) {
            filterForm.addEventListener('submit', async e => {
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

        // Notification Display
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type} show`;
            setTimeout(() => {
                notification.className = 'notification';
            }, 3000);
        }

        // AJAX Pagination
        function attachPaginationListeners() {
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', async e => {
                    e.preventDefault();
                    if (link.classList.contains('disabled')) return;

                    const url = link.getAttribute('href');
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