<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer sous-catégories</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<?php
include 'nav_bar.html';
include '../model/get_personne_by_id.php';
global $personne, $sous_categories;
?>
<body>
<div class="flex-container-vertical not-bordered">
    <h1>Gestion des sous-catégories de <?php echo $personne['dirigant_contact'] ?></h1>
    <form action="../model/ajouter_souscategorie.php" method="post">
        <h2>Ajouter</h2>
        <label for="sous_categorie">Sous-catégorie :</label>
        <input type="text" id="sous_categorie" name="sous_categorie">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($personne['id']); ?>">
        <input type="submit" value="Ajouter">
    </form>
    <div id="response-container"></div>
    <form action="../model/supprimer_souscategorie.php" method="post">
        <h2>Supprimer</h2>
        <label for="sous_categorie">Sous-catégories :</label>
        <select name="sous_categorie" id="sous_categorie">
            <?php foreach ($sous_categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['nom']); ?>"><?php echo htmlspecialchars($category['nom']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($personne['id']); ?>">
        <input type="submit" value="Supprimer">
    </form>

</div>
</body>
</html>