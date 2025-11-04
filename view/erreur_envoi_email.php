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

if (isset($_GET['erreurs'])) {
    $mail_erreur = json_decode(urldecode($_GET['erreurs']), true);
} else {
    header('Location: hub_admin.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur email</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<?php
include_once 'nav_bar.html';
?>
<body>
<h1>Adresses email invalides</h1>

<?php
echo "<p>Les adresses suivantes sont invalides :</p>";
echo "<ul>";
foreach ($mail_erreur as $email) {
    echo "<li>" . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</li>";
}
echo "</ul>";
?>
<p>Les emails ont quand même été envoyés aux adresses valides</p>
</body>
</html>