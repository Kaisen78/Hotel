<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connection.html');
    exit();
}

$isLoggedIn = isset($_SESSION['user_id']); // Variable définie pour vérifier si l'utilisateur est connecté
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/reservation.css">
</head>
<body>
    <header>
        <div class="login-logo">
            <?php if ($isLoggedIn): ?>
                <!-- Lien de déconnexion si l'utilisateur est connecté -->
                <a href="logout.php" onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">Se déconnecter</a>
            <?php else: ?>
                <!-- Logo si l'utilisateur n'est pas connecté -->
                <a href="connection.html">
                    <img src="/Hotel/Front/assets/OIP-removebg-preview.png" alt="Connexion">
                </a>
            <?php endif; ?>
        </div>
    </header>

    <h1>Réservez votre chambre</h1>
    <form id="reservationForm" method="POST" action="create_reservation.php">
        <div class="reservation-container">
            <div class="guest-selection">
                <h2>Nombre de personnes</h2>
                <div class="guest-inputs">
                    <label for="adults">Adultes :</label>
                    <input type="number" id="adults" name="adults" min="1" value="1" required>
                    <label for="children">Enfants :</label>
                    <input type="number" id="children" name="children" min="0" value="0">
                </div>
            </div>
            <div class="room-selection">
                <h2>Type de chambre</h2>
                <select id="roomType" name="prix_chambre" onchange="updateRoomType()">
                    <option value="281" data-type="standard">Standard - 281 € / nuit</option>
                    <option value="325" data-type="confort">Confort - 325 € / nuit</option>
                    <option value="366" data-type="standing">Standing - 366 € / nuit</option>
                    <option value="415" data-type="suite">Suite - 415 € / nuit</option>
                </select>
                <input type="hidden" id="type_chambre" name="type_chambre" value="standard">
            </div>
            <div class="calendar">
                <div class="calendar-header">
                    <button type="button" id="prevMonth">&lt;</button>
                    <div id="monthYear"></div>
                    <button type="button" id="nextMonth">&gt;</button>
                </div>
                <div class="calendar-days" id="calendarDays"></div>
                <div class="info">
                    <p>Dates sélectionnées : </p>
                    <span id="selectedDates">Aucune</span>
                </div>
                <div class="info">
                    <p>Coût total : </p>
                    <span id="totalCost">0 €</span>
                </div>
            </div>
            <div class="reservation-summary">
                <button type="submit" id="confirmReservation">Réserver</button>
                <div id="reservationDetails"></div>
            </div>
        </div>
    </form>

    <footer>
        <p>&copy; 2025 La flèche d’Argent. Tous droits réservés.</p>
    </footer>
    <script src="script/reservation.js"></script>
</body>
</html>
