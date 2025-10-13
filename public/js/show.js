document.addEventListener('DOMContentLoaded', () => {
    const friendForms = document.querySelectorAll('.friend-form');

    friendForms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const action = form.getAttribute('data-action');
            const userId = form.closest('.friend-actions').getAttribute('data-user-id');
            const url = form.action;
            const method = form.querySelector('input[name="_method"]')?.value || 'POST';
            const formData = new FormData(form);
            const token = form.querySelector('input[name="_token"]').value;

            // Remove any existing error messages
            const existingError = form.closest('.friend-actions').querySelector('.friend-error');
            if (existingError) existingError.remove();

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: method === 'POST' ? formData : undefined
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || 'Something went wrong');
                }

                const friendActions = form.closest('.friend-actions');

                // Update UI based on action
                if (data.action === 'request_sent') {
                    friendActions.innerHTML = `
                        <span class="friend-status">Friend request sent</span>
                    `;
                } else if (data.action === 'accepted') {
                    friendActions.innerHTML = `
                        <span class="friend-status">Вы друзья</span>
                        <form action="${data.removeAction}" method="POST" class="friend-form" data-action="remove">
                            <input type="hidden" name="_token" value="${token}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="friend-btn friend-btn-danger">Unfriend</button>
                        </form>
                    `;
                } else if (data.action === 'removed') {
                    friendActions.innerHTML = `
                        <form action="${data.addAction}" method="POST" class="friend-form" data-action="add">
                            <input type="hidden" name="_token" value="${token}">
                            <input type="hidden" name="friend_id" value="${userId}">
                            <button type="submit" class="friend-btn friend-btn-primary">Add as friend</button>
                        </form>
                    `;
                }

            } catch (error) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'friend-error';
                errorDiv.textContent = error.message;
                friendActions.appendChild(errorDiv);
            }
        });
    });
});