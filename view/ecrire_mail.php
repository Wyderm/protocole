<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

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

include 'nav_bar.html';

include '../model/liste_personnes_bdd.php';
global $personnes, $groupe;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Envoyer email</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<h1>Envoyer un email groupé</h1>
<form class="not-bordered" action="../model/ecrire_mail_bdd.php" method="post">
    <label for="mail" style="margin-bottom: 5px;">Entrez le message à envoyer</label>
    <textarea id="mail" name="mail" required style="margin-bottom: 10px;"></textarea>
    <div class="table-container">
        <table class="liste-personnes" id="tableau">
            <tr>
                <th><input id="check-all" type="checkbox"></th>
                <th>DENOMINATION</th>
                <th>DIRIGANT/CONTACT</th>
                <th>CATEGORIES</th>
                <th>SOUS-CATEGORIES</th>
                <th>ADRESSE 1</th>
                <th>ADRESSE 2</th>
                <th>CODE POSTAL</th>
                <th>VILLE</th>
                <th>N° TEL</th>
                <th>MAIL</th>
            </tr>
            <?php foreach ($personnes as $personne): ?>
                <tr>
                    <td><input type="checkbox" name="personnes[]"
                               value="<?php echo htmlspecialchars($personne['id'], ENT_QUOTES, 'UTF-8'); ?>"></td>
                    <td><?php echo $personne['denomination']; ?></td>
                    <td><?php echo $personne['dirigant_contact']; ?></td>
                    <td><?php echo $personne['categories']; ?></td>
                    <td><?php echo $personne['sous_categories']; ?></td>
                    <td><?php echo $personne['adresse1']; ?></td>
                    <td><?php echo $personne['adresse2']; ?></td>
                    <td><?php echo $personne['code_postal']; ?></td>
                    <td><?php echo $personne['ville']; ?></td>
                    <td><?php echo $personne['tel']; ?></td>
                    <td><?php echo $personne['mail']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <input type="hidden" name="groupe" value="<?php echo htmlspecialchars($groupe, ENT_QUOTES, 'UTF-8'); ?>">
    <button type="submit">Générer</button>
</form>
<script src="../controller/checkbox_publipostage.js"></script>
</body>
</html>