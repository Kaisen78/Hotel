<?php
session_start();
require_once('../includes/db.php');
require_once('user.php'); // Inclut la fonction loginUser

header('Content-Type: application/json');

// Vérifiez si la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $motdepasse = trim($_POST['motdepasse'] ?? '');

    // Validation simple des champs
    if (empty($email) || empty($motdepasse)) {
        echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
        exit;
    }

    // Utilisez la fonction loginUser pour vérifier les informations de connexion
    if (loginUser($email, $motdepasse)) {
        // Redirigez en fonction du rôle de l'utilisateur
        if ($_SESSION['role'] === 'admin') {
            echo json_encode(['success' => true, 'redirect' => '/Hotel/Back/pages/administrateur.php']);
        } else {
            echo json_encode(['success' => true, 'redirect' => '/Hotel/front/chambres.html']);
        }
    } else {
        // Retourner un message d'erreur si les identifiants sont incorrects
        echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
    }
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
    exit;
}
