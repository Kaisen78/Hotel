<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../includes/PHPMailer/src/Exception.php');
require_once('../includes/PHPMailer/src/PHPMailer.php');
require_once('../includes/PHPMailer/src/SMTP.php');
require_once('../includes/db.php'); // Inclure le fichier db.php pour la connexion à la base de données

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $sujet = $_POST['sujet'];
    $message = $_POST['message'];
    Contact($nom, $email, $sujet, $message);
    echo "Message bien envoyé!";
}

function Contact($nom, $email, $sujet, $message) {
    $pdo = connectDB();
    $stmt = $pdo->prepare('INSERT INTO contact (nom, email, sujet, message) VALUES (?, ?, ?, ?)');
    
    if ($stmt->execute([$nom, $email, $sujet, $message])) {
        envoyerEmailDeConfirmation($email, $nom);
    } else {
        echo "Erreur: " . $stmt->errorInfo();
    }
}

function envoyerEmailDeConfirmation($email, $nom) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'oby9108@gmail.com'; 
        $mail->Password   = 'kyrm kyvu tkny teey';     
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; 
        
        $mail->CharSet = 'UTF-8'; 
        $mail->setFrom('oby9108@gmail.com', 'Omar');
        $mail->addAddress($email, $nom); 
    
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de réception de votre message';
        $mail->Body    = 'Bonjour ' . $nom . ',<br><br>Nous avons bien reçu votre message et nous vous en remercions. Nous vous contacterons dès que possible.<br><br>Cordialement,<br>L\'équipe';
        
        $mail->send();
    } catch (Exception $e) {
        echo "L'email n'a pas pu être envoyé. Erreur de PHPMailer: {$mail->ErrorInfo}";
    }
}
?>
