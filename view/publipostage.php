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

$type = filter_input(INPUT_GET, 'type');
$type = strip_tags($type);
$type = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');

if (empty($type)) {
    header('Location: choix_publipostage.php');
    exit();
}

if ($type == 'etiquette') {
    echo '<h1>Publipostage Etiquette</h1>';
} elseif ($type == 'courrier') {
    echo '<h1>Publipostage Courrier</h1>';
} else {
    header('Location: choix_publipostage.php');
    exit();
}


if ($type == 'etiquette') {
    echo '<form action="../model/publipostage_etiquette_bdd.php" method="post" enctype="multipart/form-data">';
} else {
    echo '<form action="../model/publipostage_courrier_bdd.php" method="post" enctype="multipart/form-data">';
}
?>
    <label for="file">Sélectionnez un fichier Word :</label>
    <input type="file" id="file" name="file" accept=".docx, .odt" required>

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
</body>
</html>