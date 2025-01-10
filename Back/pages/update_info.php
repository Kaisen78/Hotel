<?php
session_start();
require_once('../includes/db.php');
require_once('../includes/user.php'); // Fichier contenant la fonction updateUserInfo

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connection.html');
    exit();
}

// Vérifiez si la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $username = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['phone'] ?? '';
    $adresse_postale = $_POST['adresse'] ?? '';

    // Validation des données
    if (empty($username) || empty($email) || empty($telephone)) {
        echo "Tous les champs requis doivent être remplis.";
        exit();
    }

    try {
        // Mise à jour des informations utilisateur
        $rowsUpdated = updateUserInfo($userId, $username, $email, $telephone, $adresse_postale);

        if ($rowsUpdated > 0) {
            // Mettre à jour les données de session
            $_SESSION['username'] = $username;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_phone'] = $telephone;
            $_SESSION['user_address'] = $adresse_postale;

            // Rediriger avec un message de succès
            header('Location: mon_compte.php?success=1');
            exit();
        } else {
            echo "Aucune mise à jour effectuée.";
        }
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour des informations utilisateur : " . $e->getMessage());
        echo "Erreur lors de la mise à jour.";
    }
} else {
    echo "Requête invalide.";
    exit();
}
