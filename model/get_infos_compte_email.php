<?php
include_once_once "connexion_pdo.php";
global $db;

if (!isset($_SESSION)) {
    session_start();
}
elseif ($_SESSION['type'] != 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}

if (!isset($_POST['email_recherche'])) {
    echo "<p class='centered'>Veuillez rentrer une adresse e-mail.</p>";
    exit();
}
$email_recherche = filter_input(0, 'email_recherche', FILTER_SANITIZE_EMAIL);
$email_recherche = strip_tags($email_recherche);
$email_recherche = htmlspecialchars($email_recherche, ENT_QUOTES, 'UTF-8');

// Vérifier si l'adresse e-mail existe dans la base de données
$stmt = $db->prepare("SELECT * FROM utilisateur WHERE email = :email");
$stmt->execute(array(
    'email' => $email_recherche
));
$infos = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$infos) {
    echo "<p class='centered'>Aucun compte trouvé avec cette adresse e-mail.</p>";
    exit();
}

$id_utilisateur = $infos['id_compte'];


