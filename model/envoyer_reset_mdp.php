<?php
if (!isset($_POST['email'])) {
    header("Location: ../view/connexion.php");
    exit();
}

$email = filter_input(0, 'email', FILTER_SANITIZE_EMAIL);
$email = strip_tags($email);
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

$token = bin2hex(random_bytes(16));
$token_hash = hash('sha256', $token);
$expiration = date('Y-m-d H:i:s', time() + 60 * 15);

include "connexion_pdo.php";
global $db;

$stmt = $db->prepare("UPDATE utilisateur SET reset_token_hash = :token, reset_token_expiration = :expiration WHERE email = :email");
$stmt->execute(array(
    'token' => $token_hash,
    'expiration' => $expiration,
    'email' => $email
));

if ($stmt->rowCount() > 0) {
    // Envoi de l'email
    $mail = require __DIR__ . "/mailer.php";

    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    $mail->setFrom("stagiaire-dev@ville-saint-saulve.fr", "Mairie de Saint-Saulve");
    $mail->addAddress($email);
    $mail->Subject = "Réinitialisation de mot de passe";
    $mail->Body = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : <a href='http://localhost:63342/protocole/view/reset_password.php?token=" . urlencode($token) . "'>Réinitialiser le mot de passe</a>";


    $mail->SMTPDebug = 0; // Activer le mode debug (0 pour désactiver)
    $mail->Timeout = 10; // Timeout en secondes

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
        exit();
    }
}

echo "Un email a été envoyé à $email avec un lien pour réinitialiser votre mot de passe.";