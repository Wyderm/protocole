<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['type']) && $_SESSION['type'] == 'admin') {
    include 'nav_bar.html';
}
if (isset($_SESSION['valide']) && $_SESSION['valide'] && $_SESSION['type'] != 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}

include '../model/get_all_groupes.php';
$groupes = getAllGroupes();
?>
<h1>Créer un compte</h1>
<form method="post" action="../model/creer_compte_bdd.php">
    <label for="username">Nom d'utilisateur :</label><br>
    <input type="text" id="username" name="username" required>
    <br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" id="password" name="password" required
           title="Doit contenir 15 caractères, une majuscule, une minuscule, un chiffre et un symbole">
    <p id="message" hidden>Doit contenir 15 caractères, une majuscule, une minuscule, un chiffre et un symbole</p>
    <br><br>

    <label for="confirm_password">Confirmer le mot de passe :</label><br>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <br><br>

    <label for="email">Email :</label><br>
    <input type="email" id="email" name="email" required>
    <br><br>

    <label for="groupes">Groupes à modifier :</label><br>
    <select id="groupes" name="groupes[]" multiple required>
        <?php foreach ($groupes as $groupe): ?>
            <option value="<?= htmlspecialchars($groupe['id']) ?>"><?= htmlspecialchars($groupe['nom']) ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit" id="submit" value="Créer un compte">
</form>

<script src="../controller/mdp_verif.js"></script>
</body>
</html>