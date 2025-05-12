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
global $personnes;
?>
<body>
<h1>Liste des personnes</h1>
<table class="liste-personnes">
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
        <th>Modifier</th>
    </tr>
    <?php foreach ($personnes as $personne): ?>
        <tr>
            <td><?php echo htmlspecialchars($personne['denomination']); ?></td>
            <td><?php echo htmlspecialchars($personne['dirigant_contact']); ?></td>
            <td><?php echo htmlspecialchars($personne['categorie']); ?></td>
            <td>
                <?php
                $id = $personne['id'];
                $sous_categories = get_souscategories($id);
                foreach ($sous_categories as $category) {
                    echo htmlspecialchars($category['nom']) . "<br>";
                }
                ?>
            </td>
            <td><?php echo htmlspecialchars($personne['adresse1']); ?></td>
            <td><?php echo htmlspecialchars($personne['adresse2']); ?></td>
            <td><?php echo htmlspecialchars($personne['code_postal']); ?></td>
            <td><?php echo htmlspecialchars($personne['ville']); ?></td>
            <td><?php echo htmlspecialchars($personne['tel']); ?></td>
            <td><?php echo htmlspecialchars($personne['mail']); ?></td>
            <td><button onclick="window.location.href='modifier_personne.php?id=<?php echo $id; ?>'">Modifier</button></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>