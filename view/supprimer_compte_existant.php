<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un compte</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<?php
if (!isset($_SESSION)) {
    session_start();
}
elseif ($_SESSION['type'] != 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}
include 'nav_bar.html';
include "../model/get_utilisateur_by_id.php";
global $compte;

$id_utilisateur = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id_utilisateur = strip_tags($id_utilisateur);
$id_utilisateur = htmlspecialchars($id_utilisateur, ENT_QUOTES, 'UTF-8');

$email = $compte['email'];
?>
<body>
<h1>Supprimer le compte de <?php echo htmlspecialchars($email); ?></h1>
<div class="center-vertical">
    <h1>Voulez-vous vraiment supprimer ce compte ?</h1>
    <div class="flex-container-horizontal not-bordered">
        <button onclick="window.location.href='form_modifier_compte.php'">Annuler</button>
        <button id="refuser" onclick="window.location.href='../model/supprimer_compte_existant_bdd.php?id=<?php echo $id_utilisateur; ?>'">Confirmer</button>
    </div>
    <p class="centered">Cette action est irréversible.</p>
</div>
</body>
</html>
