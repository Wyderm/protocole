<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] !== true) {
    header("Location: ../view/connexion.php");
    exit();
}
if ($_SESSION['type'] != 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}



$groupe = filter_input(INPUT_POST, 'groupe');
$groupe = strip_tags($groupe);
$groupe = htmlspecialchars($groupe, ENT_QUOTES, 'UTF-8');

$texte_mail = filter_input(INPUT_POST, 'mail');
$texte_mail = strip_tags($texte_mail);
$texte_mail = htmlspecialchars($texte_mail, ENT_QUOTES, 'UTF-8');

$objet_mail = filter_input(INPUT_POST, 'objet');
$objet_mail = strip_tags($objet_mail);
$objet_mail = htmlspecialchars($objet_mail, ENT_QUOTES, 'UTF-8');

include_once_once 'gestion_permissions.php';
redirectGroupe($groupe);

if (isset($_POST['personnes']) && is_array($_POST['personnes'])) {
    $personnes = filter_var_array($_POST['personnes'], FILTER_SANITIZE_NUMBER_INT);
} else {
    header("Location: hub_admin.php");
}

include_once_once 'connexion_pdo.php';
global $db;

$stmt = $db->prepare("SELECT * FROM personne WHERE id = :id");
foreach ($personnes as $personne) {
    $stmt->execute([':id' => $personne]);
    $personneData = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($personneData) {
        $lespersonnes[] = $personneData;
    }
}

$mail = require_once_once __DIR__ . "/mailer.php";

$mail_erreur = [];

$mail->CharSet = 'UTF-8';
$mail->isHTML(true);
$mail->setFrom("stagiaire-dev@ville-saint-saulve.fr", "Mairie de Saint-Saulve");
$mail->Subject = "$objet_mail";
$mail->Body = $texte_mail;

foreach ($lespersonnes as $personne) {
    $email = $personne['mail'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail->addAddress($email);
    } else {
        $mail_erreur[] = $email; // Stocke les adresses invalides
    }
}

$mail->SMTPDebug = 0; // Activer le mode debug (0 pour désactiver)
$mail->Timeout = 10; // Timeout en secondes

try {
    $mail->send();
} catch (Exception $e) {
    echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    exit();
}

if (!empty($mail_erreur)) {
    $erreurs = urlencode(json_encode($mail_erreur));
    header("Location: ../view/erreur_envoi_email.php?erreurs=$erreurs");
    exit();
}

header("Location: ../view/hub_admin.php");
