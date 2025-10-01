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
    if (e.key === 'Escape' && sidebar.classList.contains('active')) {
      sidebar.classList.remove('active');
      mobileToggle.setAttribute('aria-expanded', 'false');
    }
  });

  const countUps = document.querySelectorAll('.count-up');
  countUps.forEach(val => {
    const target = parseFloat(val.dataset.target || 0);
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