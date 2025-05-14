<?php
include "connexion_pdo.php";
global $db;

if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['valide'] !== true) {
    header("Location: ../view/connexion.php");
    exit();
} elseif ($_SESSION['type'] !== 'admin') {
    header("Location: ../view/hub_admin.php");
    exit();
} elseif (empty($_GET['id'])) {
    header("Location: ../view/hub_admin.php");
    exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$id = strip_tags($id);
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

$stmt = $db->prepare("SELECT * FROM utilisateur WHERE id_compte = :id_compte");
$stmt->execute(array('id_compte' => $id));
$compte = $stmt->fetch(PDO::FETCH_ASSOC);