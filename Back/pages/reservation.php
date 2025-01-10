<?php
require_once('C:/MAMP/htdocs/hotel/Back/includes/db.php'); // Inclure le fichier de connexion à la base de données

// Fonction pour créer une réservation
function createReservation($utilisateur_id, $type_chambre, $date_debut, $date_fin, $adults, $children, $total_cost) {
    try {
        $pdo = connectDB(); // Établir la connexion à la base de données

        $sql = "INSERT INTO reservations (utilisateur_id, type_chambre, date_debut, date_fin, adults, children, total_cost)
                VALUES (:utilisateur_id, :type_chambre, :date_debut, :date_fin, :adults, :children, :total_cost)";
        $stmt = $pdo->prepare($sql);

        // Exécuter la requête
        $stmt->execute([
            ':utilisateur_id' => $utilisateur_id,
            ':type_chambre' => $type_chambre,
            ':date_debut' => $date_debut,
            ':date_fin' => $date_fin,
            ':adults' => $adults,
            ':children' => $children,
            ':total_cost' => $total_cost
        ]);

        return $pdo->lastInsertId(); // Retourne l'ID de la réservation insérée
    } catch (PDOException $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        throw new Exception("Erreur dans la base de données : " . $e->getMessage());
    }
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

// Supprimer une réservation
function deleteReservation($reservation_id) { 
    $pdo = connectDB(); 
    $stmt = $pdo->prepare('DELETE FROM reservations WHERE id = ?'); 
    return $stmt->execute([$reservation_id]); 
}

// Supprimer une réservation de massage
function deleteMassageReservation($massage_reservation_id) {
    $pdo = connectDB();
    $stmt = $pdo->prepare('DELETE FROM massage WHERE id = ?');
    return $stmt->execute([$massage_reservation_id]);
}

// Supprimer une réservation de restaurant
function deleteRestaurantReservation($restaurant_reservation_id) {
    $pdo = connectDB();
    $stmt = $pdo->prepare('DELETE FROM reservations_restaurant WHERE id = ?');
    return $stmt->execute([$restaurant_reservation_id]);
}
?>
