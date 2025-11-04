<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}
if ($_SESSION['type'] != 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer groupes modifiables</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<?php
include 'nav_bar.html';
include '../model/get_utilisateur_by_id.php';
global $compte;

include '../model/get_all_groupes.php';
$groupes = getAllGroupes();
$groupes_utilisateur = getGroupesUtilisateur($compte['id_compte']);
?>
<body>
<div class="flex-container-vertical not-bordered">
    <h1>Gestion des groupes modifiables de <?php echo $compte['email'] ?></h1>
    <form action="../model/ajouter_groupe_user.php" method="post">
        <h2>Ajouter</h2>
        <label for="groupe">Groupes :</label>
        <select name="groupe" id="groupe">
            <?php foreach ($groupes as $groupe) {
                $ids_groupes_utilisateur = array_column($groupes_utilisateur, 'id');

                if (!in_array($groupe['id'], $ids_groupes_utilisateur)) {
                    echo '<option value="' . htmlspecialchars($groupe['id']) . '">' . htmlspecialchars($groupe['nom']) . '</option>';
                }
            }
            ?>
        </select>
        <input type="hidden" name="id" value="<?php echo $compte['id_compte']; ?>">
        <input type="submit" value="Ajouter">
    </form>
    <div id="response-container"></div>
    <form action="../model/supprimer_groupe_user.php" method="post">
        <h2>Supprimer</h2>
        <label for="groupe">Sous-catégories :</label>
        <select name="groupe" id="groupe">
            <?php foreach ($groupes_utilisateur as $groupe): ?>
                <option value="<?php echo htmlspecialchars($groupe['id']); ?>"><?php echo htmlspecialchars($groupe['nom']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($compte['id_compte']); ?>">
        <input type="submit" value="Supprimer">
    </form>

</div>
</body>
</html>