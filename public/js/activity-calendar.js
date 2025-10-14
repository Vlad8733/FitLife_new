document.addEventListener('DOMContentLoaded', () => {
    const calendarGrid = document.querySelector('.calendar-grid');
    const monthDisplay = document.querySelector('.calendar-month');
    const prevMonthBtn = document.querySelector('.prev-month');
    const nextMonthBtn = document.querySelector('.next-month');
    const eventForm = document.querySelector('#event-form');
    const eventList = document.querySelector('.event-list');
    const formMessage = document.querySelector('#form-message');
    const eventFilter = document.querySelector('#event-filter');
    let currentDate = new Date();

    // Fetch events from server
    async function fetchEvents() {
        const start = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).toISOString().split('T')[0];
        const end = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).toISOString().split('T')[0];
        try {
            const response = await fetch(`/calendar/events?start=${start}&end=${end}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            if (!response.ok) throw new Error('Failed to fetch events');
            return await response.json();
        } catch (error) {
            console.error('Error fetching events:', error);
            formMessage.className = 'error';
            formMessage.textContent = 'Failed to load events.';
            return [];
        }
    }

    // Render calendar
    async function renderCalendar() {
        calendarGrid.innerHTML = '';
        calendarGrid.append(...Array.from({ length: 7 }, (_, i) => {
            const header = document.createElement('div');
            header.className = 'calendar-header';
            header.textContent = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'][i];
            return header;
        }));

        const events = await fetchEvents();
        const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
        const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
        const offset = firstDay === 0 ? 6 : firstDay - 1;

        for (let i = 0; i < offset; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day calendar-day--empty';
            calendarGrid.appendChild(emptyDay);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = day;

            const dateStr = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const dayEvents = events.filter(e => e.start === dateStr);
            if (dayEvents.length) {
                dayElement.classList.add('calendar-day--event');
                if (dayEvents.some(e => e.completed)) {
                    dayElement.classList.add('calendar-day--completed');
                }
            }

            dayElement.addEventListener('click', () => {
                document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('calendar-day--selected'));
                dayElement.classList.add('calendar-day--selected');
                document.querySelector('#event-date').value = dateStr;
            });

            calendarGrid.appendChild(dayElement);
        }

        monthDisplay.textContent = currentDate.toLocaleString('en-US', { month: 'long', year: 'numeric' });
    }

    // Render events
    async function renderEvents(filter = 'all') {
        const events = await fetchEvents();
        eventList.innerHTML = '';
        const filteredEvents = filter === 'all' ? events : events.filter(e => e.type === filter);
        filteredEvents.forEach(event => {
            const li = document.createElement('li');
            li.className = `event-item event-item__type--${event.type}`;
            li.innerHTML = `
                <span class="event-item__details">
                    <strong>${event.start} - ${event.title}</strong>
                    <span>${event.description || 'No description'}</span>
                </span>
            `;
            eventList.appendChild(li);
        });
    }

    // Add event
    eventForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(eventForm);
        try {
            const response = await fetch(eventForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
            const result = await response.json();
            if (response.ok) {
                formMessage.className = 'success';
                formMessage.textContent = 'Event added successfully!';
                eventForm.reset();
                await renderCalendar();
                await renderEvents(eventFilter.value);
            } else {
                formMessage.className = 'error';
                formMessage.textContent = result.message || 'Failed to save event.';
            }
        } catch (error) {
            formMessage.className = 'error';
            formMessage.textContent = 'Error: ' + error.message;
        }
    });

    // Event filter
    eventFilter.addEventListener('change', () => {
        renderEvents(eventFilter.value);
    });

    // Month navigation
    prevMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
        renderEvents(eventFilter.value);
    });

    nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
        renderEvents(eventFilter.value);
    });

    // Initialize
    renderCalendar();
    renderEvents();
});