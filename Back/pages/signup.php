<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once('../includes/db.php');
require_once('user.php'); // Inclure le fichier où les fonctions sont définies

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['pseudo'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $password = $_POST['motdepasse'];
    $role = 'user';

    if (registerUser($username, $email, $password, $telephone, $adresse, $role)) {
        // Rediriger vers la page de connexion après une inscription réussie
        header("Location: /Hotel/front/connection.html");
        exit();
    } else {
        // Afficher un message d'erreur si l'inscription échoue
        echo "Une erreur est survenue lors de l'inscription.";
    }
}
?>
