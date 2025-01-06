// Gestion du header au scroll
document.addEventListener('scroll', () => {
    const header = document.querySelector('header');
    if (window.scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
  
  // Animation des sections au scroll
  const observerOptions = {
    root: null,
    rootMargin: "0px",
    threshold: 0.1
  };
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
      }
    });
  }, observerOptions);
  
  document.querySelectorAll('.fade-in-section').forEach((section) => {
    observer.observe(section);
  });
  
  // Animation de chargement
  window.addEventListener('load', () => {
    const loader = document.querySelector('.loading');
    if (loader) {
      loader.classList.add('hidden');
    }
  });