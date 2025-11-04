<?php
include_once "../model/connexion_pdo.php";
include_once "../model/get_utilisateur_by_id.php";
global $db, $compte;
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] !== true) {
    header("Location: ../view/connexion.php");
    exit();
}
elseif ($_SESSION['type'] !== 'admin') {
    header("Location: ../view/creer_compte.php");
    exit();
}
elseif ($_GET['id'] == null) {
    header("Location: ../view/valider_compte.php");
    exit();
}


$id = $compte['id_compte'];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Valider un compte</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
include_once 'nav_bar.html';
?>
<h1>Valider le compte de <?php echo htmlspecialchars($compte['username']); ?> :</h1>
<div class="flex-container-horizontal not-bordered">
    <button id="refuser" onclick="window.location.href='../model/verif_valider_bdd.php?type=admin&id=<?php echo $id; ?>'">Valider en tant qu'administrateur</button>
    <button onclick="window.location.href='../model/verif_valider_bdd.php?type=lecteur&id=<?php echo $id; ?>'">Valider en lecture</button>
    <button onclick="window.location.href='../model/verif_valider_bdd.php?type=user&id=<?php echo $id; ?>'">Valider en lecture et écriture</button>
    <button onclick="window.location.href='valider_compte.php'">Annuler</button>
</div>
<p class="centered">Si vous annulez, vous pourrez quand même choisir de valider le compte plus tard.</p>
</body>
</html>
