<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}
if (empty($_POST['groupe'])) {
    header("Location: ../view/choisir_groupe.php");
    exit();
}

$groupe = filter_input(INPUT_POST, 'groupe');
$groupe = strip_tags($groupe);
$groupe = htmlspecialchars($groupe, ENT_QUOTES, 'UTF-8');

include 'gestion_permissions.php';
redirectGroupe($groupe);

include 'connexion_pdo.php';
global $db;

$stmt = $db->prepare("SELECT denomination, dirigant_contact, categories, sous_categories, adresse1, adresse2, code_postal, ville, tel, mail, personne.id FROM personne JOIN main.groupe g on personne.id_groupe = g.id WHERE g.nom = :groupe");
$stmt->execute(array(
    'groupe' => $groupe
));
$personnes = $stmt->fetchAll(PDO::FETCH_ASSOC);
