<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Publipostage</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php

ini_set('session.cache_limiter','public');
session_cache_limiter(false);

$type = filter_input(INPUT_POST, 'type');
$type = strip_tags($type);
$type = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');


include_once '../model/liste_personnes_bdd.php';
global $personnes, $groupe;

include_once 'nav_bar.html';
if ($type == 'etiquette') {
    echo '<h1>Publipostage Etiquette</h1>';
    $url = '../model/publipostage_etiquette_bdd.php';
} elseif ($type == 'courrier') {
    echo '<h1>Publipostage Courrier</h1>';
    $url = '../model/publipostage_courrier_bdd.php';
} else {
    header('Location: choix_publipostage.php');
    exit();
}

$groupe = filter_input(INPUT_POST, 'groupe');
$groupe = strip_tags($groupe);
$groupe = htmlspecialchars($groupe, ENT_QUOTES, 'UTF-8');

?>

<form class="not-bordered" action="<?php echo $url; ?>" method="post" enctype="multipart/form-data">
    <label for="file">Sélectionnez un fichier Word :</label>
    <input type="file" id="file" name="file" accept=".docx, .odt" require_onced style="padding-bottom: 10px;">
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
