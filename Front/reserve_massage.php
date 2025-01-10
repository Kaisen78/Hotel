<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('C:\MAMP\htdocs\hotel\Back\includes\db.php');

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour réserver un massage.']);
    exit();
}

// Récupérer les données POST
$data = json_decode(file_get_contents('php://input'), true);
$massageType = $data['massageType'] ?? '';

if (empty($massageType)) {
    echo json_encode(['success' => false, 'message' => 'Type de massage invalide.']);
    exit();
}

// Définir les valeurs par défaut pour les colonnes
$description = 'Massage personnalisé'; // Exemple : Ajouter une description générique
$duration = 60; // Exemple : durée par défaut de 60 minutes
$price = 50; // Exemple : prix par défaut

try {
    // Connexion à la base de données
    $pdo = connectDB();

    // Insérer la réservation dans la table "massage"
    $stmt = $pdo->prepare('INSERT INTO massage (utilisateur_id, name, description, duration, price) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$_SESSION['user_id'], $massageType, $description, $duration, $price]);

    // Retourner une réponse JSON en cas de succès
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Enregistrer l'erreur dans les logs et retourner une réponse d'erreur
    error_log("Erreur lors de la réservation du massage : " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la réservation.']);
}
