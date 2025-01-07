<?php
require_once('db.php');

// Ajouter un avis
function addReview($utilisateur_id, $commentaire, $note) {
    $b = connectDB();
    $a = $b->prepare('INSERT INTO avis (utilisateur_id, commentaire, note) VALUES (?, ?, ?)');
    $a->execute([$utilisateur_id, $commentaire, $note]);
    return $b->lastInsertId();
}

// Afficher les avis de l'utilisateur
function getUserReviews($utilisateur_id) {
    $b = connectDB();
    $a = $b->prepare('SELECT * FROM avis WHERE utilisateur_id = ?');
    $a->execute([$utilisateur_id]);
    return $a->fetchAll(PDO::FETCH_ASSOC);
}

// Afficher toutes les avis
function getAllReviews() {
    $b = connectDB();
    $a = $b->query('SELECT * FROM avis');
    return $a->fetchAll(PDO::FETCH_ASSOC);
}

// Supprimer un avis
function deleteReview($reviewId) {
    $b = connectDB();
    $a = $b->prepare('DELETE FROM avis WHERE id = ?');
    $a->execute([$reviewId]);
    return $a->rowCount();
}

?>
