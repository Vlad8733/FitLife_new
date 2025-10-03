document.addEventListener('DOMContentLoaded', () => {
    // CSRF token and alert container setup
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content;
    const alertContainer = document.querySelector('.alert-container');

    if (!CSRF_TOKEN) {
        console.error('CSRF token not found');
        showAlert('Session error. Please refresh the page.', 'danger');
        return;
    }

    // Friend button actions
    document.addEventListener('click', async (e) => {
        if (e.target.matches('.friend-btn')) {
            e.preventDefault();
            const button = e.target;
            const action = button.getAttribute('data-action');
            const method = button.getAttribute('data-method');
            const friendActions = button.closest('.friend-actions');
            const userId = friendActions.getAttribute('data-user-id');

            try {
                const response = await fetch(action, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                const data = await response.json();

                if (!response.ok) throw new Error(data.error || 'Something went wrong');

                // Update UI based on friend action
                if (data.action === 'request_sent') {
                    friendActions.innerHTML = `<span class="friend-status">Request Sent</span>`;
                } else if (data.action === 'accepted') {
                    friendActions.innerHTML = `
                        <span class="friend-status">Friends</span>
                        <button class="friend-btn friend-btn--remove" data-action="${data.removeAction}" data-method="DELETE">Remove Friend</button>
                    `;
                } else if (data.action === 'removed') {
                    friendActions.innerHTML = `
                        <button class="friend-btn friend-btn--add" data-action="${data.addAction}" data-method="POST">Add Friend</button>
                    `;
                }

                showAlert(data.status || 'Success', 'success');
            } catch (error) {
                console.error('Error:', error);
                //showAlert(error.message || 'Something went wrong', 'danger');
            }
        }
    });

    // Like and dislike buttons
    document.addEventListener('click', async (e) => {
        const button = e.target.closest('.like-btn, .dislike-btn');
        if (!button) return;

        const postId = button.getAttribute('data-post-id');
        const type = button.classList.contains('like-btn') ? 'like' : 'dislike';
        const action = `/posts/${postId}/${type}`;

        try {
            const response = await fetch(action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const data = await response.json();
            if (!response.ok) throw new Error(data.error || 'Something went wrong');

            // Update like/dislike counts and button states
            const likeBtn = document.querySelector(`.like-btn[data-post-id="${postId}"]`);
            const dislikeBtn = document.querySelector(`.dislike-btn[data-post-id="${postId}"]`);
            const likeCount = likeBtn.querySelector('.count-like');
            const dislikeCount = dislikeBtn.querySelector('.count-dislike');

            likeCount.textContent = data.likes;
            dislikeCount.textContent = data.dislikes;

            likeBtn.classList.toggle('post-actions__button--active', data.user_liked);
            dislikeBtn.classList.toggle('post-actions__button--active', data.user_disliked);

            likeBtn.querySelector('svg').setAttribute('fill', data.user_liked ? '#FF0000' : 'currentColor');
            dislikeBtn.querySelector('svg').setAttribute('fill', data.user_disliked ? '#000000' : 'currentColor');

            showAlert(data.status || 'Action successful', 'success');
        } catch (error) {
            console.error('Error:', error);
            //showAlert(error.message || 'Something went wrong', 'danger');
        }
    });

    // Comment section toggle
    document.addEventListener('click', (e) => {
        if (e.target.matches('.comment-toggle')) {
            const postId = e.target.getAttribute('data-post-id');
            const commentsSection = document.getElementById(`comments-${postId}`);
            if (commentsSection) {
                commentsSection.style.display = commentsSection.style.display === 'none' ? 'block' : 'none';
            }
        }
    });

    // Comment form submission
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const textarea = form.querySelector('textarea[name="content"]');
            const content = textarea.value.trim();
            if (!content) return showAlert('Comment content is required', 'danger');

            const action = form.getAttribute('action');
            const parentId = form.querySelector('input[name="parent_id"]')?.value;

            try {
                const response = await fetch(action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ content, parent_id: parentId || null }),
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Something went wrong');

                // Add new comment to DOM
                const commentsSection = form.closest('.comments');
                const commentDiv = document.createElement('div');
                commentDiv.className = `comment${parentId ? ' reply' : ''}`;
                commentDiv.style.marginLeft = parentId ? '40px' : '0';
                commentDiv.innerHTML = `
                    <div class="comment__head">
                        <strong>
                            <a href="/profile/${data.user.id}">${data.user.name}</a>
                            <span class="post-meta__username">@${data.user.username}</span>
                        </strong>
                        <time class="post-meta__time" datetime="${data.created_at}">just now</time>
                    </div>
                    <p>${data.content}</p>
                `;
                if (parentId) {
                    const parentComment = form.closest('.comment');
                    parentComment.insertBefore(commentDiv, form);
                } else {
                    commentsSection.insertBefore(commentDiv, form);
                }

                // Update comment count
                const commentToggle = document.querySelector(`.comment-toggle[data-post-id="${data.post_id}"] .comment-count`);
                if (commentToggle) commentToggle.textContent = parseInt(commentToggle.textContent) + 1;

                // Clear form
                textarea.value = '';
                showAlert('Comment added successfully', 'success');
            } catch (error) {
                console.error('Error:', error);
                //showAlert(error.message || 'Something went wrong', 'danger');
            }
        });
    });

    // Post deletion
    document.querySelectorAll('.inline-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const action = form.getAttribute('action');
            const postId = form.closest('.post-card').getAttribute('data-post-id');

            if (!confirm('Are you sure you want to delete this post?')) return;

            try {
                const response = await fetch(action, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Something went wrong');

                const postElement = document.getElementById(`post-${postId}`);
                if (postElement) postElement.remove();
                showAlert(data.status || 'Post deleted successfully', 'success');
            } catch (error) {
                console.error('Error:', error);
                //showAlert(error.message || 'Something went wrong', 'danger');
            }
        });
    });

    // Increment post view count
    document.querySelectorAll('.view-count').forEach(span => {
        const postId = span.getAttribute('data-post-id');
        const action = span.getAttribute('data-action');

        fetch(action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.views) {
                const viewCount = span.querySelector('.count-view');
                if (viewCount) viewCount.textContent = data.views;
            }
        })
        .catch(error => console.error('Error updating view count:', error));
    });

    // Helper function to show alerts
    function showAlert(message, type) {
        if (!alertContainer) {
            console.warn('Alert container not found');
            return;
        }
        const alert = document.createElement('div');
        alert.className = `alert alert--${type}`;
        alert.textContent = message;
        alertContainer.appendChild(alert);
        alertContainer.style.display = 'block';
        setTimeout(() => {
            if (alert.parentNode) alert.parentNode.removeChild(alert);
            if (!alertContainer.children.length) alertContainer.style.display = 'none';
        }, 3000);
    }

    // Mobile sidebar toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    const sidebar = document.getElementById('sidebar');
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', () => {
            const isOpen = sidebar.classList.toggle('active');
            mobileToggle.setAttribute('aria-expanded', isOpen);
        });
    }
});
