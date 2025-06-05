<?php
try {
    $chemin_base = '\\\\sv-ccas\\Data\\DEGHAYE\\protocole\\bdd_protocole.db';
    $db = new PDO("sqlite:$chemin_base");
} catch (PDOException $e) {
    die ("Connection failed: " . $e->getMessage());
}
