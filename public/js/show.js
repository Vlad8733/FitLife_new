document.addEventListener("DOMContentLoaded", function () {
  const mobileToggle = document.getElementById('mobile-toggle');
  const sidebar = document.getElementById('sidebar');

  mobileToggle.addEventListener('click', () => {
    const isOpen = sidebar.classList.toggle('active');
    mobileToggle.setAttribute('aria-expanded', isOpen);
  });

  document.addEventListener('click', e => {
    if (sidebar.classList.contains('active') && !sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
      sidebar.classList.remove('active');
      mobileToggle.setAttribute('aria-expanded', 'false');
    }
  });

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      sidebar.classList.remove('active');
      mobileToggle.setAttribute('aria-expanded', 'false');
    }
  });

  document.querySelectorAll('.comment-toggle').forEach(button => {
    button.addEventListener('click', function () {
      const postId = this.getAttribute('data-post-id');
      const comments = document.getElementById(`comments-${postId}`);
      comments.style.display = comments.style.display === 'none' ? 'block' : 'none';
    });
  });

  document.querySelectorAll('.like-btn, .dislike-btn').forEach(button => {
    button.addEventListener('click', function () {
      const postId = this.getAttribute('data-post-id');
      const type = this.classList.contains('like-btn') ? 'like' : 'dislike';
      fetch(`/posts/${postId}/react`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ type })
      })
        .then(response => response.json())
        .then(data => {
          const likeBtn = document.querySelector(`.like-btn[data-post-id="${postId}"]`);
          const dislikeBtn = document.querySelector(`.dislike-btn[data-post-id="${postId}"]`);
          likeBtn.classList.toggle('active', data.type === 'like');
          dislikeBtn.classList.toggle('active', data.type === 'dislike');
          likeBtn.querySelector('.count-like').textContent = data.likeCount;
          dislikeBtn.querySelector('.count-dislike').textContent = data.dislikeCount;
        })
        .catch(error => console.error('Error:', error));
    });
  });

  document.querySelectorAll('.view-count').forEach(span => {
    span.addEventListener('click', function () {
      const postId = this.getAttribute('data-post-id');
      const actionUrl = this.getAttribute('data-action');
      fetch(actionUrl, {
        method: 'GET'
      })
        .then(response => response.json())
        .then(data => {
          this.querySelector('.count-view').textContent = data.views;
        })
        .catch(error => console.error('Error:', error));
    });
  });
});