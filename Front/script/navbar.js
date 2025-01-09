document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('navbar-toggle');
    const links = document.getElementById('navbar-links');
    const navbar = document.querySelector('.navbar');
    let lastScrollY = window.scrollY;

    // Gestion du clic pour le menu mobile
    toggle.addEventListener('click', () => {
        links.classList.toggle('active');
    });

    // Gestion du scroll pour cacher/afficher la navbar
    window.addEventListener('scroll', () => {
        if (window.scrollY > lastScrollY) {
            // Scroll vers le bas - cacher la navbar
            navbar.classList.add('hidden');
        } else {
            // Scroll vers le haut - afficher la navbar
            navbar.classList.remove('hidden');
        }
        lastScrollY = window.scrollY;
    });
});
