<?php

if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}

include_once_once "connexion_pdo.php";
global $db;

if (empty($_GET['id'])) {
    header("Location: ../view/choisir_groupe.php");
    exit();
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id = strip_tags($id);
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

$stmt = $db->prepare("SELECT * FROM personne WHERE id = :id");
$stmt->execute(array(
    'id' => $id
));
$personne = $stmt->fetch(PDO::FETCH_ASSOC);

$groupe = $db->prepare("SELECT * FROM groupe WHERE id = :id");
$groupe->execute(array(
    'id' => $personne['id_groupe']
));
$groupe = $groupe->fetch(PDO::FETCH_ASSOC);
