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

  const avatarInput = document.getElementById('avatar');
  const bannerAvatar = document.getElementById('bannerAvatar');
  avatarInput.addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
      const url = URL.createObjectURL(file);
      bannerAvatar.src = url;
    }
  });

  const bannerInput = document.getElementById('banner');
  const changeBannerLabel = document.querySelector('.change-banner-label');
  changeBannerLabel.addEventListener('click', () => {
    bannerInput.click();
  });

  bannerInput.addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.querySelector('.banner-bg').style.backgroundImage = `url(${e.target.result})`;
      };
      reader.readAsDataURL(file);
    }
  });
});