document.addEventListener("DOMContentLoaded", () => {
    const chambreList = document.querySelector(".chambre-list");
    const chambres = document.querySelectorAll(".chambre-item");
    const centerOffset = window.innerWidth / 2;
    
    let currentIndex = 0;
    const scrollInterval = 5000; // Temps entre chaque défilement (5 secondes)
    
    function calculateDistance(element) {
        const rect = element.getBoundingClientRect();
        const elementCenter = rect.left + (rect.width / 2);
        return Math.abs(elementCenter - centerOffset);
    }
    
    function updateChambres() {
        chambres.forEach((chambre) => {
            const distance = calculateDistance(chambre);
            const maxDistance = window.innerWidth / 2;
            const ratio = Math.min(distance / maxDistance, 1);
            
            // Calcul progressif du flou et de l'opacité
            const blur = Math.min(10 * ratio, 10);
            const scale = 1 - (0.2 * ratio);
            const opacity = 1 - (0.5 * ratio);
            
            chambre.style.transform = `scale(${scale})`;
            chambre.style.filter = `blur(${blur}px)`;
            chambre.style.opacity = opacity;
            
            // Effet de parallaxe sur l'image
            const img = chambre.querySelector('img');
            if (img) {
                img.style.transform = `scale(${1 + (0.1 * (1 - ratio))})`;
            }
        });
    }
    
    function moveCarousel() {
        currentIndex = (currentIndex + 1) % chambres.length;
        const offset = -currentIndex * (chambres[0].offsetWidth + 30); // 30px est le gap entre les éléments
        chambreList.style.transform = `translateX(calc(-50% + ${offset}px))`;
        
        // Mise à jour progressive des effets
        requestAnimationFrame(updateChambres);
    }
    
    // Initialisation
    updateChambres();
    
    // Défilement automatique
    setInterval(moveCarousel, scrollInterval);
    
    // Mise à jour lors du redimensionnement
    window.addEventListener('resize', updateChambres);
    
    // Animation fluide pendant le défilement
    chambreList.addEventListener('transitionstart', () => {
        requestAnimationFrame(function animate() {
            updateChambres();
            if (chambreList.style.transition !== '') {
                requestAnimationFrame(animate);
            }
        });
    });
});