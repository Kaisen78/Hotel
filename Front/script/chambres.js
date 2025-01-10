document.addEventListener("DOMContentLoaded", () => {
    const chambreList = document.querySelector(".chambre-list");
    const chambres = Array.from(document.querySelectorAll(".chambre-item"));
    const arrowLeft = document.querySelector(".arrow.left");
    const arrowRight = document.querySelector(".arrow.right");

    const itemWidth = chambres[0].offsetWidth + 30; // Largeur d'un élément + espace
    let currentIndex = 1; // Démarrage après le clone initial
    const totalChambres = chambres.length;

    // Clone des premiers et derniers éléments pour l'effet infini
    const firstClone = chambres[0].cloneNode(true);
    const lastClone = chambres[totalChambres - 1].cloneNode(true);
    chambreList.appendChild(firstClone); // Clone du premier à la fin
    chambreList.insertBefore(lastClone, chambres[0]); // Clone du dernier au début

    // Position initiale
    chambreList.style.transform = `translateX(${-currentIndex * itemWidth}px)`;

    // Fonction pour mettre à jour la position
    const updateCarousel = () => {
        chambreList.style.transition = "transform 0.4s ease-in-out";
        chambreList.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
    };

    // Gestion des limites pour le défilement infini
    const handleInfiniteScroll = () => {
        if (currentIndex === 0) {
            chambreList.style.transition = "none";
            currentIndex = totalChambres;
            requestAnimationFrame(() => {
                chambreList.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
            });
        }
        if (currentIndex === totalChambres + 1) {
            chambreList.style.transition = "none";
            currentIndex = 1;
            requestAnimationFrame(() => {
                chambreList.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
            });
        }
    };

    // Défilement automatique
    const autoScroll = () => {
        currentIndex++;
        updateCarousel();
    };

    // Intervalle pour le défilement automatique
    let autoScrollInterval = setInterval(autoScroll, 3000); // Change toutes les 3 secondes

    // Navigation avec les flèches
    arrowLeft.addEventListener("click", () => {
        currentIndex--;
        updateCarousel();
        resetAutoScroll();
    });

    arrowRight.addEventListener("click", () => {
        currentIndex++;
        updateCarousel();
        resetAutoScroll();
    });

    // Réinitialisation après la transition
    chambreList.addEventListener("transitionend", handleInfiniteScroll);

    // Réinitialise l'intervalle de défilement automatique après une interaction manuelle
    const resetAutoScroll = () => {
        clearInterval(autoScrollInterval);
        autoScrollInterval = setInterval(autoScroll, 3000);
    };
});
