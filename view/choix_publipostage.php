<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] !== true) {
    header("Location: connexion.php");
    exit();
}

include '../model/get_all_groupes.php';
$id = $_SESSION['id'];
$groupes = getGroupesUtilisateur($id);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Publipostage</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
include 'nav_bar.html';
?>
<h1>Choix publipostage</h1>
</body>
<div class="flex-container-horizontal" style="justify-content: space-around">
    <button onclick="window.location.href='publipostage.php?type=etiquette'">Etiquette</button>
    <button onclick="window.location.href='publipostage.php?type=courrier'">Courrier</button>
</div>
</html>