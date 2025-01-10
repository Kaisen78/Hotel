<?php
require_once('../includes/db.php');
session_start(); // Démarrer la session pour accéder à $_SESSION

if (!isset($_SESSION['utilisateur_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour réserver.']);
    exit();
}

$date = $_POST['date'] ?? '';
$heure = $_POST['heure'] ?? '';

if (empty($date) || empty($heure)) {
    echo json_encode(['success' => false, 'message' => 'La date et l\'heure sont obligatoires.']);
    exit();
}

$pdo = connectDB();
$stmt = $pdo->prepare('INSERT INTO reservations_restaurant (utilisateur_id, date, heure) VALUES (?, ?, ?)');
if ($stmt->execute([$_SESSION['utilisateur_id'], $date, $heure])) {
    echo json_encode(['success' => true, 'message' => 'Réservation effectuée avec succès.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la réservation.']);
}
exit();
