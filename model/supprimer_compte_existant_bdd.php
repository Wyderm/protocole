<?php

if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] !== true) {
    header("Location: ../view/connexion.php");
    exit();
} elseif ($_SESSION['type'] !== 'admin') {
    header("Location: ../view/hub_admin.php");
    exit();
} elseif (empty($_GET['id'])) {
    header("Location: ../view/valider_compte.php");
    exit();
}

include_once "connexion_pdo.php";
global $db;

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id = strip_tags($id);
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

if ($id == $_SESSION['id']) {
    // L'utilisateur essaie de supprimer son propre compte
    header("Location: ../view/erreur_suppression.php");
    exit();
}

$stmt = $db->prepare("UPDATE utilisateur SET supprime = true WHERE id_compte = :id_compte");
$stmt->execute(array('id_compte' => $id));

if ($stmt->rowCount() > 0) {
    // Suppression réussie
    header("Location: ../view/form_modifier_compte.php");
} else {
    // Erreur lors de la suppression
    header("Location: ../view/erreur_suppression.php");
}
