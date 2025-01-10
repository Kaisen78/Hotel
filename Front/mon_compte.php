<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Stockez la page actuelle pour une redirection après connexion (facultatif)
    $_SESSION['requested_page'] = $_SERVER['REQUEST_URI'];

    // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connection.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte - La Flèche d’Argent</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/mon_compte.css">
</head>
<body>
    <header>
        <h1>Mon Compte</h1>
        <p>Gérez vos informations personnelles et vos réservations.</p>
    </header>
    <main>
        <section class="reservations">
            <h2>Mes Réservations</h2>
            <table>
                <thead>
                    <tr>
                        <th>Type de chambre</th>
                        <th>Dates de séjour</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Chambre Confort</td>
                        <td>01/01/2025 - 05/01/2025</td>
                        <td><button>Annuler</button></td>
                    </tr>
                    <tr>
                        <td>Suite</td>
                        <td>10/01/2025 - 15/01/2025</td>
                        <td><button>Annuler</button></td>
                    </tr>
                    <!-- Ajoutez d'autres réservations ici -->
                </tbody>
            </table>
        </section>

        <section class="informations-personnelles">
            <h2>Modifier mes Informations Personnelles</h2>
            <form action="/Hotel/Back/pages/update_info.php" method="post">
                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone :</label>
                    <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($_SESSION['user_phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse postale :</label>
                    <textarea id="adresse" name="adresse" required><?= htmlspecialchars($_SESSION['user_address'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">Mettre à jour</button>
                </div>
            </form>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <p style="color: green;">Vos informations ont été mises à jour avec succès.</p>
            <?php endif; ?>
            
        </section>
    </main>
    <footer>
        <p>&copy; 2025 La Flèche d’Argent. Tous droits réservés.</p>
    </footer>
</body>
</html>
