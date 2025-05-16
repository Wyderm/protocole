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


$table = $section->addTable(['width' => 100 * 50, 'unit' => 'pct', 'alignment' => 'center']);


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