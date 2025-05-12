<?php
try {
    $chemin_base = '\\\\sv-fichiers\\Partages\\PO-Accompagner-SVC-CCAS\\Matheo Deghaye\\bdd_protocole\\bdd_protocole.db';
    $db = new PDO("sqlite:$chemin_base");
} catch (PDOException $e) {
    die ("Connection failed: " . $e->getMessage());
}
