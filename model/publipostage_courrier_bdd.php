<?php
require_once_once '../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['valide']) {
    header("Location: ../view/connexion.php");
    exit();
}

include_once 'lire_fichier.php';
include_once 'connexion_pdo.php';
global $db;

if (empty($_POST['groupe']) || !isset($_FILES['file'])) {
    header("Location: ../view/choix_publipostage.php");
    exit();
}

$id_groupe = filter_input(INPUT_POST, 'groupe', FILTER_SANITIZE_NUMBER_INT);
$id_groupe = htmlspecialchars($id_groupe, ENT_QUOTES, 'UTF-8');

$groupe = filter_input(INPUT_POST, 'groupe');
$groupe = strip_tags($groupe);
$groupe = htmlspecialchars($groupe, ENT_QUOTES, 'UTF-8');

include_once 'gestion_permissions.php';
redirectGroupe($groupe);


if (isset($_POST['personnes']) && is_array($_POST['personnes'])) {
    $personnes = filter_var_array($_POST['personnes'], FILTER_SANITIZE_NUMBER_INT);
} else {
    $personnes = [];
}

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

$paragraph_style = [
    'spaceBefore' => 5.6 * 20,  // Espacement avant
    'spaceAfter' => 0,   // Espacement après
    'indentation' => [
        'left' => 0.25 * 566.9291,     // Retrait à gauche (720 twips = 0.5 pouce)
        'right' => 0.25 * 566.9291,    // Retrait à droite (360 twips = 0.25 pouce)
    ],
    'keepNext' => true,
    'valign' => 'top'
];

$section = $phpWord->addSection([
    'marginTop' => 1.5 * 566.9291,    // 1,5 cm
    'marginBottom' => 0.5 * 566.9291, // 0,5 cm
    'marginLeft' => 0.5 * 566.9291, // 0,5 cm
    'marginRight' => 0
]);


$stmt = $db->prepare("SELECT * FROM personne WHERE id = :id");
foreach ($personnes as $personne) {
    $stmt->execute([':id' => $personne]);
    $personneData = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($personneData) {
        $lespersonnes[] = $personneData;
    }
}

foreach ($lespersonnes as $personne) {
    $content = $contentTemplate;
    $content = str_replace('[denomination]', $personne['denomination'] ?? '', $content);
    $content = str_replace('[dirigant_contact]', $personne['dirigant_contact'] ?? '', $content);
    $content = str_replace('[categorie]', $personne['categories'] ?? '', $content);
    $content = str_replace('[sous_categorie]', $personne['sous_categories'] ?? '', $content);
    $content = str_replace('[adresse1]', $personne['adresse1'] ?? '', $content);
    $content = str_replace('[adresse2]', $personne['adresse2'] ?? '', $content);
    $content = str_replace('[code_postal]', $personne['code_postal'] ?? '', $content);
    $content = str_replace('[ville]', $personne['ville'] ?? '', $content);
    $content = str_replace('[tel]', $personne['tel'] ?? '', $content);
    $content = str_replace('[mail]', $personne['mail'] ?? '', $content);

    $content = cleanInput($content);
    $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
    addTextWithLineBreaks($section, $content, $paragraph_style);
}

header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Disposition: attachment; filename=\"$groupe.docx\"");
header("Cache-Control: max-age=0");

ob_start();
$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save("php://output");
ob_end_flush();