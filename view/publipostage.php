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
$groupes = get_groupes_utilisateur($id);

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
<h1>Publipostage</h1>
<form action="../model/publipostage_bdd.php" method="post" enctype="multipart/form-data">
    <label for="file">Sélectionnez un fichier .docx :</label>
    <input type="file" id="file" name="file" accept=".docx" required>

    <label for="groupe">Sélectionnez un groupe :</label>
    <select id="groupe" name="groupe" required>
        <?php foreach ($groupes as $groupe): ?>
            <option value="<?php echo htmlspecialchars($groupe['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($groupe['nom'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Générer">
</form>