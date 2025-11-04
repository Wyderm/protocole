<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation mot de passe</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<form id="mdp_oublie" method="post" action="../model/envoyer_reset_mdp.php">
    <h1>Réinitialisation de mot de passe</h1>
    <label for="email">Entrez votre adresse email :</label>
    <input type="email" id="email" name="email" require_onced>
    <button type="submit">Envoyer le lien de réinitialisation</button>
</form>
<div id="response-container"></div>
<script src="../controller/mdp_oublie.js"></script>
</body>
</html>
