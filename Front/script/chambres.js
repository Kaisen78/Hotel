document.addEventListener("DOMContentLoaded", () => {
    const chambreList = document.querySelector(".chambre-list");
    const chambres = Array.from(document.querySelectorAll(".chambre-item"));
    const arrowLeft = document.querySelector(".arrow.left");
    const arrowRight = document.querySelector(".arrow.right");

    const itemWidth = chambres[0].offsetWidth + 30; // Largeur de chaque élément + espace
    let currentIndex = 1; // Démarrage après le clone initial
    const totalChambres = chambres.length;

    // Clone des premiers et derniers éléments
    const firstClone = chambres[0].cloneNode(true);
    const lastClone = chambres[totalChambres - 1].cloneNode(true);
    chambreList.appendChild(firstClone); // Ajouter le clone du premier à la fin
    chambreList.insertBefore(lastClone, chambres[0]); // Ajouter le clone du dernier au début

    // Précharger les images des clones
    const preloadImage = (image) => {
        const img = new Image();
        img.src = image.src;
    };
    chambres.forEach((chambre) => preloadImage(chambre.querySelector("img")));
    preloadImage(firstClone.querySelector("img"));
    preloadImage(lastClone.querySelector("img"));

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
            chambreList.style.transition = "none"; // Pas de transition
            currentIndex = totalChambres; // Aller au dernier élément
            requestAnimationFrame(() => {
                chambreList.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
            });
        }
        if (currentIndex === totalChambres + 1) {
            chambreList.style.transition = "none"; // Pas de transition
            currentIndex = 1; // Retour au premier élément
            requestAnimationFrame(() => {
                chambreList.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
            });
        }
    };

    // Navigation avec les flèches
    arrowLeft.addEventListener("click", () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    arrowRight.addEventListener("click", () => {
        if (currentIndex < totalChambres + 1) {
            currentIndex++;
            updateCarousel();
        }
    });

    // Réinitialisation après la transition
    chambreList.addEventListener("transitionend", handleInfiniteScroll);
});





