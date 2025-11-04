<?php
include_once 'connexion_pdo.php';

function redirectGroupe($groupe): void
{
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!$_SESSION['valide']) {
        header("Location: ../view/connexion.php");
        exit();
    }

    global $db;

    $id = $_SESSION['id'];

    $stmt = $db->prepare("SELECT g.nom
                          FROM utilisateur_groupe
                          JOIN groupe g ON utilisateur_groupe.id_groupe = g.id
                          WHERE id_utilisateur = :id");
    $stmt->execute(array(
        'id' => $id
    ));
    $groupes = $stmt->fetchAll(PDO::FETCH_COLUMN); // Récupère uniquement les noms des groupes

    if (!in_array($groupe, $groupes)) {
        header("Location: ../view/hub_admin.php");
        exit();
    }
}

function redirectPersonne($id_personne): void
{
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!$_SESSION['valide']) {
        header("Location: ../view/connexion.php");
        exit();
    }

    global $db;

    $id = $_SESSION['id'];

    $stmt = $db->prepare("SELECT id_groupe FROM personne WHERE id=:id");
    $stmt->execute(array(
        'id' => $id_personne
    ));
    $id_groupe = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM utilisateur_groupe WHERE id_utilisateur = :id AND id_groupe = :id_groupe");
    $stmt->execute(array(
        'id' => $id,
        'id_groupe' => $id_groupe['id_groupe']
    ));
    $id_groupe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$id_groupe) {
        header("Location: ../view/hub_admin.php");
        exit();
    }
}

function ecriturePermissions($id_compte): bool
{
    global $db;

    $stmt = $db->prepare("SELECT type FROM utilisateur WHERE id_compte = :id");
    $stmt->execute(array(
        'id' => $id_compte
    ));
    $type = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($type['type'] != 'admin' && $type['type'] != 'user') {
        return false;
    }
    return true;
}
