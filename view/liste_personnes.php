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
    <title>Liste personnes</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<?php
include 'nav_bar.html';
include '../model/liste_personnes_bdd.php';
global $personnes, $groupe;

$ecriture = ecriture_permissions($_SESSION['id']);
?>
<body>
<h1>Liste des personnes</h1>

<div class="flex-container-horizontal not-bordered">
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cherchez parmi les noms">
    <?php if ($ecriture): ?>
        <button onclick="window.location.href='ajouter_personne.php?groupe=<?php echo $groupe ?>'">Ajouter personne
        </button>
    <?php endif; ?>
</div>

<div class="table-container">
    <table class="liste-personnes" id="tableau">
        <tr>
            <th>DENOMINATION</th>
            <th>DIRIGANT/CONTACT</th>
            <th>CATEGORIES</th>
            <th>SOUS-CATEGORIES</th>
            <th>ADRESSE 1</th>
            <th>ADRESSE 2</th>
            <th>CODE POSTAL</th>
            <th>VILLE</th>
            <th>N° TEL</th>
            <th>MAIL</th>
            <?php if ($ecriture): ?>
                <th>Modifier</th>
            <?php endif; ?>
        </tr>
        <?php foreach ($personnes as $personne): ?>
            <tr>
                <td><?php echo $personne['denomination']; ?></td>
                <td><?php echo $personne['dirigant_contact']; ?></td>
                <td><?php echo $personne['categories']; ?></td>
                <td><?php echo $personne['sous_categories']; ?></td>
                <td><?php echo $personne['adresse1']; ?></td>
                <td><?php echo $personne['adresse2']; ?></td>
                <td><?php echo $personne['code_postal']; ?></td>
                <td><?php echo $personne['ville']; ?></td>
                <td><?php echo $personne['tel']; ?></td>
                <td><?php echo $personne['mail']; ?></td>
                <?php
                $id = $personne['id'];
                if ($ecriture): ?>
                    <td>
                        <button onclick="window.location.href='modifier_personne.php?id=<?php echo $id; ?>'">Modifier
                        </button>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script src="../controller/recherche_nom.js"></script>
</body>
</html>