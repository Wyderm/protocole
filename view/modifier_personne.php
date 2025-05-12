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
?>
<body>
<h1>Modifier une personne</h1>
<form action="../model/modifier_personne_bdd.php" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($personne['id']); ?>">
    <label for="denomination">Dénomination :</label>
    <input type="text" id="denomination" name="denomination"
           placeholder="<?php echo htmlspecialchars($personne['denomination']); ?>">

    <label for="dirigant_contact">Dirigant/Contact :</label>
    <input type="text" id="dirigant_contact" name="dirigant_contact"
           placeholder="<?php echo htmlspecialchars($personne['dirigant_contact']); ?>">

    <label for="categorie">Catégorie :</label>
    <input type="text" id="categorie" name="categorie"
           placeholder="<?php echo htmlspecialchars($personne['categorie']); ?>">

    <label for="sous_categories">Sous-catégories :</label>
    <?php foreach ($sous_categories as $category) {
        echo $category['nom'] . "<br>";
    }
    ?>
    <button id="sous_categories" type="button" onclick="window.location.href='gerer_souscategorie.php?id=<?php echo urlencode($personne['id'])?>'">Gestion</button>

    <label for="adresse1">Adresse 1 :</label>
    <input type="text" id="adresse1" name="adresse1"
           placeholder="<?php echo htmlspecialchars($personne['adresse1']); ?>">

    <label for="adresse2">Adresse 2 :</label>
    <input type="text" id="adresse2" name="adresse2"
           placeholder="<?php echo htmlspecialchars($personne['adresse2']); ?>">

    <label for="code_postal">Code postal :</label>
    <input type="text" id="code_postal" name="code_postal"
           placeholder="<?php echo htmlspecialchars($personne['code_postal']); ?>">

    <label for="ville">Ville :</label>
    <input type="text" id="ville" name="ville" placeholder="<?php echo htmlspecialchars($personne['ville']); ?>">

    <label for="tel">N° Tel :</label>
    <input type="text" id="tel" name="tel" placeholder="<?php echo htmlspecialchars($personne['tel']); ?>">

    <label for="mail">Mail :</label>
    <input type="email" id="mail" name="mail" placeholder="<?php echo htmlspecialchars($personne['mail']); ?>">
    <input type="submit" value="Modifier">
</form>
</body>
</html>