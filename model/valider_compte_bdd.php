<?php
include_once "../model/connexion_pdo.php";
global $db;

if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}
elseif ($_SESSION['type'] != 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}

$comptes_non_valides = $db->prepare("SELECT * FROM utilisateur WHERE valide = false AND account_activation_hash IS NULL");
$comptes_non_valides->execute();
$comptes = $comptes_non_valides->fetchAll(PDO::FETCH_ASSOC);
