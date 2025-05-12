<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] !== true) {
    header("Location: connexion.php");
    exit();
} elseif ($_SESSION['type'] !== 'admin') {
    header("Location: creer_compte.php");
    exit();
}
if (!isset($_GET['id'])) {
    header("Location: liste_arretes.php");
    exit();
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id = strip_tags($id);
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Refuser un compte</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
include 'nav_bar.html';
?>
<div class="center-vertical">
    <h1>Voulez-vous vraiment refuser ce compte ?</h1>
    <div class="flex-container-horizontal not-bordered">
        <button onclick="window.location.href='valider_compte.php'">Annuler</button>
        <button id="refuser" onclick="window.location.href='../model/supprimer_compte_bdd.php?id=<?php echo $id; ?>'">Confirmer</button>
    </div>
    <p class="centered">Cette action est irréversible.</p>
</div>
</body>
</html>