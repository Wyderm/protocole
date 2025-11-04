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

$groupe = filter_input(INPUT_POST, 'groupe');
$groupe = strip_tags($groupe);
$groupe = htmlspecialchars($groupe, ENT_QUOTES, 'UTF-8');

include 'gestion_permissions.php';
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
$phpWord->setDefaultFontName('Calibri (Body)');

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


$table = $section->addTable(['width' => 100 * 50, 'unit' => 'pct', 'alignment' => 'center']);

$stmt = $db->prepare("SELECT * FROM personne WHERE id = :id");
foreach ($personnes as $personne) {
    $stmt->execute([':id' => $personne]);
    $personneData = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($personneData) {
        $lespersonnes[] = $personneData;
    }
}

for ($i = 0; $i < count($lespersonnes); $i += 2) {
    $table->addRow(2210.88, ['exactHeight' => true]);

    $personne = $lespersonnes[$i];

    $linebreak = true;
    $nb = 14;

    if (($i - 14) % 16 == 0) { // Vérifie si $i est un multiple de 16 après 14
        $linebreak = false;
    }

    $contentLeft = $contentTemplate;
    if ($contentLeft !== false) {
        $contentLeft = str_replace("[denomination]", $personne['denomination'] ?? '', $contentLeft);
        $contentLeft = str_replace("[dirigant_contact]", $personne['dirigant_contact'] ?? '', $contentLeft);
        $contentLeft = str_replace("[categorie]", $personne['categories'] ?? '', $contentLeft);
        $contentLeft = str_replace("[sous_categorie]", $personne['sous_categories'] ?? '', $contentLeft);
        $contentLeft = str_replace("[adresse1]", $personne['adresse1'] ?? '', $contentLeft);
        $contentLeft = str_replace("[adresse2]", $personne['adresse2'] ?? '', $contentLeft);
        $contentLeft = str_replace("[code_postal]", $personne['code_postal'] ?? '', $contentLeft);
        $contentLeft = str_replace("[ville]", $personne['ville'] ?? '', $contentLeft);
        $contentLeft = str_replace("[tel]", $personne['tel'] ?? '', $contentLeft);
        $contentLeft = str_replace("[mail]", $personne['mail'] ?? '', $contentLeft);
    }
    if (!$linebreak || !isset($personne[$i + 1])) {
        $contentLeft = removeLineBreaks($contentLeft);
    }
    $contentLeft = cleanInput($contentLeft);
    $contentLeft = htmlspecialchars($contentLeft, ENT_QUOTES, 'UTF-8');
    addTextWithLineBreaks($table->addCell(2500), $contentLeft, $paragraph_style);

    // Deuxième personne (colonne droite)
    if (isset($personnes[$i + 1])) {
        $personne = $lespersonnes[$i + 1];

        $contentRight = $contentTemplate;
        if ($contentRight !== false) {
            $contentRight = str_replace("[denomination]", $personne['denomination'] ?? '', $contentRight);
            $contentRight = str_replace("[dirigant_contact]", $personne['dirigant_contact'] ?? '', $contentRight);
            $contentRight = str_replace("[categorie]", $personne['categories'] ?? '', $contentRight);
            $contentRight = str_replace("[sous_categorie]", $personne['sous_categories'] ?? '', $contentRight);
            $contentRight = str_replace("[adresse1]", $personne['adresse1'] ?? '', $contentRight);
            $contentRight = str_replace("[adresse2]", $personne['adresse2'] ?? '', $contentRight);
            $contentRight = str_replace("[code_postal]", $personne['code_postal'] ?? '', $contentRight);
            $contentRight = str_replace("[ville]", $personne['ville'] ?? '', $contentRight);
            $contentRight = str_replace("[tel]", $personne['tel'] ?? '', $contentRight);
            $contentRight = str_replace("[mail]", $personne['mail'] ?? '', $contentRight);
        }
        $contentRight = cleanInput($contentRight);
        if (!$linebreak) {
            $contentRight = removeLineBreaks($contentRight);
            $linebreak = true;
        }
        $contentRight = htmlspecialchars($contentRight, ENT_QUOTES, 'UTF-8');
        addTextWithLineBreaks($table->addCell(2500), $contentRight, $paragraph_style);
    } else {
        $table->addCell(2500);
    }

}

// Enregistrement du fichier Word
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Disposition: attachment; filename=\"$groupe.docx\"");

$writer = IOFactory::createWriter($phpWord);
$writer->save("php://output");