document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('fitlife-container');
    if (!container) return; // работает только на дашборде

    // Animate metric values
    container.querySelectorAll('.value').forEach(val => {
        const target = parseFloat(val.dataset.target || 0);
        let current = 0;
        const step = target / 50;
        const update = () => {
            current += step;
            if (current >= target) {
                val.textContent = Number.isInteger(target) ? target : target.toFixed(1);
                return;
            }
            val.textContent = Number.isInteger(target) ? Math.round(current) : current.toFixed(1);
            requestAnimationFrame(update);
        };
        requestAnimationFrame(update);
    });

    // Animate progress bars
    container.querySelectorAll('.progress-bar').forEach(bar => {
        const percent = parseInt(bar.dataset.progress || 0, 10);
        const fill = bar.querySelector('.progress-fill');
        if (fill) fill.style.width = `${percent}%`;
    });

    // Lightbox
    const photos = container.querySelectorAll('.photo-item');
    const lightbox = container.querySelector('#lightbox');
    if (!lightbox) return;

    const lightboxImg = lightbox.querySelector('#lightbox-img');
    const lightboxDesc = lightbox.querySelector('#lightbox-desc');
    const lightboxDate = lightbox.querySelector('#lightbox-date');
    const closeBtn = lightbox.querySelector('.lightbox-close');
    const prevBtn = lightbox.querySelector('.lightbox-nav.prev');
    const nextBtn = lightbox.querySelector('.lightbox-nav.next');

    let currentIdx = -1;

    const openLightbox = idx => {
        if (idx < 0 || idx >= photos.length) return;
        currentIdx = idx;
        const photo = photos[idx];
        lightboxImg.src = photo.dataset.img;
        lightboxDesc.textContent = photo.dataset.desc || 'No description';
        lightboxDate.textContent = photo.dataset.date || '';
        lightbox.setAttribute('aria-hidden', 'false');
    };

    const closeLightbox = () => {
        lightbox.setAttribute('aria-hidden', 'true');
        currentIdx = -1;
    };

    photos.forEach((photo, idx) => {
        photo.addEventListener('click', () => openLightbox(idx));
        photo.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openLightbox(idx);
            }
        });
    });

    closeBtn.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', e => {
        if (e.target === lightbox) closeLightbox();
    });

    prevBtn.addEventListener('click', () => openLightbox((currentIdx - 1 + photos.length) % photos.length));
    nextBtn.addEventListener('click', () => openLightbox((currentIdx + 1) % photos.length));

    document.addEventListener('keydown', e => {
        if (lightbox.getAttribute('aria-hidden') === 'false') {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') prevBtn.click();
            if (e.key === 'ArrowRight') nextBtn.click();
        }
    });
});
