<?php
require_once 'db.php';

// Ajouter un service de massage
function addMassageService($name, $description, $duration, $price) {
    $pdo = connectDB();
    $stmt = $pdo->prepare('INSERT INTO massage_services (name, description, duration, price) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $description, $duration, $price]);
}

// Récupérer tous les services de massage
function getMassageServices() {
    $pdo = connectDB();
    $stmt = $pdo->query('SELECT * FROM massage_services');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
