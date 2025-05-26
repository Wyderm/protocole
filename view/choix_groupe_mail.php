<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] !== true) {
    header("Location: connexion.php");
    exit();
}
if ($_SESSION['type'] != 'admin') {
    header("Location: hub_utilisateur.php");
    exit();
}

include '../model/get_all_groupes.php';
$id = $_SESSION['id'];
$groupes = get_groupes_utilisateur($id);

include 'nav_bar.html';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Publipostage</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<h1>Publipostage mail</h1>
<form action="ecrire_mail.php" method="post">
    <label for="groupe">Sélectionnez un groupe :</label>
    <select id="groupe" name="groupe" required>
        <?php foreach ($groupes as $groupe): ?>
            <option value="<?php echo htmlspecialchars($groupe['nom'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($groupe['nom'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit">
</form>
</body>
</html>