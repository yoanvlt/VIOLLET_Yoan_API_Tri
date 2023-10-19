<?php

use api\src\controller\EndPoint;

require_once(__DIR__ . "/../src/Controller/EndPoint.php");


// Définir le bon en-tête pour indiquer que la réponse est en JSON
header('Content-Type: application/json');

try {
    EndPoint::Routing();
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}