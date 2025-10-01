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
});