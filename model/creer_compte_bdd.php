<?php
include "../model/connexion_pdo.php";
global $db;
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] && $_SESSION['type'] != 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}

// Vérifier si le formulaire a été soumis
if (!empty($_POST["username"])) {
    // Récupérer les valeurs du formulaire
    $username = filter_input(0, 'username');
    $username = strip_tags($username);
    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    $email = filter_input(0, 'email', FILTER_VALIDATE_EMAIL);
    $email = strip_tags($email);
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $password = filter_input(0, 'password');
    $password = strip_tags($password);
    $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
    $confirm_password = filter_input(0, 'confirm_password');
    $confirm_password = strip_tags($confirm_password);
    $confirm_password = htmlspecialchars($confirm_password, ENT_QUOTES, 'UTF-8');
    $groupes = filter_input(0, 'groupes', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $groupes = array_map('strip_tags', $groupes);
    $groupes = array_map('htmlspecialchars', $groupes);

    if (strlen($password) < 15 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
        header("Location: ../view/erreur_mdp.html");
        exit();
    }

    if ($confirm_password != $password) {
        header("Location: ../view/erreur_creation_compte.html");
        exit();
    }

    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $activation_token = bin2hex(random_bytes(16));
    $activation_token_hash = hash('sha256', $activation_token);


    // Vérifier si l'utilisateur existe déjà
    $stmt = $db->prepare("SELECT COUNT(*) FROM utilisateur WHERE username = :username");
    $stmt->execute(array(
        "username" => $username
    ));
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        header("Location: ../view/erreur_nom_utilisateur.html");
        exit();
    }

    // Vérifier si l'email existe déjà
    $stmt = $db->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = :email");
    $stmt->execute(array(
        "email" => $email
    ));
    $count_email = $stmt->fetchColumn();
    if ($count_email > 0) {
        header("Location: ../view/erreur_email.html");
        exit();
    }



    // Insérer les éléments
    $inserer_compte = $db->prepare("INSERT INTO utilisateur (username, password, email, account_activation_hash) VALUES (:username, :password, :email, :account_activation_hash)");
    $inserer_compte->execute(array(
        "username" => $username,
        "password" => $password,
        "email" => $email,
        "account_activation_hash" => $activation_token_hash
    ));

    $id_compte = $db->lastInsertId();

    foreach ($groupes as $groupe) {
        $stmt = $db->prepare("INSERT INTO utilisateur_groupe (id_utilisateur, id_groupe) VALUES (:id_utilisateur, :id_groupe)");
        $stmt->execute(array(
            "id_utilisateur" => $id_compte,
            "id_groupe" => $groupe
        ));
    }

    $stmt = $db->prepare("SELECT id_compte FROM utilisateur WHERE username = :username");
    $stmt->execute(array(
        "username" => $username
    ));
    $id = $stmt->fetch(PDO::FETCH_ASSOC);

    $mail = require __DIR__ . "/mailer.php";

    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    $mail->setFrom("stagiaire-dev@ville-saint-saulve.fr", "Mairie de Saint-Saulve");
    $mail->addAddress($email);
    $mail->Subject = "Validation de compte";
    $mail->Body = "Cliquez sur le lien suivant pour valider votre compte : <a href='http://localhost:63342/protocole/view/activer_compte.php?token=" . urlencode($activation_token) . "'>Valider votre compte</a>";


    $mail->SMTPDebug = 0; // Activer le mode debug (0 pour désactiver)
    $mail->Timeout = 10; // Timeout en secondes

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
        exit();
    }

    if ($_SESSION['type'] == 'admin') {
        header("Location: ../view/HUB_admin.php");
    } else {
        header("Location: ../view/mail_envoye.html");
    }
} else {
    header("Location: ../view/creer_compte.php");
}