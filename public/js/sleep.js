document.addEventListener("DOMContentLoaded", () => {
  const mobileToggle = document.getElementById('mobile-toggle');
  const sidebar = document.getElementById('sidebar');

  const toggleSidebar = () => {
    const isOpen = sidebar.classList.toggle('active');
    mobileToggle.setAttribute('aria-expanded', isOpen);
  };

  if (mobileToggle && sidebar) {
    mobileToggle.addEventListener('click', toggleSidebar);
    document.addEventListener('click', e => {
      if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
        sidebar.classList.remove('active');
        mobileToggle.setAttribute('aria-expanded', 'false');
      }
    });
    document.addEventListener('keydown', e => e.key === 'Escape' && toggleSidebar());
  }

  document.querySelectorAll('.count-up').forEach(val => {
    const target = parseFloat(val.dataset.target || 0);
    if (!target) return;
    let current = 0;
    const step = target / 50;
    const update = () => {
      current += step;
      val.textContent = current >= target ? (Number.isInteger(target) ? target : target.toFixed(1)) : (Number.isInteger(target) ? Math.round(current) : current.toFixed(1));
      current < target && requestAnimationFrame(update);
    };
    requestAnimationFrame(update);
  });
});