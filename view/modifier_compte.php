<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un compte</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<?php
include 'nav_bar.html';

if (!isset($_SESSION)) {
    session_start();
} elseif ($_SESSION['type'] != 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}

include "../model/get_infos_compte_email.php";
global $infos;

$id_utilisateur = $infos['id_compte'];
$username = $infos['username'];
$email = $infos['email'];
$type = $infos['type'];

?>
<body>
<h1>Modifier le compte de <?php echo htmlspecialchars($email); ?></h1>
<form id="modifier_compte" method="post" action="../model/modifier_compte_bdd.php">
    <input type="hidden" name="id_utilisateur" value="<?php echo htmlspecialchars($id_utilisateur); ?>">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" placeholder="<?php echo htmlspecialchars($username); ?>">

    <label for="email">Adresse e-mail :</label>
    <input type="email" id="email" name="email" placeholder="<?php echo htmlspecialchars($email); ?>">

    <label for="type">Type de compte :</label>
    <select id="type" name="type">
        <option value="admin" <?php if ($type == 'admin') echo 'selected'; ?>>Admin</option>
        <option value="user" <?php if ($type == 'user') echo 'selected'; ?>>Utilisateur</option>
    </select>

    <input type="submit" value="Modifier le compte">
</form>
<div id="response-container" style="display: none"></div>
<div class="flex-container-horizontal not-bordered">
    <button style="margin-top: 0" onclick="window.location.href='gerer_groupes.php?id=<?php echo $id_utilisateur ?>'">Groupes modifiables</button>
    <button style="margin-top: 0" id="refuser" onclick="window.location.href='supprimer_compte_existant.php?id=<?php echo $id_utilisateur; ?>'">Supprimer le compte</button>
</div>



<script src="../controller/modifier_compte.js"></script>
</body>
</html>