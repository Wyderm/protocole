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
    <title>Choisir groupe</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
include 'nav_bar.html';
include '../model/choisir_groupe_bdd.php';
global $groupes;
?>

<h1>Choisir un groupe</h1>
<form action="liste_personnes.php" method="post">
    <label for="groupe">Sélectionnez un groupe :</label>
    <select id="groupe" name="groupe">
        <?php foreach ($groupes as $groupe): ?>
            <option value="<?php echo htmlspecialchars($groupe['nom']); ?>"><?php echo htmlspecialchars($groupe['nom']); ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="Choisir le groupe">
</form>
</body>
</html>
