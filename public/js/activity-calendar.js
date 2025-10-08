document.addEventListener('DOMContentLoaded', () => {
    const calendarGrid = document.querySelector('.calendar-grid');
    const monthDisplay = document.querySelector('.calendar-month');
    const prevMonthBtn = document.querySelector('.prev-month');
    const nextMonthBtn = document.querySelector('.next-month');
    const eventForm = document.querySelector('#event-form');
    const eventList = document.querySelector('.event-list');
    const formMessage = document.querySelector('#form-message');

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
            return [];
        }
    }

    // Render calendar
    async function renderCalendar() {
        calendarGrid.innerHTML = ''; // Clear grid
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
            const event = events.find(e => e.start === dateStr);
            if (event) {
                dayElement.classList.add('calendar-day--event');
                if (event.completed) dayElement.classList.add('calendar-day--completed');
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
    async function renderEvents() {
        const events = await fetchEvents();
        eventList.innerHTML = '';
        events.forEach(event => {
            const li = document.createElement('li');
            li.className = 'event-item';
            li.innerHTML = `
                <span class="event-item__details">
                    <strong class="event-item__type--${event.type}">${event.start} - ${event.title}</strong>
                </span>
                <button class="event-item__complete" aria-label="Mark as completed">
                    <svg><use xlink:href="#check"></use></svg>
                </button>
            `;
            li.querySelector('.event-item__complete').addEventListener('click', async () => {
                try {
                    const response = await fetch(`/calendar/${event.id}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ completed: !event.completed })
                    });
                    if (!response.ok) throw new Error('Failed to update event');
                    await renderCalendar();
                    await renderEvents();
                } catch (error) {
                    console.error('Error updating event:', error);
                }
            });
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
                await renderEvents();
            } else {
                formMessage.className = 'error';
                formMessage.textContent = result.message || 'Failed to add event.';
            }
        } catch (error) {
            formMessage.className = 'error';
            formMessage.textContent = 'Error: ' + error.message;
        }
    });

    // Month navigation
    prevMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
        renderEvents();
    });

    nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
        renderEvents();
    });

    // Initialize
    renderCalendar();
    renderEvents();
});