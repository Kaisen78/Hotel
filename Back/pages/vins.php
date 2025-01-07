<?php
// Ajouter un vin à la carte
function addvine($name, $region, $price) {
    $pdo = connectDB();
    $stmt = $pdo->prepare('INSERT INTO wine_list (name, region, price) VALUES (?, ?, ?)');
    $stmt->execute([$name, $region, $price]);
}

// Récupérer tous les vins
function getvineList() {
    $pdo = connectDB();
    $stmt = $pdo->query('SELECT * FROM wine_list');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
