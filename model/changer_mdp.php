<?php
if (!isset($_POST['password'])) {
    header("Location: ../view/reset_password.php");
    exit();
}
include_once_once "../model/connexion_pdo.php";
global $db;


if (!empty($_POST['token'])) {
    $token = filter_input(0, 'token');
    $token = strip_tags($token);
    $token = htmlspecialchars($token, ENT_QUOTES, 'UTF-8');
}
else {
    echo "<h1>Token invalide, veuillez réessayer.</h1>";
    echo ">Connexion</button>";
    exit();
}

$stmt = $db->prepare("SELECT * FROM utilisateur WHERE reset_token_hash = :token");
$stmt->execute(array(
    'token' => hash('sha256', $token)
));
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user === false) {
    echo "<h1>Token introuvable, veuillez réessayer.</h1>";
    echo ">Connexion</button>";
    exit();
}
if (strtotime($user['reset_token_expiration']) < time()) {
    echo "<h1>Le lien de réinitialisation a expiré, veuillez demander un nouveau lien.</h1>";
    echo ">Connexion</button>";
    exit();
}

$password = filter_input(0, 'password');
$password = strip_tags($password);
$password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

$confirm_password = filter_input(0, 'confirm_password');
$confirm_password = strip_tags($confirm_password);
$confirm_password = htmlspecialchars($confirm_password, ENT_QUOTES, 'UTF-8');

if (empty($password) || empty($confirm_password)) {
    echo "<h1>Veuillez remplir tous les champs.</h1>";
    echo "<button onclick=\"window.location.reload()\">Rafraîchir</button>";
    exit();
}

if ($password !== $confirm_password) {
    echo "<h1>Les mots de passe ne correspondent pas.</h1>";
    echo "<button onclick=\"window.location.reload()\">Rafraîchir</button>";
    exit();
}

if (strlen($password) < 15 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
    echo "<h1>Le mot de passe doit contenir au moins 15 caractères, une majuscule, une minuscule, un chiffre et un symbole.</h1>";
    echo "<button onclick=\"window.location.reload()\">Rafraîchir</button>";
    exit();
}

$stmt = $db->prepare("UPDATE utilisateur SET password = :password, reset_token_hash = NULL, reset_token_expiration = NULL WHERE reset_token_hash = :token");
$stmt->execute(array(
    'password' => password_hash($password, PASSWORD_BCRYPT),
    'token' => hash('sha256', $token)
));
if ($stmt->rowCount() > 0) {
    echo "<h1>Mot de passe réinitialisé avec succès.</h1>";
    echo ">Se connecter</button>";
} else {
    echo "<h1>Erreur lors de la réinitialisation du mot de passe.</h1>";
    echo ">Connexion</button>";
}
