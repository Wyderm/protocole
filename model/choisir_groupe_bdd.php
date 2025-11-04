<?php
include_once 'connexion_pdo.php';
global $db;

if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}

$id_utilisateur = $_SESSION['id'];

$stmt = $db->prepare("SELECT nom FROM groupe join main.utilisateur_groupe ug on groupe.id = ug.id_groupe WHERE ug.id_utilisateur = :id_utilisateur");
$stmt->execute(array(
    'id_utilisateur' => $id_utilisateur
));
$groupes = $stmt->fetchAll(PDO::FETCH_ASSOC);

