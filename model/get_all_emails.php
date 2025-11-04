<?php
include_once 'connexion_pdo.php';
header('Content-Type: application/json');
global $db;

$searchQuery = json_decode(file_get_contents('php://input'), true)['query'];

$users = $db->prepare("SELECT email FROM utilisateur WHERE supprime = false AND valide = true");
$users->execute();

$emails = array();

while ($user = $users->fetch()) {
    $nom = $user['email'];
    if (stripos($nom, $searchQuery) !== false) {
        $emails[] = $nom;
    }
}

echo json_encode(array_values($emails));
