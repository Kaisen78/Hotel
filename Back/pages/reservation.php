<?php
require_once('db.php');

// Créeation d'une réservation
function createReservation($utilisateur_id, $type_chambre, $date_debut, $date_fin, $statut = 'en attente') {
    $pdo = connectDB();
    $stmt = $pdo->prepare('INSERT INTO reservations (utilisateur_id, type_chambre, date_debut, date_fin, statut) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$utilisateur_id, $type_chambre, $date_debut, $date_fin, $statut]);
    return $pdo->lastInsertId();
}

// Afficher les réservations d'un utilisateur
function getUserReservations($utilisateur_id) {
    $pdo = connectDB();
    $stmt = $pdo->prepare('SELECT * FROM reservations WHERE utilisateur_id = ?');
    $stmt->execute([$utilisateur_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Afficher toutes les réservations
function getAllReservations() {
    $pdo = connectDB();
    $stmt = $pdo->query('SELECT * FROM reservations');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
