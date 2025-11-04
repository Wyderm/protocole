<?php

if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}
if ($_SESSION['type'] == 'admin') {
    header("Location: ../view/hub_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil utilisateur</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
include_once 'nav_bar.html';
?>
<h1>Gestion protocole</h1>
<div class="flex-container-vertical border-vertical">
    <h2>Gestion des listes</h2>
    <div class="flex-container-horizontal not-bordered" style="background-color: inherit; width: 80%;">
        <button class="flex-item" onclick="window.location.href='choisir_groupe.php'">Choisir groupe</button>
        <button class="flex-item" onclick="window.location.href='publipostage.php'">Publipostage</button>
    </div>
</div>
</body>
</html>
