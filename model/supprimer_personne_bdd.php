<?php

if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}

if (empty($_GET['id'])) {
    header("Location: ../view/choisir_groupe.php");
    exit();
} else {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $id = strip_tags($id);
    $id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
}

include '../model/gestion_permissions.php';
redirect_personne($id);
$ecriture = ecriture_permissions($_SESSION['id']);
if (!$ecriture) {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}

include 'connexion_pdo.php';
global $db;

$stmt = $db->prepare("DELETE FROM personne WHERE id = :id");
$stmt->execute(array(
    'id' => $id
));

header("Location: ../view/choisir_groupe.php");