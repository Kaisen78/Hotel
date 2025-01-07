<?php
require_once 'user.php';

// Vérifier si les données de l'utilisateur sont correctes pour se connnecter
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['mot_de_passe'];

    if (loginUser($email, $password)) {
        // Redirection selon le rôle
        if (isAdmin()) {
            header('Location: admin.php'); // Redirige vers le tableau de bord admin
        } else {
            header('Location: accueil.php'); // Redirige vers la page utilisateur normale
        }
        exit();
    } else {
        echo 'Email ou mot de passe incorrect.';
    }
}
?>
