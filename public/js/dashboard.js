document.addEventListener('DOMContentLoaded', () => {
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content;
    const alertContainer = document.querySelector('.alert-container');

    if (!CSRF_TOKEN) {
        console.error('CSRF token not found');
        showAlert('Session error. Please refresh the page.', 'danger');
        return;
    }

    // Animate metric values
    const animateMetrics = () => {
        document.querySelectorAll('.metric-card .value').forEach(value => {
            const target = parseFloat(value.getAttribute('data-target'));
            let current = 0;
            const increment = target / 50;
            const update = () => {
                current += increment;
                if (current >= target) {
                    value.textContent = target.toFixed(target % 1 === 0 ? 0 : 1);
                    return;
                }
                value.textContent = current.toFixed(target % 1 === 0 ? 0 : 1);
                requestAnimationFrame(update);
            };
            requestAnimationFrame(update);
        });
    };

    // Animate progress bars
    const animateProgressBars = () => {
        document.querySelectorAll('.progress-bar').forEach(bar => {
            const percent = parseInt(bar.getAttribute('data-progress'));
            const fill = bar.querySelector('.progress-fill');
            let current = 0;
            const increment = percent / 50;
            const update = () => {
                current += increment;
                if (current >= percent) {
                    fill.style.width = `${percent}%`;
                    return;
                }
                fill.style.width = `${current}%`;
                requestAnimationFrame(update);
            };
            requestAnimationFrame(update);
        });
    };

    // Lightbox functionality
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxDesc = document.getElementById('lightbox-desc');
    const lightboxDate = document.getElementById('lightbox-date');
    const closeBtn = document.querySelector('.lightbox-close');
    const prevBtn = document.querySelector('.lightbox-nav.prev');
    const nextBtn = document.querySelector('.lightbox-nav.next');
    let currentIdx = 0;
    const photos = document.querySelectorAll('.photo-item');

    const showLightbox = (idx) => {
        const photo = photos[idx];
        if (!photo) return;
        currentIdx = idx;
        lightboxImg.src = photo.getAttribute('data-img');
        lightboxDesc.textContent = photo.getAttribute('data-desc') || 'No description';
        lightboxDate.textContent = photo.getAttribute('data-date');
        lightbox.setAttribute('aria-hidden', 'false');
        lightbox.style.display = 'block';
        document.body.style.overflow = 'hidden';
    };

    const hideLightbox = () => {
        lightbox.setAttribute('aria-hidden', 'true');
        lightbox.style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    photos.forEach(photo => {
        photo.addEventListener('click', () => {
            showLightbox(parseInt(photo.getAttribute('data-idx')));
        });
        photo.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                showLightbox(parseInt(photo.getAttribute('data-idx')));
            }
        });
    });

    closeBtn.addEventListener('click', hideLightbox);
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) hideLightbox();
    });

    prevBtn.addEventListener('click', () => {
        if (currentIdx > 0) showLightbox(currentIdx - 1);
    });

    nextBtn.addEventListener('click', () => {
        if (currentIdx < photos.length - 1) showLightbox(currentIdx + 1);
    });

    document.addEventListener('keydown', (e) => {
        if (lightbox.getAttribute('aria-hidden') === 'false') {
            if (e.key === 'Escape') hideLightbox();
            if (e.key === 'ArrowLeft' && currentIdx > 0) showLightbox(currentIdx - 1);
            if (e.key === 'ArrowRight' && currentIdx < photos.length - 1) showLightbox(currentIdx + 1);
        }
    });

    // Helper to show alerts
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
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
            if (!alertContainer.children.length) {
                alertContainer.style.display = 'none';
            }
        }, 3000);
    }

    // Initialize animations
    animateMetrics();
    animateProgressBars();
});