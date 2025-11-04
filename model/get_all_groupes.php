<?php

include_once_once '../model/connexion_pdo.php';

function getAllGroupes(): array
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM groupe");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getGroupesUtilisateur($id_utilisateur): array
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM utilisateur_groupe JOIN groupe ON utilisateur_groupe.id_groupe = groupe.id WHERE id_utilisateur = :id_utilisateur");
    $stmt->execute(array('id_utilisateur' => $id_utilisateur));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
