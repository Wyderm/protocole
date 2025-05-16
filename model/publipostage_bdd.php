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

include 'connexion_pdo.php';
global $db;

if (empty($_POST['groupe']) || !isset($_FILES['file'])) {
    header("Location: ../view/publipostage.php");
    exit();
}

$id_groupe = filter_input(INPUT_POST, 'groupe', FILTER_SANITIZE_NUMBER_INT);
$id_groupe = htmlspecialchars($id_groupe, ENT_QUOTES, 'UTF-8');

$stmt = $db->prepare("SELECT id FROM personne WHERE id_groupe = :id_groupe");
$stmt->execute([':id_groupe' => $id_groupe]);
$personnes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$file = $_FILES['file']['tmp_name'];

// Fonction pour extraire le texte d'un fichier .docx
function extractDocxText($filePath): string
{
    $phpWord = IOFactory::load($filePath);
    $text = '';
    foreach ($phpWord->getSections() as $section) {
        foreach ($section->getElements() as $element) {
            if (method_exists($element, 'getText')) {
                $text .= $element->getText() . "\n"; // Ajout d'un retour à la ligne
            } elseif (method_exists($element, 'getElements')) {
                foreach ($element->getElements() as $childElement) {
                    if (method_exists($childElement, 'getText')) {
                        $text .= $childElement->getText() . "\n"; // Gestion des sous-éléments
                    }
                }
            }
        }
    }
    return $text;
}

$contentTemplate = extractDocxText($file);

$phpWord = new PhpWord();
$section = $phpWord->addSection();

function cleanInput($input): string
{
    if (!is_string($input)) {
        return '';
    }
    // Supprime les caractères de contrôle ASCII sauf les retours à la ligne (\n)
    return preg_replace('/[\x00-\x09\x0B-\x1F\x7F]/u', '', $input) ?? '';
}

$table = $section->addTable(['width' => 100 * 50, 'unit' => 'pct', 'alignment' => 'center']);

function addTextWithLineBreaks($cell, $text): void
{
    $textRun = $cell->addTextRun(); // Crée un TextRun pour gérer plusieurs lignes
    $lines = explode("\n", $text); // Divise le texte en lignes
    foreach ($lines as $line) {
        $textRun->addText(htmlspecialchars($line)); // Ajoute chaque ligne
        $textRun->addTextBreak(); // Ajoute un saut de ligne après chaque ligne
    }
}

for ($i = 0; $i < count($personnes); $i += 2) {
    $table->addRow();

    // Première personne (colonne gauche)
    $stmt = $db->prepare("SELECT * FROM personne WHERE id = :id");
    $stmt->execute([':id' => $personnes[$i]['id']]);
    $personne_infos = $stmt->fetch(PDO::FETCH_ASSOC);

    $contentLeft = $contentTemplate;
    if ($contentLeft !== false) {
        $contentLeft = str_replace("[denomination]", $personne_infos['denomination'] ?? '', $contentLeft);
        $contentLeft = str_replace("[dirigant_contact]", $personne_infos['dirigant_contact'] ?? '', $contentLeft);
        $contentLeft = str_replace("[categorie]", $personne_infos['categorie'] ?? '', $contentLeft);
        $contentLeft = str_replace("[adresse1]", $personne_infos['adresse1'] ?? '', $contentLeft);
        $contentLeft = str_replace("[adresse2]", $personne_infos['adresse2'] ?? '', $contentLeft);
        $contentLeft = str_replace("[code_postal]", $personne_infos['code_postal'] ?? '', $contentLeft);
        $contentLeft = str_replace("[ville]", $personne_infos['ville'] ?? '', $contentLeft);
        $contentLeft = str_replace("[tel]", $personne_infos['tel'] ?? '', $contentLeft);
        $contentLeft = str_replace("[mail]", $personne_infos['mail'] ?? '', $contentLeft);
    }
    $contentLeft = cleanInput($contentLeft);
    addTextWithLineBreaks($table->addCell(2500), $contentLeft);

    // Deuxième personne (colonne droite)
    if (isset($personnes[$i + 1])) {
        $stmt = $db->prepare("SELECT * FROM personne WHERE id = :id");
        $stmt->execute([':id' => $personnes[$i + 1]['id']]);
        $personne_infos = $stmt->fetch(PDO::FETCH_ASSOC);

        $contentRight = $contentTemplate;
        if ($contentRight !== false) {
            $contentRight = str_replace("[denomination]", $personne_infos['denomination'] ?? '', $contentRight);
            $contentRight = str_replace("[dirigant_contact]", $personne_infos['dirigant_contact'] ?? '', $contentRight);
            $contentRight = str_replace("[categorie]", $personne_infos['categorie'] ?? '', $contentRight);
            $contentRight = str_replace("[adresse1]", $personne_infos['adresse1'] ?? '', $contentRight);
            $contentRight = str_replace("[adresse2]", $personne_infos['adresse2'] ?? '', $contentRight);
            $contentRight = str_replace("[code_postal]", $personne_infos['code_postal'] ?? '', $contentRight);
            $contentRight = str_replace("[ville]", $personne_infos['ville'] ?? '', $contentRight);
            $contentRight = str_replace("[tel]", $personne_infos['tel'] ?? '', $contentRight);
            $contentRight = str_replace("[mail]", $personne_infos['mail'] ?? '', $contentRight);
        }
        $contentRight = cleanInput($contentRight);
        addTextWithLineBreaks($table->addCell(2500), $contentRight);
    } else {
        $table->addCell(2500); // Cellule vide
    }
}

// Enregistrement du fichier Word
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Disposition: attachment; filename=\"nouv_fichier.docx\"");

$writer = IOFactory::createWriter($phpWord);
$writer->save("php://output");