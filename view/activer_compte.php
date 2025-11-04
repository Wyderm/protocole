<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Valider compte</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
if (!isset($_GET['token'])) {
    echo "<h1>Erreur : aucun token trouvé.</h1>";
    echo "<a href='../../../conges/view/connexion.php'>Retour à la page de connexion</a>";
    exit();
}
$token = filter_input(1, 'token');
$token = strip_tags($token);
$token = htmlspecialchars($token);
?>
<h1>Valider votre compte</h1>
<form method="post" action="../model/activer_compte_bdd.php">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <input type="submit" value="Valider">
</form>
