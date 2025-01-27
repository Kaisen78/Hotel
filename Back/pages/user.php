<?php
require_once('../includes/db.php');
session_start();

// Enregistrement d'un utilisateur et l'insérer dans la base de données 
function registerUser($username, $email, $password, $telephone, $adresse, $role = 'user') {
    $pdo = connectDB();
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hasher les mots de passe pour augmenter la sécurité
    $stmt = $pdo->prepare('INSERT INTO utilisateurs (pseudo, email, mot_de_passe, telephone, adresse, role) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$username, $email, $hashedPassword, $telephone, $adresse, $role]);
    return $pdo->lastInsertId();
}

// Connexion d'un utilisateur
function loginUser($email, $password) {
    $pdo = connectDB();
    $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE email = ?'); // Vérifier s'il existe dans la base de données
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        // Stocker les informations dans la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['pseudo'];
        $_SESSION['role'] = $user['role']; // Stocke le rôle
        return true;
    }
    return false;
}

// Vérifier si un utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['id']);
}

// Vérifier si l'utilisateur est un administrateur
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Déconnexion
function logoutUser() {
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['pseudo']);
    unset($_SESSION['role']);
}

// Mettre à jour les informations d'un utilisateur
function updateUserInfo($userId, $username, $email, $telephone, $adresse_postale) {
    $pdo = connectDB();
    $stmt = $pdo->prepare('UPDATE utilisateurs SET pseudo = ?, email = ?, telephone = ?, adresse = ? WHERE id = ?');
    $stmt->execute([$username, $email, $telephone, $adresse, $userId]);
    return $stmt->rowCount();
}

?>
