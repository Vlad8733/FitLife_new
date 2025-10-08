document.addEventListener("DOMContentLoaded", function(){
    const toggle = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebar');

    // Toggle Sidebar
    toggle.addEventListener('click', () => {
        const open = sidebar.classList.toggle('active');
        toggle.setAttribute('aria-expanded', open);
    });

    // Close on click outside
    document.addEventListener('click', e => {
        if (sidebar.classList.contains('active') && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });

    // Close on Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            sidebar.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });
}); 