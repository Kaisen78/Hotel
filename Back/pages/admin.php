<?php
require_once 'user.php';

//Vérifier si l'utilisateur n'est pas connecté ou n'est pas un admin 
if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php'); // Redirige vers la page de connexion si non admin
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Bienvenue dans le tableau de bord, Admin <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
    <a href="logout.php">Se déconnecter</a>
</body>
</html>
