<?php
include_once_once "connexion_pdo.php";
global $db;
session_start();
session_regenerate_id();
$_SESSION['valide'] = false;

// Vérifier si le formulaire a été soumis
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    // Récupérer les valeurs du formulaire
    $username = filter_input(0, 'username');
    $username = strip_tags($username);
    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

    $password = filter_input(0, 'password');
    $password = strip_tags($password);
    $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

    // Vérifier les identifiants
    $stmt = $db->prepare("SELECT * FROM utilisateur WHERE username = :login AND valide = true AND supprime = false");
    $stmt->execute(array(
        'login' => $username
    ));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $user['password'])) {
        // Authentification réussie
        session_regenerate_id(true);
        $_SESSION['id'] = $user['id_compte'];
        $_SESSION['type'] = $user['type'];
        $_SESSION['valide'] = true;
        if ($_SESSION['type'] == 'admin') {
            header("Location: ../view/hub_admin.php");
        } else {
            header("Location: ../view/hub_utilisateur.php");
        }
    } else {
        // Authentification échouée
        header("Location: ../view/erreur_connexion.html");
    }
}
else {
    header("Location: ../view/connexion.php");
}
