<?php
require_once 'user.php';

//Vérifier si l'utilisateur n'est pas connecté  
if (!isLoggedIn()) {
    header('Location: login.php'); // Redirige vers la page de connexion si non connecté
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utilisateur</title>
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
    <a href="logout.php">Se déconnecter</a>
</body>
</html>
