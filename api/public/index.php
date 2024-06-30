<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use api\src\Controller\SecureLogin;

require_once(__DIR__ . "/../src/Controller/SecureLogin.php");


header('Content-Type: text/html');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: no-referrer');
header('Content-Security-Policy: default-src \'self\'');

try {
    SecureLogin::Routing();
} catch (Exception $e) {
    echo '<pre>';
    echo 'Exception: ' . $e->getMessage();
    echo '</pre>';
}
