document.addEventListener("DOMContentLoaded", () => {
    // Mobile menu toggle
    const mobileToggle = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebar');

    const closeSidebar = () => {
        sidebar.classList.remove('active');
        mobileToggle.setAttribute('aria-expanded', 'false');
    };

    mobileToggle.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('active');
        mobileToggle.setAttribute('aria-expanded', isOpen);
    });

    document.addEventListener('click', (e) => {
        if (sidebar.classList.contains('active') && !sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
            closeSidebar();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeSidebar();
        }
    });

    // Avatar preview
    const avatarInput = document.getElementById('avatar');
    const bannerAvatar = document.getElementById('bannerAvatar');

    avatarInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            bannerAvatar.src = URL.createObjectURL(file);
        }
    });

    // Banner preview
    const bannerInput = document.getElementById('banner');
    const changeBannerLabel = document.querySelector('.change-banner-label');
    const bannerBg = document.querySelector('.banner-bg');

    changeBannerLabel.addEventListener('click', () => bannerInput.click());

    bannerInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (ev) => {
                bannerBg.style.backgroundImage = `url(${ev.target.result})`;
            };
            reader.readAsDataURL(file);
        }
    });
});
