<?php

namespace api\src\Config;

use PDO;
use PDOException;

class DBOperation {

    private $connection;

    public function __construct(Connection $connector) {
        $this->connection = $connector->getConnection();
    }

    public function Display($tableName, $where = null) {
        try {
            $sql = "SELECT * FROM $tableName";
            if ($where) {
                $conditions = array_map(function ($key) {
                    return "$key = :$key";
                }, array_keys($where));
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
            $stmt = $this->connection->prepare($sql);

            if ($where) {
                foreach ($where as $key => $val) {
                    $stmt->bindValue(":$key", $val);
                }
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "An error occurred while displaying records: " . $e->getMessage()];
        }
    }

    public function Insert2($table, $data) {
        $keys = array_keys($data);
        $fields = '' . implode(', ', $keys) . '';
        $placeholders = ':' . implode(', :', $keys);

        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);

        foreach ($data as $key => &$val) {
            $stmt->bindParam(":$key", $val);
        }

        $stmt->execute();
    }

    public function Delete2($table, $where) {
        $conditions = array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($where));
        $conditions = implode(' AND ', $conditions);

        $sql = "DELETE FROM $table WHERE $conditions";
        $stmt = $this->connection->prepare($sql);

        foreach ($where as $key => $val) {
            $stmt->bindParam(":$key", $val);
        }

        $stmt->execute();
    }

    public function Update($table, $data, $where) {
        $updateFields = array_map(function ($key) {
            return "$key = :update_$key";
        }, array_keys($data));
        $updateFields = implode(', ', $updateFields);

        $conditions = array_map(function ($key) {
            return "$key = :where_$key";
        }, array_keys($where));
        $conditions = implode(' AND ', $conditions);

        $sql = "UPDATE $table SET $updateFields WHERE $conditions";
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
