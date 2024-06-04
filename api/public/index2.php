<?php

use api\src\Controller\EndPoint2;

require_once(__DIR__ . "/../src/Controller/EndPoint2.php");

// Définir le bon en-tête pour indiquer que la réponse est en JSON
header('Content-Type: application/json');

try {
    EndPoint2::Routing();
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
