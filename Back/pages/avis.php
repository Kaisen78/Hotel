<?php
require_once('../includes/db.php');

// Ajouter un avis
function addReview($utilisateur_id, $contenu) {
    $b = connectDB();
    $a = $b->prepare('INSERT INTO avis (utilisateur_id, contenu, date_creation) VALUES (?, ?, NOW())');
    $a->execute([$utilisateur_id, $contenu]);
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
    $a = $b->query('SELECT 
            avis.contenu, 
            avis.date_creation, 
            utilisateurs.pseudo 
        FROM avis 
        INNER JOIN utilisateurs 
        ON avis.utilisateur_id = utilisateurs.id 
        ORDER BY avis.date_creation DESC');
    return $a->fetchAll(PDO::FETCH_ASSOC);
}

// Supprimer un avis
function deleteReview($reviewId) {
    $b = connectDB();
    $a = $b->prepare('DELETE FROM avis WHERE id = ?');
    $a->execute([$reviewId]);
    return $a->rowCount();
}

// Gérer les requêtes POST pour ajouter un avis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    session_start();


    // Récupérer les données de la requête AJAX
    $data = json_decode(file_get_contents('php://input'), true);
    $utilisateur_id = $_SESSION['utilisateur_id'];
    $contenu = $data['contenu'] ?? '';

    // Valider le contenu
    if (empty($contenu)) {
        echo json_encode(['success' => false, 'message' => 'Le contenu est requis.']);
        exit();
    }

    // Ajouter l'avis
    if (addReview($utilisateur_id, $contenu)) {
        echo json_encode(['success' => true, 'message' => 'Avis ajouté avec succès.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'avis.']);
    }
    exit();
}
