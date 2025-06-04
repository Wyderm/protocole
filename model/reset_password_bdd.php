<?php
include "../model/connexion_pdo.php";
global $db;

if (!empty($_GET['token'])) {
    $token = filter_input(INPUT_GET, 'token');
    $token = strip_tags($token);
    $token = htmlspecialchars($token, ENT_QUOTES, 'UTF-8');
} else {
    header("Location: ../view/reset_password.php");
    exit();
}

$stmt = $db->prepare("SELECT * FROM utilisateur WHERE reset_token_hash = :token");
$stmt->execute(array(
    'token' => hash('sha256', $token)
));
$user = $stmt->fetch(PDO::FETCH_ASSOC);

