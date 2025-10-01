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
    const foodCalories = window.foodCalories || {};

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
            selectHTML += window.foodOptionsHTML || '';
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
            const url = new URL(window.foodsIndexUrl || '');
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