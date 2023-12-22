<?php

namespace api\src\Library;

class SecLib
{

    public static function GetCredentials($fileName){

        $path = $_SERVER['DOCUMENT_ROOT'] . '/../mot_de_passe/' . $fileName;

        return json_decode(file_get_contents($path));

    }

}