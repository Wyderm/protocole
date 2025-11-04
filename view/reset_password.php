<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le mot de passe</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<?php
include_once '../model/reset_password_bdd.php';
global $user;

if ($user['reset_token_hash'] === null) {
    echo "<h1>Token introuvable, veuillez réessayer.</h1>";
    exit();
}
if (strtotime($user['reset_token_expiration']) < time()) {
    echo "<h1>Le lien de réinitialisation a expiré, veuillez demander un nouveau lien.</h1>";
    exit();
}


?>

<form id="reset_password" method="post" action="../model/changer_mdp.php">
    <h1>Réinitialisation de mot de passe</h1>
    <label for="password">Nouveau mot de passe :</label>
    <input type="password" id="password" name="password" require_onced>
    <p id="message" hidden>Doit contenir 15 caractères, une majuscule, une minuscule, un chiffre et un symbole</p>
    <label for="confirm_password">Confirmer le mot de passe :</label>
    <input type="password" id="confirm_password" name="confirm_password" require_onced>
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
    <input type="submit" id="submit" value="Réinitialiser le mot de passe">
</form>
<div id="response-container"></div>

<script src="../controller/mdp_verif.js"></script>
<script src="../controller/reset_password.js"></script>
</body>
</html>
