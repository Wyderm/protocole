<?php
try {
    $chemin_base = 'C:\Users\mathe\PhpstormProjects\protocole\protocole\model\base.db';
    $db = new PDO("sqlite:$chemin_base");
} catch (PDOException $e) {
    die ("Connection failed: " . $e->getMessage());
}
