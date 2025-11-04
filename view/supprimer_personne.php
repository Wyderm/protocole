<?php

if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}
if (empty($_GET['id'])) {
    header("Location: ../view/liste_personnes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer personne</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<?php
include_once 'nav_bar.html';
include_once '../model/get_personne_by_id.php';
global $personne, $groupe;

$id_personne = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_personne = strip_tags($id_personne);
$id_personne = htmlspecialchars($id_personne, ENT_QUOTES, 'UTF-8');

include_once '../model/gestion_permissions.php';
redirect_personne($id_personne);
$ecriture = ecriture_permissions($_SESSION['id']);
if (!$ecriture) {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}

$dirigant_contact = $personne['dirigant_contact'];

echo "<h1>Supprimer la personne $dirigant_contact</h1>";

?>
<br>
<p class="centered"><strong>Voulez-vous vraiment supprimer cette personne dans le groupe <?php echo $groupe['nom'] ?> ?</strong></p><br>
<p class="centered">Cette action est irréversible.</p>
<div class="flex-container-horizontal not-bordered">
    <button onclick="window.location.href='liste_personnes.php'">Annuler</button>
    <button id="refuser" onclick="window.location.href='../model/supprimer_personne_bdd.php?id=<?php echo $id_personne; ?>'">Confirmer</button>
</div>