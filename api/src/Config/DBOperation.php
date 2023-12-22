<?php

namespace api\src\Config;

use PDO;
use PDOException;

class DBOperation
{

    private $connection;

    public function __construct(Connection $connector) {
        $this->connection = $connector->getConnection();
    }

    public function Display($tableName) {
        try {
            $stmt = $this->connection->query("SELECT * FROM " . $tableName);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "An error occurred while displaying records: " . $e->getMessage()];
        }
    }
    
    public function Insert2($table, $data) {

        if ($this->connection === null) {
            $this->connect();
        }

        $keys = array_keys($data);
        $fields = '`' . implode('`, `', $keys) . '`';
        $placeholders = ':' . implode(', :', $keys);

        $sql = "INSERT INTO `$table` ($fields) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);

        foreach ($data as $key => &$val) {
            $stmt->bindParam(":$key", $val);
        }

        $stmt->execute();
    }


    function Delete2($table, $where) {

        if ($this->connection === null) {
            $this->connect();
        }

        $conditions = array_map(function($key) {
            return "`$key` = :$key";
        }, array_keys($where));
        $conditions = implode(' AND ', $conditions);

        $sql = "DELETE FROM `$table` WHERE $conditions";
        $stmt = $this->connection->prepare($sql);

        foreach ($where as $key => $val) {
            $stmt->bindParam(":$key", $val);
        }

        $stmt->execute();
    }

    function Update($table, $data, $where) {

        if ($this->connection === null) {
            $this->connect();
        }

        $updateFields = array_map(function($key) {
            return "`$key` = :update_$key";
        }, array_keys($data));
        $updateFields = implode(', ', $updateFields);

        $conditions = array_map(function($key) {
            return "`$key` = :where_$key";
        }, array_keys($where));
        $conditions = implode(' AND ', $conditions);

        $sql = "UPDATE `$table` SET $updateFields WHERE $conditions";
        $stmt = $this->connection->prepare($sql);

        foreach ($data as $key => $val) {
            $stmt->bindValue(":update_$key", $val);
        }
        foreach ($where as $key => $val) {
            $stmt->bindValue(":where_$key", $val);
        }

        $stmt->execute();
    }







}