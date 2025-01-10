let currentPage = 1;
const totalPages = 4;

function showPage(page) {
    // Masquer toutes les pages
    for (let i = 1; i <= totalPages; i++) {
        document.getElementById(`page-${i}`).style.display = 'none';
    }

    // Afficher la page demandée
    document.getElementById(`page-${page}`).style.display = 'block';
}

function navigate(direction) {
    currentPage += direction;

    if (currentPage < 1) {
        currentPage = totalPages;
    } else if (currentPage > totalPages) {
        currentPage = 1;
    }

    showPage(currentPage);
}

// Initialiser la première page affichée
showPage(currentPage);
