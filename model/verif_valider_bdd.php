<?php
include_once "connexion_pdo.php";
global $db;
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] !== true) {
    header("Location: ../view/connexion.php");
    exit();
} elseif ($_SESSION['type'] !== 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
} elseif (!isset($_GET['id']) || !isset($_GET['type'])) {
    header("Location: ../view/valider_compte.php");
    exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id = strip_tags($id);
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

if ($_GET['type'] === 'user') {
    // Valider le compte
    $stmt = $db->prepare("UPDATE utilisateur SET valide = true, type= 'user' WHERE id_compte = :id");
    $stmt->execute(array(
        'id' => $id
    ));
} elseif ($_GET['type'] === 'admin') {
    // Valider le compte
    $stmt = $db->prepare("UPDATE utilisateur SET valide = true, type = 'admin' WHERE id_compte = :id");
    $stmt->execute(array(
        'id' => $id
    ));
} elseif ($_GET['type'] === 'lecteur') {
    // Valider le compte
    $stmt = $db->prepare("UPDATE utilisateur SET valide = true, type = 'lecteur' WHERE id_compte = :id");
    $stmt->execute(array(
        'id' => $id
    ));
}

header("Location: ../view/valider_compte.php");