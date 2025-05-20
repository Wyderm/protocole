<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un compte</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<?php
include 'nav_bar.html';

if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] !== true) {
    header("Location: ../view/connexion.php");
    exit();
}
elseif ($_SESSION['type'] !== 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}
?>

<body>
<h1>Une erreur est survenue. Veuillez réessayer</h1>
</body>
</html>