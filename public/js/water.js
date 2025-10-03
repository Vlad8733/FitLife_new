document.addEventListener("DOMContentLoaded", function () {
  // Mobile sidebar toggle
  const mobileToggle = document.getElementById('mobile-toggle');
  const sidebar = document.getElementById('sidebar');

  const toggleSidebar = () => {
    const isOpen = sidebar.classList.toggle('active');
    mobileToggle.setAttribute('aria-expanded', isOpen);
  };

  const closeSidebar = () => {
    if (sidebar.classList.contains('active')) {
      sidebar.classList.remove('active');
      mobileToggle.setAttribute('aria-expanded', 'false');
    }
  };

  if (mobileToggle && sidebar) {
    mobileToggle.addEventListener('click', toggleSidebar);

    // Close sidebar when clicking outside
    document.addEventListener('click', e => {
      if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
        closeSidebar();
      }
    });

    // Close sidebar on Escape key
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') closeSidebar();
    });
  }

  // Animated count-up numbers
  const countUps = document.querySelectorAll('.count-up');
  countUps.forEach(val => {
    const target = parseFloat(val.dataset.target || 0);
    if (!target) return;

    let current = 0;
    const step = target / 50;

    const update = () => {
      current += step;
      if (current >= target) {
        current = target;
        val.textContent = Number.isInteger(target) ? target : target.toFixed(1);
        return;
      }
      val.textContent = Number.isInteger(target) ? Math.round(current) : current.toFixed(1);
      requestAnimationFrame(update);
    };

    requestAnimationFrame(update);
  });
});
