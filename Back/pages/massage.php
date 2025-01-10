<?php
require_once('../includes/db.php');

// Ajouter un service de massage
function addMassageService($name, $description, $duration, $price) {
    $pdo = connectDB();
    $stmt = $pdo->prepare('INSERT INTO massage (name, description, duration, price) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $description, $duration, $price]);
}

// Récupérer tous les services de massage
function getMassageServices() {
    $pdo = connectDB();
    $stmt = $pdo->query('SELECT * FROM massage');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
