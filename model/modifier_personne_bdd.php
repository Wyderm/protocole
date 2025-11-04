<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}

if (empty($_POST['id'])) {
    header("Location: ../view/choisir_groupe.php");
    exit();
}

include_once "connexion_pdo.php";
global $db;

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$id = strip_tags($id);
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

include_once '../model/gestion_permissions.php';
redirect_personne($id);
$ecriture = ecriture_permissions($_SESSION['id']);
if (!$ecriture) {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}

if (!empty($_POST['denomination'])) {
    $denomination = filter_input(INPUT_POST, 'denomination');
    $denomination = strip_tags($denomination);
    $denomination = htmlspecialchars($denomination, ENT_QUOTES, 'UTF-8');
    $denomination = trim($denomination);

    $stmt = $db->prepare("UPDATE personne SET denomination = :denomination WHERE id = :id");
    $stmt->execute(array(
        'denomination' => $denomination,
        'id' => $id
    ));
}

if (!empty($_POST['dirigant_contact'])) {
    $dirigant_contact = filter_input(INPUT_POST, 'dirigant_contact');
    $dirigant_contact = strip_tags($dirigant_contact);
    $dirigant_contact = htmlspecialchars($dirigant_contact, ENT_QUOTES, 'UTF-8');
    $dirigant_contact = trim($dirigant_contact);

    $stmt = $db->prepare("UPDATE personne SET dirigant_contact = :dirigant_contact WHERE id = :id");
    $stmt->execute(array(
        'dirigant_contact' => $dirigant_contact,
        'id' => $id
    ));
}

if (!empty($_POST['categorie'])) {
    $categorie = filter_input(INPUT_POST, 'categorie');
    $categorie = strip_tags($categorie);
    $categorie = htmlspecialchars($categorie, ENT_QUOTES, 'UTF-8');
    $categorie = trim($categorie);

    $stmt = $db->prepare("UPDATE personne SET categories = :categorie WHERE id = :id");
    $stmt->execute(array(
        'categorie' => $categorie,
        'id' => $id
    ));
}

if (!empty($_POST['sous_categories'])) {
    $souscategorie = filter_input(INPUT_POST, 'sous_categories');
    $souscategorie = strip_tags($souscategorie);
    $souscategorie = htmlspecialchars($souscategorie, ENT_QUOTES, 'UTF-8');
    $souscategorie = trim($souscategorie);

    $stmt = $db->prepare("UPDATE personne SET sous_categories = :souscategorie WHERE id = :id");
    $stmt->execute(array(
        'souscategorie' => $souscategorie,
        'id' => $id
    ));
}

if (!empty($_POST['adresse1'])) {
    $adresse1 = filter_input(INPUT_POST, 'adresse1');
    $adresse1 = strip_tags($adresse1);
    $adresse1 = htmlspecialchars($adresse1, ENT_QUOTES, 'UTF-8');
    $adresse1 = trim($adresse1);

    $stmt = $db->prepare("UPDATE personne SET adresse1 = :adresse1 WHERE id = :id");
    $stmt->execute(array(
        'adresse1' => $adresse1,
        'id' => $id
    ));
}

if (!empty($_POST['adresse2'])) {
    $adresse2 = filter_input(INPUT_POST, 'adresse2');
    $adresse2 = strip_tags($adresse2);
    $adresse2 = htmlspecialchars($adresse2, ENT_QUOTES, 'UTF-8');
    $adresse2 = trim($adresse2);

    $stmt = $db->prepare("UPDATE personne SET adresse2 = :adresse2 WHERE id = :id");
    $stmt->execute(array(
        'adresse2' => $adresse2,
        'id' => $id
    ));
}

if (!empty($_POST['code_postal'])) {
    $code_postal = filter_input(INPUT_POST, 'code_postal');
    $code_postal = strip_tags($code_postal);
    $code_postal = htmlspecialchars($code_postal, ENT_QUOTES, 'UTF-8');
    $code_postal = trim($code_postal);

    $stmt = $db->prepare("UPDATE personne SET code_postal = :code_postal WHERE id = :id");
    $stmt->execute(array(
        'code_postal' => $code_postal,
        'id' => $id
    ));
}

if (!empty($_POST['ville'])) {
    $ville = filter_input(INPUT_POST, 'ville');
    $ville = strip_tags($ville);
    $ville = htmlspecialchars($ville, ENT_QUOTES, 'UTF-8');
    $ville = trim($ville);

    $stmt = $db->prepare("UPDATE personne SET ville = :ville WHERE id = :id");
    $stmt->execute(array(
        'ville' => $ville,
        'id' => $id
    ));
}

if (!empty($_POST['tel'])) {
    $tel = filter_input(INPUT_POST, 'tel');
    $tel = strip_tags($tel);
    $tel = htmlspecialchars($tel, ENT_QUOTES, 'UTF-8');
    $tel = trim($tel);

    $stmt = $db->prepare("UPDATE personne SET tel = :tel WHERE id = :id");
    $stmt->execute(array(
        'tel' => $tel,
        'id' => $id
    ));
}

if (!empty($_POST['mail'])) {
    $mail = filter_input(INPUT_POST, 'mail');
    $mail = strip_tags($mail);
    $mail = htmlspecialchars($mail, ENT_QUOTES, 'UTF-8');
    $mail = trim($mail);

    $stmt = $db->prepare("UPDATE personne SET mail = :mail WHERE id = :id");
    $stmt->execute(array(
        'mail' => $mail,
        'id' => $id
    ));
}

header("Location: ../view/modifier_personne.php?id=$id");