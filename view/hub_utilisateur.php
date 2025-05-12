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
    <title>Accueil utilisateur</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
include 'nav_bar.html';
?>
<h1>Protocole</h1>
<div class="flex-container-horizontal">
    <div class="flex-item flex-container-vertical">
        <h2></h2>
    </div>
</div>
</body>
</html>
