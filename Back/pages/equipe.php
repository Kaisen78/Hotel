<?php
// Ajouter un chef
function addChef($name, $bio, $image_url) {
    $pdo = connectDB();
    $stmt = $pdo->prepare('INSERT INTO chef (name, bio, role, image_url) VALUES (?, ?, ?)');
    $stmt->execute([$name, $bio, $image_url]);
}

// Récupérer les informations du chef
function getChef() {
    $pdo = connectDB();
    $stmt = $pdo->query('SELECT * FROM chef LIMIT 1');
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
