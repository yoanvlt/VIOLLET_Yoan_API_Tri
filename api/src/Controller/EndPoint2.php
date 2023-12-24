<?php

namespace api\src\Controller;

use api\src\Config\Connection;
use api\src\Config\DBOperation;

require_once($_SERVER['DOCUMENT_ROOT'] . "/VIOLLET_Yoan_API_Tri/api/src/Config/Connection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/VIOLLET_Yoan_API_Tri/api/src/Config/DBOperation.php");

class EndPoint2 {

    private $dbOperations;

    public function __construct() {
        $connector = new Connection("test.json");
        $this->dbOperations = new DBOperation($connector);
    }

    public static function Routing() {
        $method = $_GET['method'] ?? null;
        $json = $_GET['json'] ?? '';

        if (!$method) {
            echo json_encode(["error" => "Missing 'method' parameter"]);
            return;
        }

        $dbOperations = new self();

        if ($method !== 'display' && !$json) {
            echo json_encode(["error" => "Missing 'json' parameter for method '{$method}'"]);
            return;
        }

        $array = ($json) ? json_decode($json, true) : [];


        switch ($method) {
            case 'insert':
                $dbOperations->InsertUser($array);
                break;
            case 'update':
                $id = $array['id_utilisateur'] ?? null;
                if ($id === null) {
                    echo json_encode(["error" => "Missing 'id_utilisateur' for update"]);
                    return;
                }
                $dbOperations->UpdateUser($id, $array);
                break;
            case 'delete':
                $id = $array['id_utilisateur'] ?? null;
                if ($id === null) {
                    echo json_encode(["error" => "Missing 'id_utilisateur' for delete"]);
                    return;
                }
                $dbOperations->DeleteUser($id);
                break;
            case 'display':
                $dbOperations->DisplayUsers();
                break;
            default:
                echo json_encode(["error" => "Unknown method"]);
                return;
        }
    }


    public function InsertUser($userData) {

        if (!isset($userData['mot_de_passe'])) {
            echo json_encode(["error" => "Password is missing"]);
            return;
        }

        $userData['mot_de_passe'] = password_hash($userData['mot_de_passe'], PASSWORD_DEFAULT);

        $this->dbOperations->Insert2('utilisateur', $userData);
    }


    public function UpdateUser($id, $updateData) {
        $criteria = ['id_utilisateur' => $id];
        $this->dbOperations->Update('utilisateur', $updateData, $criteria);
    }

    public function DeleteUser($id) {
        $criteria = ['id_utilisateur' => $id];
        $this->dbOperations->Delete2('utilisateur', $criteria);
    }

    public function DisplayUsers() {
        header('Content-Type: application/json');
        $where = [];
        if (isset($_GET['id'])) {
            $where['id_utilisateur'] = $_GET['id'];
        }
        if (isset($_GET['nom'])) {
            $where['nom'] = $_GET['nom'];
        }
        $rows = $this->dbOperations->Display("utilisateur", $where);
        echo json_encode($rows);
    }


}


