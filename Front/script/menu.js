// Fonction pour inclure dynamiquement le menu
function includeMenu() {
    const menuContainer = document.getElementById('menu-container');
    fetch('menu.html')
        .then(response => response.text())
        .then(data => {
            menuContainer.innerHTML = data;
            addMenuEventListeners(); // Initialiser les événements après l'insertion
        })
        .catch(error => console.error('Erreur lors de l’inclusion du menu :', error));
}

// Fonction pour ajouter les événements du menu
function addMenuEventListeners() {
    const menuToggle = document.getElementById('menu-toggle'); // Bouton d'ouverture
    const sidebar = document.getElementById('sidebar'); // Barre latérale
    const closeBtn = document.getElementById('close-btn'); // Bouton de fermeture

    // Ouvrir le menu
    menuToggle.addEventListener('click', () => {
        sidebar.classList.add('open');
        menuToggle.style.display = 'none'; // Cache le bouton d'ouverture
    });

    // Fermer le menu avec la croix
    closeBtn.addEventListener('click', () => {
        sidebar.classList.remove('open');
        setTimeout(() => {
            menuToggle.style.display = 'block'; // Affiche le bouton après l'animation
        }, 300);
    });

    // Fermer le menu si on clique en dehors
    window.addEventListener('click', (event) => {
        if (!sidebar.contains(event.target) && event.target !== menuToggle) {
            sidebar.classList.remove('open');
            setTimeout(() => {
                menuToggle.style.display = 'block';
            }, 300);
        }
    });
}

// Inclure le menu au chargement
document.addEventListener('DOMContentLoaded', includeMenu);
