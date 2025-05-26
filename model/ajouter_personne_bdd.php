<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}
if (empty($_POST['groupe'])) {
    header("Location: ../view/choisir_groupe.php");
    exit();
}
else {
    $groupe = filter_input(0, 'groupe');
    $groupe = strip_tags($groupe);
    $groupe = htmlspecialchars($groupe, ENT_QUOTES, 'UTF-8');
}

include '../model/gestion_permissions.php';
redirect_groupe($groupe);
$ecriture = ecriture_permissions($_SESSION['id']);
if (!$ecriture) {
    header("Location: ../view/hub_utilisateur.php");
    exit();
}

if (!empty($_POST['denomination'])) {
    $denomination = filter_input(0, 'denomination');
    $denomination = strip_tags($denomination);
    $denomination = htmlspecialchars($denomination, ENT_QUOTES, 'UTF-8');
    $denomination = trim($denomination);
} else {
    $denomination = '';
}

if (!empty($_POST['dirigant_contact'])) {
    $dirigant_contact = filter_input(0, 'dirigant_contact');
    $dirigant_contact = strip_tags($dirigant_contact);
    $dirigant_contact = htmlspecialchars($dirigant_contact, ENT_QUOTES, 'UTF-8');
    $dirigant_contact = trim($dirigant_contact);
} else {
    $dirigant_contact = '';
}

if (!empty($_POST['categorie'])) {
    $categories = filter_input(0, 'categorie');
    $categories = strip_tags($categories);
    $categories = htmlspecialchars($categories, ENT_QUOTES, 'UTF-8');
    $categories = trim($categories);
} else {
    $categories = '';
}

if (!empty($_POST['sous_categories'])) {
    $sous_categories = filter_input(0, 'sous_categories');
    $sous_categories = strip_tags($sous_categories);
    $sous_categories = htmlspecialchars($sous_categories, ENT_QUOTES, 'UTF-8');
    $sous_categories = trim($sous_categories);
} else {
    $sous_categories = '';
}

if (!empty($_POST['adresse1'])) {
    $adresse1 = filter_input(0, 'adresse1');
    $adresse1 = strip_tags($adresse1);
    $adresse1 = htmlspecialchars($adresse1, ENT_QUOTES, 'UTF-8');
    $adresse1 = trim($adresse1);
} else {
    $adresse1 = '';
}

if (!empty($_POST['adresse2'])) {
    $adresse2 = filter_input(0, 'adresse2');
    $adresse2 = strip_tags($adresse2);
    $adresse2 = htmlspecialchars($adresse2, ENT_QUOTES, 'UTF-8');
    $adresse2 = trim($adresse2);
} else {
    $adresse2 = '';
}

if (!empty($_POST['code_postal'])) {
    $code_postal = filter_input(0, 'code_postal');
    $code_postal = strip_tags($code_postal);
    $code_postal = htmlspecialchars($code_postal, ENT_QUOTES, 'UTF-8');
    $code_postal = trim($code_postal);
} else {
    $code_postal = '';
}

if (!empty($_POST['ville'])) {
    $ville = filter_input(0, 'ville');
    $ville = strip_tags($ville);
    $ville = htmlspecialchars($ville, ENT_QUOTES, 'UTF-8');
    $ville = trim($ville);
} else {
    $ville = '';
}

if (!empty($_POST['tel'])) {
    $tel = filter_input(0, 'tel');
    $tel = strip_tags($tel);
    $tel = htmlspecialchars($tel, ENT_QUOTES, 'UTF-8');
    $tel = trim($tel);
} else {
    $tel = '';
}

if (!empty($_POST['mail'])) {
    $mail = filter_input(0, 'mail', FILTER_SANITIZE_EMAIL);
    $mail = strip_tags($mail);
    $mail = htmlspecialchars($mail, ENT_QUOTES, 'UTF-8');
    $mail = trim($mail);
} else {
    $mail = '';
}

include 'connexion_pdo.php';
global $db;

$id_groupe = $db->prepare("SELECT id FROM groupe WHERE nom = :groupe");
$id_groupe->execute(array(
    'groupe' => $groupe
));
$id_groupe = $id_groupe->fetch(PDO::FETCH_ASSOC);


$stmt = $db->prepare("INSERT INTO personne (denomination, dirigant_contact, categories, sous_categories, adresse1, adresse2, code_postal, ville, tel, mail, id_groupe) VALUES (:denomination, :dirigant_contact, :categories, :sous_categories, :adresse1, :adresse2, :code_postal, :ville, :tel, :mail, :id_groupe)");
$stmt->execute(array(
    'denomination' => $denomination,
    'dirigant_contact' => $dirigant_contact,
    'categories' => $categories,
    'sous_categories' => $sous_categories,
    'adresse1' => $adresse1,
    'adresse2' => $adresse2,
    'code_postal' => $code_postal,
    'ville' => $ville,
    'tel' => $tel,
    'mail' => $mail,
    'id_groupe' => $id_groupe['id']
));
$id_personne = $db->lastInsertId();



header("Location: ../view/liste_personnes.php");