<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<h1>Connexion</h1>
<form action="../model/connexion_bdd.php" method="post">
    <label for="username">Nom d'utilisateur :</label><br>
    <input type="text" id="username" name="username" require_onced>
    <br><br>
    <label for="password">Mot de passe :</label><br>
    <input type="password" id="password" name="password" require_onced>
    <br><br>
    <div class="connexion_submit">
        <a href="mdp_oublie.php" style="width: 25%;">Mot de passe oublié ?</a>
        <input type="submit" value="Se connecter" style="width: 50%">
        <a href="creer_compte.php" style="width: 25%;">Créer un compte</a>
    </div>
</form>
</body>
</html>