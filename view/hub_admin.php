<?php

if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
} elseif ($_SESSION['type'] != 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil administrateur</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
include_once 'nav_bar.html';
?>
<h1>Gestion protocole</h1>
<div class="flex-container-horizontal div-admin">
    <div class="flex-item flex-container-vertical">
        <h2>Gestion des listes</h2>
        <button class="flex-item" onclick="window.location.href='choisir_groupe.php'">Choisir groupe</button>
        <button onclick="window.location.href='publipostage.php'">Publipostage</button>
        <button onclick="window.location.href='choix_groupe_mail.php'">Email</button>
    </div>
    <div class="flex-item flex-container-vertical">
        <h2>Gestion des comptes</h2>
        <button class="flex-item" onclick="window.location.href='valider_compte.php'">Valider un compte</button>
        <button class="flex-item" onclick="window.location.href='creer_compte.php'">Créer un compte</button>
        <button class="flex-item" onclick="window.location.href='form_modifier_compte.php'">Modifier un compte</button>
    </div>
</div>
</body>
</html>
