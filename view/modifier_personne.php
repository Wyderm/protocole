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
    <title>Modifier personne</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<?php
include 'nav_bar.html';
include '../model/get_personne_by_id.php';
global $personne, $sous_categories;

$id_personne = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_personne = strip_tags($id_personne);
$id_personne = htmlspecialchars($id_personne, ENT_QUOTES, 'UTF-8');

include '../model/gestion_permissions.php';
redirect_personne($id_personne);
$ecriture = ecriture_permissions($_SESSION['id']);
if (!$ecriture) {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}
?>
<body>
<h1>Modifier une personne</h1>
<div class="flex-container-vertical">
    <form action="../model/modifier_personne_bdd.php" method="post">
        <input type="hidden" name="id" value="<?php echo $personne['id']; ?>">
        <label for="denomination">Dénomination :</label>
        <input type="text" id="denomination" name="denomination"
               placeholder="<?php echo $personne['denomination']; ?>">

        <label for="dirigant_contact">Dirigant/Contact :</label>
        <input type="text" id="dirigant_contact" name="dirigant_contact"
               placeholder="<?php echo $personne['dirigant_contact']; ?>">

        <label for="categorie">Catégorie :</label>
        <input type="text" id="categorie" name="categorie"
               placeholder="<?php echo $personne['categories']; ?>">

        <label for="sous_categories">Sous-catégories :</label>
        <input type="text" id="sous_categories" name="sous_categories"
               placeholder="<?php echo $personne['sous_categories']; ?>">

        <label for="adresse1">Adresse 1 :</label>
        <input type="text" id="adresse1" name="adresse1"
               placeholder="<?php echo $personne['adresse1']; ?>">

        <label for="adresse2">Adresse 2 :</label>
        <input type="text" id="adresse2" name="adresse2"
               placeholder="<?php echo $personne['adresse2']; ?>">

        <label for="code_postal">Code postal :</label>
        <input type="text" id="code_postal" name="code_postal"
               placeholder="<?php echo $personne['code_postal']; ?>">

        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" placeholder="<?php echo $personne['ville']; ?>">

        <label for="tel">N° Tel :</label>
        <input type="text" id="tel" name="tel" placeholder="<?php echo $personne['tel']; ?>">

        <label for="mail">Mail :</label>
        <input type="email" id="mail" name="mail" placeholder="<?php echo $personne['mail']; ?>">
        <input type="submit" value="Modifier">
    </form>
    <button id="refuser" onclick="window.location.href='supprimer_personne.php?id=<?php echo $id_personne ?>'">
        Supprimer
    </button>
</div>
</body>
</html>