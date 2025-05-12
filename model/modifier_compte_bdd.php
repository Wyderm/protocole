<?php

if (!isset($_SESSION)) {
    session_start();
}
elseif ($_SESSION['type'] != 'admin') {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}
include "connexion_pdo.php";
global $db;

$id = filter_input(0, 'id_utilisateur', FILTER_SANITIZE_NUMBER_INT);
$id = strip_tags($id);
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
$username = filter_input(0, 'username');
$username = strip_tags($username);
$username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
$email = filter_input(0, 'email', FILTER_SANITIZE_EMAIL);
$email = strip_tags($email);
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$type = filter_input(0, 'type');
$type = strip_tags($type);
$type = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');

if (!empty($username)) {
    try {
        $stmt = $db->prepare("UPDATE utilisateur SET username = :username WHERE id_compte = :id");
        $stmt->execute(array(
            'username' => $username,
            'id' => $id
        ));
    } catch (Exception $e) {
        echo "Erreur lors de la mise à jour du nom d'utilisateur : " . $e->getMessage();
    }
}

if (!empty($email)) {
    try {
        $stmt = $db->prepare("UPDATE utilisateur SET email = :email WHERE id_compte = :id");
        $stmt->execute(array(
            'email' => $email,
            'id' => $id
        ));
    } catch (Exception $e) {
        echo "Erreur lors de la mise à jour de l'adresse e-mail : " . $e->getMessage();
    }
}

if (!empty($type)) {
    try {
        $stmt = $db->prepare("UPDATE utilisateur SET type = :type WHERE id_compte = :id");
        $stmt->execute(array(
            'type' => $type,
            'id' => $id
        ));
    } catch (Exception $e) {
        echo "Erreur lors de la mise à jour du type de compte : " . $e->getMessage();
    }
}

echo "Le compte a été modifié avec succès.";

