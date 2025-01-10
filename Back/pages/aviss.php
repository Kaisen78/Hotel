<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';
require_once 'avis.php';

// Récupérer les avis
$reviews = getAllReviews();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avis - La Flèche d’Argent</title>
    <link rel="stylesheet" href="/Hotel/Front/css/avis.css">
</head>
<body>
    <header>
        <h1>Avis de nos Clients</h1>
        <p>Découvrez ce que nos clients pensent de leur séjour.</p>
        <button id="openModal" class="btn-ajouter-avis">Ajouter un Avis</button>
    </header>

    <main>
        <section class="avis-list">
            <h2>Avis de nos Clients</h2>
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="avis-item">
                        <h2><?= htmlspecialchars($review['pseudo']) ?></h2>
                        <p><?= htmlspecialchars($review['contenu']) ?></p>
                        <small>Posté le : <?= htmlspecialchars($review['date_creation']) ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun avis pour le moment. Soyez le premier à laisser un avis !</p>
            <?php endif; ?>
        </section>

        <!-- Modal pour ajouter un avis -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <span id="closeModal" class="close">&times;</span>
                <form id="addReviewForm">
                    <label for="pseudo">Votre Nom :</label>
                    <input type="text" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo" required>

                    <label for="contenu">Votre Avis :</label>
                    <textarea id="contenu" name="contenu" rows="5" required></textarea>

                    <button type="button" id="submitReview">Soumettre</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 La Flèche d’Argent. Tous droits réservés.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('modal');
            const openModalBtn = document.getElementById('openModal');
            const closeModalBtn = document.getElementById('closeModal');
            const submitReviewBtn = document.getElementById('submitReview');

            // Ouvrir le modal
            openModalBtn.addEventListener('click', () => {
                modal.style.display = 'flex';
            });

            // Fermer le modal
            closeModalBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            // Soumettre le formulaire via AJAX
            submitReviewBtn.addEventListener('click', () => {
                const pseudo = document.getElementById('pseudo').value;
                const contenu = document.getElementById('contenu').value;

                if (pseudo.trim() === '' || contenu.trim() === '') {
                    alert('Veuillez remplir tous les champs.');
                    return;
                }

                fetch('avis.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ pseudo, contenu }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Erreur : ' + data.message);
                    }
                })
                .catch(error => console.error('Erreur :', error));
            });
        });
    </script>
</body>
</html>
