<?php

namespace api\src\Config;

use PDO;
use PDOException;
use api\src\Library\SecLib;

require_once($_SERVER['DOCUMENT_ROOT'] . "/VIOLLET_Yoan_API_Tri/api/src/Library/SecLib.php");

class Connection {

    private $credentials;
    private $connection;

    public function __construct($credentialsFile) {
        $this->credentials = SecLib::GetCredentials($credentialsFile);
        $this->connect();
    }

    public function connect() {
        try {
            $this->connection = new PDO(
                "mysql:host=localhost;dbname=test",
                $this->credentials->username,
                $this->credentials->password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );

            echo "Connected successfully";
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}