<?php
require_once 'db.php';

// Ajouter un plat au menu
function addMenuItem($name, $description, $price) {
    $pdo = connectDB();
    $stmt = $pdo->prepare('INSERT INTO menu_items (name, description, price) VALUES (?, ?, ?)');
    $stmt->execute([$name, $description, $price]);
}

// Récupérer tous les plats du menu
function getMenuItems() {
    $pdo = connectDB();
    $stmt = $pdo->query('SELECT * FROM menu_items');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
