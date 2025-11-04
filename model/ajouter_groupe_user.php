<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}
if ($_SESSION['type'] != 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}

include_once_once 'connexion_pdo.php';
global $db;

if (empty($_POST['id']) || empty($_POST['groupe'])) {
    header('Location: ../view/hub_admin.php');
    exit();
}

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$id = strip_tags($id);
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
$groupe = filter_input(INPUT_POST, 'groupe');
$groupe = strip_tags($groupe);
$groupe = htmlspecialchars($groupe, ENT_QUOTES, 'UTF-8');

$stmt = $db->prepare("INSERT INTO utilisateur_groupe (id_utilisateur, id_groupe)  VALUES (:id_utilisateur, :id_groupe)");
$stmt->execute(array(
    ':id_utilisateur' => $id,
    ':id_groupe' => $groupe
));

header('Location: ../view/gerer_groupes.php?id=' . $id);
