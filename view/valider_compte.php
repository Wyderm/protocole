<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] !== true) {
    header("Location: ../view/connexion.php");
    exit();
} elseif ($_SESSION['type'] !== 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}

include_once "../model/valider_compte_bdd.php";
global $comptes
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
include_once '../model/get_all_groupes.php';
?>
<h1>Comptes à valider : </h1>
<div class="table-container">
    <table>
        <tr>
            <th>Identifiant</th>
            <th>E-mail</th>
            <th>Groupes</th>
            <th>Valider</th>
            <th>Rejeter</th>
        </tr>
        <?php
        foreach ($comptes as $compte) {
            $groupes_utilisateur = getGroupesUtilisateur($compte['id_compte']);
            echo "<tr>";
            echo "<td>" . htmlspecialchars($compte['id_compte']) . "</td>";
            echo "<td>" . htmlspecialchars($compte['email']) . "</td>";
            echo "<td>";
            foreach ($groupes_utilisateur as $groupe) {
                echo htmlspecialchars($groupe['nom']) . " ";
            }
            echo "</td>";
            echo "<td><button onclick=window.location.href='verif_valider.php?id=" . htmlspecialchars($compte['id_compte']) . "'>Valider</button></td>";
            echo "<td><button id='refuser' onclick=window.location.href='supprimer_compte.php?id=" . htmlspecialchars($compte['id_compte']) . "'>Supprimer</button></td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
