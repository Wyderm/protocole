<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un compte</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
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

include_once 'nav_bar.html';
?>
<h1>Modifier un compte</h1>
<form method="post" action="modifier_compte.php">
    <label for="email_recherche">Adresse e-mail du compte à modifier :</label>
    <input type="email" id="email_recherche" name="email_recherche" autocomplete="off" require_onced>
    <ul id="result_email" class="recherche" hidden></ul>
    <input type="submit" value="Rechercher">
</form>
<script src="../controller/recherche_mails.js"></script>
</body>
</html>