<?php
if (empty($_POST['token'])) {
    header('Location: ../view/connexion.php');
    exit();
}
$token = filter_input(0, 'token');
$token = strip_tags($token);
$token = htmlspecialchars($token);

$token_hash = hash('sha256', $token);

include_once 'connexion_bdd.php';
global $db;

$stmt = $db->prepare("SELECT id_compte FROM utilisateur WHERE account_activation_hash = :token_hash");
$stmt->execute(array(
    "token_hash" => $token_hash
));
$id = $stmt->fetch(PDO::FETCH_ASSOC);

if ($id) {
    $stmt = $db->prepare("UPDATE utilisateur SET account_activation_hash = NULL WHERE id_compte = :id_compte");
    $stmt->execute(array(
        "id_compte" => $id['id_compte']
    ));
    header('Location: ../view/attente_validation.html');
} else {
    header('Location: ../view/erreur_connexion.html');
}
