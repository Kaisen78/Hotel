<?php

// Se connecter à la base de données
function connectDB() {
    $host = 'localhost';
    $dbname = 'hotel';
    $username = 'root';
    $password = 'root';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        error_log("Connexion à la base de données réussie");
        return $pdo;
    } catch (PDOException $e) {
        error_log("Erreur de connexion : " . $e->getMessage());
        die("Erreur de connexion : " . $e->getMessage());
    }
}
?>
