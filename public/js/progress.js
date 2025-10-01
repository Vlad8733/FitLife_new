document.addEventListener("DOMContentLoaded", function () {
  const mobileToggle = document.getElementById('mobile-toggle');
  const sidebar = document.getElementById('sidebar');
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const lightboxDesc = document.getElementById('lightbox-desc');
  const lightboxDate = document.getElementById('lightbox-date');
  const closeBtn = document.querySelector('.lightbox-close');
  const prevBtn = document.querySelector('.lightbox-nav.prev');
  const nextBtn = document.querySelector('.lightbox-nav.next');
  const photos = document.querySelectorAll('.photo-item');
  let currentIdx = -1;

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
      lightbox.setAttribute('aria-hidden', 'true');
    }
  });

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
    const img = photo.querySelector('.photo-img');
    img.addEventListener('click', () => openLightbox(idx));
    img.addEventListener('keydown', e => {
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