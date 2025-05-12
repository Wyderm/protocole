<?php
include "connexion_pdo.php";
global $db;

if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] !== true) {
    header("Location: ../view/connexion.php");
    exit();
} elseif ($_SESSION['type'] !== 'admin') {
    header("Location: ../view/creer_compte.php");
    exit();
} elseif (!isset($_GET['id'])) {
    header("Location: ../view/valider_compte.php");
    exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id = strip_tags($id);
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

// Supprimer le compte
$supprimer_compte = $db->prepare("DELETE FROM utilisateur WHERE id_compte = :id_compte");
$supprimer_compte->execute(array('id_compte' => $id));

header("Location: ../view/valider_compte.php");