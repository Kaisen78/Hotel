<?php
// Afficher les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure la logique backend
require_once('C:/MAMP/htdocs/hotel/Back/pages/reservation.php'); // Assurez-vous que ce chemin est correct

// Toujours définir le type de contenu JSON
header('Content-Type: application/json');

// Démarrer un bloc pour capturer les erreurs
try {
    // Logs pour démarrer le script
    error_log("Début du script create_reservation.php");

    // Vérifier si la requête est bien une requête POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Méthode non autorisée. Utilisez POST.");
    }

    // Récupération des données POST
    error_log("Données POST reçues : " . json_encode($_POST));

    $utilisateur_id = 1; // À remplacer par l'ID de l'utilisateur connecté (par exemple via session)
    $type_chambre = $_POST['type_chambre'] ?? null;
    $selectedDates = $_POST['selectedDates'] ?? '[]'; // JSON attendu pour selectedDates
    $adults = $_POST['adults'] ?? 0;
    $children = $_POST['children'] ?? 0;
    $total_cost = $_POST['totalCost'] ?? 0;

    // Décoder selectedDates
    $dates = json_decode($selectedDates, true);
    if (!is_array($dates) || empty($dates)) {
        throw new Exception("Les dates sélectionnées sont invalides ou manquantes.");
    }

    // Logs pour les dates
    error_log("Dates décodées : " . json_encode($dates));

    // Extraire date début et date fin, et convertir au format MySQL
    $date_debut = date('Y-m-d', strtotime($dates[0]));
    $date_fin = date('Y-m-d', strtotime(end($dates)));

    // Valider les dates
    if (!$date_debut || !$date_fin || !strtotime($date_debut) || !strtotime($date_fin)) {
        throw new Exception("Les dates fournies ne sont pas valides.");
    }

    // Valider les autres paramètres
    if (!$type_chambre || $adults < 1 || $total_cost <= 0) {
        throw new Exception("Données manquantes ou invalides (type_chambre, adults, totalCost).");
    }

    // Logs pour la validation réussie
    error_log("Validation des données réussie.");

    // Appeler la fonction de création de réservation
    $reservation_id = createReservation($utilisateur_id, $type_chambre, $date_debut, $date_fin, $adults, $children, $total_cost);

    if (!$reservation_id) {
        throw new Exception("Erreur lors de l'insertion en base de données.");
    }

    // Succès
    error_log("Réservation réussie. ID : $reservation_id");
    echo json_encode(['success' => true, 'reservation_id' => $reservation_id]);

} catch (Exception $e) {
    // Capturer et enregistrer les erreurs
    error_log("Erreur dans create_reservation.php : " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
