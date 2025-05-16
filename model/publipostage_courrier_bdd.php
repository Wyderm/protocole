<?php
require_once '../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}

include 'lire_fichier.php';
include 'connexion_pdo.php';
global $db;

if (empty($_POST['groupe']) || !isset($_FILES['file'])) {
    header("Location: ../view/choix_publipostage.php");
    exit();
}

$id_groupe = filter_input(INPUT_POST, 'groupe', FILTER_SANITIZE_NUMBER_INT);
$id_groupe = htmlspecialchars($id_groupe, ENT_QUOTES, 'UTF-8');

$stmt = $db->prepare("SELECT nom FROM groupe WHERE id = :id");
$stmt->execute([':id' => $id_groupe]);
$groupe = $stmt->fetch(PDO::FETCH_ASSOC);

include 'gestion_permissions.php';
redirect_groupe($groupe['nom']);

$stmt = $db->prepare("SELECT id FROM personne WHERE id_groupe = :id_groupe");
$stmt->execute([':id_groupe' => $id_groupe]);
$personnes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$file = $_FILES['file']['tmp_name'];
$originalName = $_FILES['file']['name'];



if (pathinfo($originalName, PATHINFO_EXTENSION) === 'docx') {
    $contentTemplate = extractDocxText($file);
} elseif (pathinfo($originalName, PATHINFO_EXTENSION) === 'odt') {
    $contentTemplate = extractOdtText($file);
} else {
    echo "Format de fichier non pris en charge.";
    exit();
}


$phpWord = new PhpWord();
$phpWord->setDefaultFontSize(11);

$section = $phpWord->addSection();


$stmt = $db->prepare("SELECT * FROM personne WHERE id_groupe = :id_groupe");
$stmt->execute([':id_groupe' => $id_groupe]);
$personnes = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($personnes as $personne) {
    $content = $contentTemplate;
    $content = str_replace('[denomination]', $personne['denomination'] ?? '', $content);
    $content = str_replace('[dirigant_contact]', $personne['dirigant_contact'] ?? '', $content);
    $content = str_replace('[categorie]', $personne['categorie'] ?? '', $content);
    $content = str_replace('[adresse1]', $personne['adresse1'] ?? '', $content);
    $content = str_replace('[adresse2]', $personne['adresse2'] ?? '', $content);
    $content = str_replace('[code_postal]', $personne['code_postal'] ?? '', $content);
    $content = str_replace('[ville]', $personne['ville'] ?? '', $content);
    $content = str_replace('[tel]', $personne['tel'] ?? '', $content);
    $content = str_replace('[mail]', $personne['mail'] ?? '', $content);

    $content = cleanInput($content);
    addTextWithLineBreaks($section, $content);
}

header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Disposition: attachment; filename=\"nouv_fichier.docx\"");
header("Cache-Control: max-age=0");

ob_start();
$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save("php://output");
ob_end_flush();