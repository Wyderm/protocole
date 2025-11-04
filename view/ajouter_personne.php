<?php

if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter personne</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<?php
include_once 'nav_bar.html';

if (empty($_GET['groupe'])) {
    header("Location: ../view/liste_personnes.php");
    exit();
}

$groupe = filter_input(INPUT_GET, 'groupe');
$groupe = strip_tags($groupe);
$groupe = htmlspecialchars($groupe, ENT_QUOTES, 'UTF-8');

include_once '../model/gestion_permissions.php';
redirectGroupe($groupe);
$ecriture = ecriture_permissions($_SESSION['id']);
if (!$ecriture) {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}
?>
<body>
<h1>Ajouter une personne au groupe <?php echo $groupe ?></h1>
<form action="../model/ajouter_personne_bdd.php" method="post">
    <input type="hidden" id="groupe" name="groupe" value="<?php echo $groupe ?>">

    <label for="denomination">Dénomination :</label>
    <input type="text" id="denomination" name="denomination" placeholder="Dénomination">

    <label for="dirigant_contact">Dirigant/Contact :</label>
    <input type="text" id="dirigant_contact" name="dirigant_contact" placeholder="Dirigant/Contact">

    <label for="categorie">Catégories :</label>
    <textarea id="categorie" name="categorie" placeholder="Catégorie"></textarea>

    <label for="sous_categories">Sous-catégories :</label>
    <textarea id="sous_categories" name="sous_categories" placeholder="Sous-catégories"></textarea>

    <label for="adresse1">Adresse 1 :</label>
    <input type="text" id="adresse1" name="adresse1" placeholder="Adresse 1">

    <label for="adresse2">Adresse 2 :</label>
    <input type="text" id="adresse2" name="adresse2" placeholder="Adresse 2">

    <label for="code_postal">Code postal :</label>
    <input type="text" id="code_postal" name="code_postal" placeholder="Code postal">

    <label for="ville">Ville :</label>
    <input type="text" id="ville" name="ville" placeholder="Ville">

    <label for="tel">N° Tel :</label>
    <input type="text" id="tel" name="tel" placeholder="Téléphone">

    <label for="mail">Mail :</label>
    <input type="email" id="mail" name="mail" placeholder="E-mail">
    <input type="submit" value="Ajouter">
</form>