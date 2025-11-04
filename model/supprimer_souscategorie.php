<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}
if (empty($_POST['id']) || empty($_POST['sous_categorie'])) {
    header("Location: ../view/choisir_groupe.php");
    exit();
}

include_once "connexion_pdo.php";
global $db;

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$id = strip_tags($id);
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
$souscategorie = filter_input(INPUT_POST, 'sous_categorie');
$souscategorie = strip_tags($souscategorie);
$souscategorie = htmlspecialchars($souscategorie, ENT_QUOTES, 'UTF-8');

$stmt = $db->prepare("SELECT * FROM souscategories WHERE nom = :souscategorie");
$stmt->execute(array(
    'souscategorie' => $souscategorie
));
$souscategorie_id = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $db->prepare("DELETE FROM personne_souscategories WHERE id_personne = :id AND id_souscategories = :souscategorie_id");
$stmt->execute(array(
    'id' => $id,
    'souscategorie_id' => $souscategorie_id['id']
));

header("Location: ../view/gerer_souscategorie.php?id=$id");