<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); error_reporting(E_ALL);

require_once('../includes/db.php');
require_once('user.php'); // Inclure les fonctions utilisateur
require_once('reservation.php');
require_once('avis.php');


// Vérifiez si l'utilisateur est connecté et est un administrateur
if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php'); // Redirige si l'utilisateur n'est pas administrateur
    exit();
}

// Connexion à la base de données
$pdo = connectDB();

// Récupération des utilisateurs
$stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE role = ?');
$stmt->execute(['user']); 
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des réservations
$stmt = $pdo->query('SELECT reservations.id, utilisateurs.pseudo, CONCAT(reservations.date_debut, " - ", reservations.date_fin) AS periode, reservations.type_chambre FROM reservations JOIN utilisateurs ON reservations.utilisateur_id = utilisateurs.id');
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des réservations de massage
$stmt = $pdo->query('SELECT m.id, u.pseudo AS name, m.description, m.duration
                     FROM massage AS m
                     JOIN utilisateurs AS u ON m.utilisateur_id = u.id');
$massage_reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des réservations du restaurant
$stmt = $pdo->query('SELECT rr.id, u.pseudo, rr.date, rr.heure
                     FROM reservations_restaurant AS rr
                     JOIN utilisateurs AS u ON rr.utilisateur_id = u.id');
$restaurant_reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des avis clients
$stmt = $pdo->query('SELECT avis.id, utilisateurs.pseudo, avis.contenu, avis.date_creation FROM avis JOIN utilisateurs ON avis.utilisateur_id = utilisateurs.id');
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Suppression d'un utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user_id'])) {
    $user_id = $_POST['delete_user_id'];
    if (deleteUser($user_id)) {
        header('Location: administrateur.php'); // Redirige vers la page d'administration
        exit();
    } else {
        echo "Erreur lors de la suppression de l'utilisateur.";
    }
}

// Suppression d'une réservation de chambre
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_reservation_id'])) {
    $reservation_id = $_POST['delete_reservation_id'];
    if (deleteReservation($reservation_id)) {
        header('Location: administrateur.php'); // Redirige vers la page d'administration
        exit();
    } else {
        echo "Erreur lors de la suppression de la réservation.";
    }
}

// Suppression d'une réservation de massage
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_massage_reservation_id'])) {
    $massage_reservation_id = $_POST['delete_massage_reservation_id'];
    if (deleteMassageReservation($massage_reservation_id)) {
        header('Location: administrateur.php'); // Redirige vers la page d'administration
        exit();
    } else {
        echo "Erreur lors de la suppression de la réservation de massage.";
    }
}

// Suppression d'une réservation de restaurant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_restaurant_reservation_id'])) {
    $restaurant_reservation_id = $_POST['delete_restaurant_reservation_id'];
    if (deleteRestaurantReservation($restaurant_reservation_id)) {
        header('Location: administrateur.php'); // Redirige vers la page d'administration
        exit();
    } else {
        echo "Erreur lors de la suppression de la réservation de restaurant.";
    }
}

// Suppression d'un avis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_review_id'])) {
    $review_id = $_POST['delete_review_id'];
    if (deleteReview($review_id)) {
        header('Location: administrateur.php'); // Redirige vers la page d'administration
        exit();
    } else {
        echo "Erreur lors de la suppression de l'avis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - La Flèche d’Argent</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Hotel/Front/css/administrateur.css">
</head>
<body>
    <header>
        <h1>Panneau d'Administration</h1>
        <p>Gérez les utilisateurs, les réservations et les avis.</p>
        <div style="position: absolute; top: 10px; right: 10px;">
        <a href="/Hotel/Front/logout.php" style="text-decoration: none; background-color: #ff4d4d; color: white; padding: 10px 15px; border-radius: 5px; font-size: 14px;">Se déconnecter</a>
    </div>
    </header>
    <main>
        <section class="utilisateurs">
            <h2>Liste des Utilisateurs</h2>
            <table>
                <thead>
                    <tr>
                        <th>Pseudo</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['pseudo']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['telephone']) ?></td>
                            <td>
                                <form action="administrateur.php" method="post"> 
                                    <input type="hidden" name="delete_user_id" value="<?= htmlspecialchars($user['id']) ?>"> 
                                    <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">Supprimer</button> 
                                </form> 
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section class="reservations">
            <h2>Historique des Réservations chambres</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom de l'utilisateur</th>
                        <th>Type de chambre</th>
                        <th>Dates de séjour</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['pseudo']) ?></td>
                        <td><?= htmlspecialchars($reservation['type_chambre']) ?></td>
                        <td><?= htmlspecialchars($reservation['periode']) ?></td>
                        <td> 
                            <form action="administrateur.php" method="post"> 
                                <input type="hidden" name="delete_reservation_id" value="<?= htmlspecialchars($reservation['id']) ?>"> 
                                <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?')">Annuler</button> 
                            </form> 
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section class="reservations-massage">
            <h2>Réservations de Massage</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom de l'utilisateur</th>
                        <th>Type de massage</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($massage_reservations as $massage_reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($massage_reservation['name']) ?></td>
                        <td><?= htmlspecialchars($massage_reservation['description']) ?></td>
                        <td><?= htmlspecialchars($massage_reservation['duration']) ?></td>
                        <td> 
                            <form action="administrateur.php" method="post"> 
                                <input type="hidden" name="delete_massage_reservation_id" value="<?= htmlspecialchars($massage_reservation['id']) ?>"> 
                                <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette réservation de massage ?')">Annuler</button> 
                            </form> 
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section class="reservations-restaurant">
            <h2>Réservations au Restaurant</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom de l'utilisateur</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($restaurant_reservations as $restaurant_reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($restaurant_reservation['pseudo']) ?></td>
                        <td><?= htmlspecialchars($restaurant_reservation['date']) ?></td>
                        <td><?= htmlspecialchars($restaurant_reservation['heure']) ?></td>
                        <td> 
                            <form action="administrateur.php" method="post"> 
                                <input type="hidden" name="delete_restaurant_reservation_id" value="<?= htmlspecialchars($restaurant_reservation['id']) ?>">
                                <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette réservation de restaurant ?')">Annuler</button> 
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        
        <section class="avis">
            <h2>Avis des Clients</h2>
            <table>
                <thead>
                    <tr>
                        <th>Pseudo</th>
                        <th>Avis</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><?= htmlspecialchars($review['pseudo']) ?></td>
                        <td><?= htmlspecialchars($review['contenu']) ?></td>
                        <td><?= htmlspecialchars($review['date_creation']) ?></td>
                        <td>
                            <form action="administrateur.php" method="post"> 
                                <input type="hidden" name="delete_review_id" value="<?= htmlspecialchars($review['id']) ?>"> 
                                <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cet avis ?')">Supprimer</button> 
                            </form> 
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 La Flèche d’Argent. Tous droits réservés.</p>
    </footer>
</body>
</html>
