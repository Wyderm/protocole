<?php

require_once '../vendor/autoload.php';
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Exception\Exception;

function extractDocxText($filePath): string
{
    $text = '';
    try {
        $phpWord = IOFactory::load($filePath);

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                $text .= processElement($element);
            }
        }
    } catch (Exception $e) {
        echo "Erreur lors de la lecture du fichier : " . $e->getMessage();
        exit();
    }
    return $text;
}

function processElement($element): string
{
    $text = '';
    if (method_exists($element, 'getText')) {
        $text .= $element->getText() . "\n";
    } elseif (method_exists($element, 'getElements')) {
        foreach ($element->getElements() as $childElement) {
            if (method_exists($childElement, 'getText')) {
                $text .= $childElement->getText() . "\n";
            }
        }
    } else {
        error_log('Type d\'élément non géré : ' . get_class($element));
    }
    return $text;
}

function extractOdtText($filePath): string
{
    $text = '';
    $zip = new ZipArchive();
    if ($zip->open($filePath) === true) {
        if (($index = $zip->locateName('content.xml')) !== false) {
            $content = $zip->getFromIndex($index);

            // Remplace les balises spécifiques par des retours à la ligne
            $content = str_replace('<text:line-break/>', "\n", $content);
            $content = preg_replace('/<text:p[^>]*>/', "", $content);
            $content = str_replace('</text:p>', "\n", $content);

            $xml = new SimpleXMLElement($content);
            $text = strip_tags($xml->asXML());
        }
        $zip->close();
    } else {
        throw new Exception("Impossible d'ouvrir le fichier ODT.");
    }
    return trim($text);
}

function cleanInput($input): string
{
    if (!is_string($input)) {
        return '';
    }
    // Supprime les caractères de contrôle ASCII sauf les retours à la ligne (\n)
    return preg_replace('/[\x00-\x09\x0B-\x1F\x7F]/u', '', $input) ?? '';
}

function addTextWithLineBreaks($cell, $text, $paragraph_style): void
{
    $text = mb_convert_encoding($text, 'UTF-8', 'auto');
    $text = str_replace(['“', '”', '–'], ['"', '"', '-'], $text);
    $lines = explode("\n", $text); // Divise le texte en lignes
    $lines = array_map('removeLineBreaks', $lines); // Supprime les retours à la ligne supplémentaires
    foreach ($lines as $line) {
        $cell->addText($line, null, $paragraph_style);
    }
}

function removeLineBreaks($text): string
{
    return trim($text, "\n");
}
