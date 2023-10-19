<?php

namespace api\src\Controller;

require_once(__DIR__ . "/../Library/ArrayLib.php");

class EndPoint {

    static function Routing() {

        $method = $_GET['method'] ?? null;
        $json = $_GET['json'] ?? null;


        if (!$method || !$json) {
            echo json_encode(["error" => "Missing 'method' or 'json' parameter"]);
            return;
        }


        $array = json_decode($json, true);

        if ($array === null) {
            echo json_encode(["error" => "Invalid JSON"]);
            return;
        }

        switch ($method) {
            case 'bubblesort':
                $result = \api\src\library\ArrayLib::BubbleSort($array);
                break;
            case 'insertionsort':
                $result = \api\src\library\ArrayLib::InsertionSort($array);
                break;
            case 'quicksort':
                $result = \api\src\library\ArrayLib::QuickSort($array);
                break;
            default:
                echo json_encode(["error" => "Unknown method"]);
                return;
        }


        echo json_encode($result);
    }
}
